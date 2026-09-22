<?php
/**
 * AWS Secrets Manager Helper for Karfect Application
 * 
 * Fetches and parses secrets from AWS Secrets Manager using the AWS SDK for PHP,
 * with a fallback mechanism and in-memory static caching.
 */

class AWSSecretsManager
{
    /**
     * Cache for retrieved secrets during script execution
     * @var array
     */
    private static $cache = [];

    /**
     * Fetch a secret by name from AWS Secrets Manager
     * 
     * @param string $secretName The name or ARN of the secret
     * @param string $region The AWS region (e.g. 'us-east-1')
     * @param string|null $accessKey Optional AWS Access Key ID
     * @param string|null $secretKey Optional AWS Secret Access Key
     * @return array|string Parsed JSON array or raw secret string
     * @throws Exception If secret retrieval fails
     */
    public static function getSecret(string $secretName, string $region = 'us-east-1', ?string $accessKey = null, ?string $secretKey = null)
    {
        $cacheKey = $region . ':' . $secretName;
        if (isset(self::$cache[$cacheKey])) {
            return self::$cache[$cacheKey];
        }

        // Try using official AWS SDK if available
        if (class_exists('Aws\SecretsManager\SecretsManagerClient')) {
            $clientConfig = [
                'version' => 'latest',
                'region'  => $region,
            ];

            if (!empty($accessKey) && !empty($secretKey)) {
                $clientConfig['credentials'] = [
                    'key'    => $accessKey,
                    'secret' => $secretKey,
                ];
            }

            $client = new Aws\SecretsManager\SecretsManagerClient($clientConfig);
            $result = $client->getSecretValue([
                'SecretId' => $secretName,
            ]);

            if (isset($result['SecretString'])) {
                $secret = $result['SecretString'];
            } else {
                $secret = base64_decode($result['SecretBinary']);
            }
        } else {
            // Fallback: Using cURL with AWS Signature V4 API request if AWS SDK is not loaded
            $secret = self::getSecretViaRestApi($secretName, $region, $accessKey, $secretKey);
        }

        // Parse JSON secret payload if applicable
        $jsonParsed = json_decode($secret, true);
        $finalData = (json_last_error() === JSON_ERROR_NONE && is_array($jsonParsed)) ? $jsonParsed : $secret;

        self::$cache[$cacheKey] = $finalData;
        return $finalData;
    }

    /**
     * Get Database Credentials array from AWS Secret
     * Maps common JSON keys (host, username, password, dbname, port)
     * 
     * @param string $secretName
     * @param string $region
     * @param string|null $accessKey
     * @param string|null $secretKey
     * @return array Containing host, user, pass, dbname, port
     */
    public static function getDatabaseCredentials(string $secretName, string $region = 'us-east-1', ?string $accessKey = null, ?string $secretKey = null): array
    {
        $secret = self::getSecret($secretName, $region, $accessKey, $secretKey);

        if (!is_array($secret)) {
            throw new Exception("Secret '{$secretName}' is not a valid JSON object.");
        }

        // Extract credentials using flexible key aliases
        $host   = $secret['host'] ?? $secret['hostname'] ?? $secret['DB_HOST'] ?? $secret['db_host'] ?? 'localhost';
        $user   = $secret['username'] ?? $secret['user'] ?? $secret['DB_USER'] ?? $secret['db_user'] ?? 'root';
        $pass   = $secret['password'] ?? $secret['pass'] ?? $secret['DB_PASS'] ?? $secret['db_pass'] ?? '';
        $dbname = $secret['dbname'] ?? $secret['database'] ?? $secret['DB_NAME'] ?? $secret['db_name'] ?? '';
        $port   = $secret['port'] ?? $secret['DB_PORT'] ?? $secret['db_port'] ?? 3306;

        return [
            'host'   => $host,
            'user'   => $user,
            'pass'   => $pass,
            'dbname' => $dbname,
            'port'   => (int)$port,
        ];
    }

    /**
     * Direct AWS Secrets Manager REST API request using AWS Signature V4 (Fallback mode)
     */
    private static function getSecretViaRestApi(string $secretName, string $region, ?string $accessKey, ?string $secretKey): string
    {
        if (empty($accessKey) || empty($secretKey)) {
            throw new Exception("AWS SDK not loaded and explicit AWS credentials (AWS_ACCESS_KEY_ID / AWS_SECRET_ACCESS_KEY) were not provided.");
        }

        $service = 'secretsmanager';
        $host = "secretsmanager.{$region}.amazonaws.com";
        $endpoint = "https://{$host}/";

        $payload = json_encode(['SecretId' => $secretName]);
        $date = gmdate('Ymd\THis\Z');
        $shortDate = gmdate('Ymd');

        $headers = [
            'content-type' => 'application/x-amz-json-1.1',
            'host' => $host,
            'x-amz-date' => $date,
            'x-amz-target' => 'secretsmanager.GetSecretValue',
        ];

        // Create Canonical Request & AWS SigV4 Authorization header
        ksort($headers);
        $canonicalHeaders = '';
        $signedHeaders = '';
        foreach ($headers as $k => $v) {
            $canonicalHeaders .= strtolower($k) . ':' . trim($v) . "\n";
            $signedHeaders .= strtolower($k) . ';';
        }
        $signedHeaders = rtrim($signedHeaders, ';');

        $payloadHash = hash('sha256', $payload);
        $canonicalRequest = "POST\n/\n\n" . $canonicalHeaders . "\n" . $signedHeaders . "\n" . $payloadHash;

        $algorithm = 'AWS4-HMAC-SHA256';
        $credentialScope = $shortDate . '/' . $region . '/' . $service . '/aws4_request';
        $stringToSign = $algorithm . "\n" . $date . "\n" . $credentialScope . "\n" . hash('sha256', $canonicalRequest);

        // Sign key
        $kSecret = 'AWS4' . $secretKey;
        $kDate = hash_hmac('sha256', $shortDate, $kSecret, true);
        $kRegion = hash_hmac('sha256', $region, $kDate, true);
        $kService = hash_hmac('sha256', $service, $kRegion, true);
        $kSigning = hash_hmac('sha256', 'aws4_request', $kService, true);
        $signature = hash_hmac('sha256', $stringToSign, $kSigning);

        $authorizationHeader = "{$algorithm} Credential={$accessKey}/{$credentialScope}, SignedHeaders={$signedHeaders}, Signature={$signature}";
        
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/x-amz-json-1.1",
            "Host: {$host}",
            "X-Amz-Date: {$date}",
            "X-Amz-Target: secretsmanager.GetSecretValue",
            "Authorization: {$authorizationHeader}"
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            throw new Exception("cURL error connecting to AWS Secrets Manager: " . $curlError);
        }

        if ($httpCode !== 200) {
            throw new Exception("AWS Secrets Manager API returned HTTP {$httpCode}: " . $response);
        }

        $result = json_decode($response, true);
        if (isset($result['SecretString'])) {
            return $result['SecretString'];
        } elseif (isset($result['SecretBinary'])) {
            return base64_decode($result['SecretBinary']);
        }

        throw new Exception("Failed to parse secret value from AWS response: " . $response);
    }
}

<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    // Set session cookie path to root to ensure it works across all paths
    session_set_cookie_params(0, '/');
    session_start();
}

// Load Composer Autoloader if available
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

// Load AWS Secrets Manager Helper
require_once __DIR__ . '/AWSSecretsManager.php';

// Load environment config
if (file_exists(__DIR__ . '/../env.php')) {
    require_once __DIR__ . '/../env.php';
}

// Define domain and base path if not already defined (e.g. from env.php)
if (!defined('DOMAIN')) {
    define('DOMAIN', 'https://sandip.qd.je');
}
if (!defined('BASE_PATH')) {
    define('BASE_PATH', DOMAIN . '/');
}

// Determine configuration values (env constants or environment variables)
$useAwsSecrets = defined('USE_AWS_SECRETS') ? USE_AWS_SECRETS : (getenv('USE_AWS_SECRETS') === 'true');
$awsRegion     = defined('AWS_REGION') ? AWS_REGION : (getenv('AWS_REGION') ?: 'us-east-1');
$awsSecretName = defined('AWS_SECRET_NAME') ? AWS_SECRET_NAME : getenv('AWS_SECRET_NAME');
$awsAccessKey  = defined('AWS_ACCESS_KEY_ID') ? AWS_ACCESS_KEY_ID : getenv('AWS_ACCESS_KEY_ID');
$awsSecretKey  = defined('AWS_SECRET_ACCESS_KEY') ? AWS_SECRET_ACCESS_KEY : getenv('AWS_SECRET_ACCESS_KEY');

$dbHost = defined('DB_HOST') ? DB_HOST : (getenv('DB_HOST') ?: 'localhost');
$dbUser = defined('DB_USER') ? DB_USER : (getenv('DB_USER') ?: 'root');
$dbPass = defined('DB_PASS') ? DB_PASS : (getenv('DB_PASS') ?: '');
$dbName = defined('DB_NAME') ? DB_NAME : (getenv('DB_NAME') ?: '');
$dbPort = defined('DB_PORT') ? DB_PORT : (getenv('DB_PORT') ?: 3306);

// Fetch credentials from AWS Secrets Manager if enabled
if ($useAwsSecrets && !empty($awsSecretName)) {
    try {
        $awsDbCreds = AWSSecretsManager::getDatabaseCredentials(
            $awsSecretName,
            $awsRegion,
            !empty($awsAccessKey) ? $awsAccessKey : null,
            !empty($awsSecretKey) ? $awsSecretKey : null
        );

        $dbHost = $awsDbCreds['host'];
        $dbUser = $awsDbCreds['user'];
        $dbPass = $awsDbCreds['pass'];
        $dbName = $awsDbCreds['dbname'];
        $dbPort = $awsDbCreds['port'];

        // Define DB constants dynamically if not defined yet
        if (!defined('DB_HOST')) define('DB_HOST', $dbHost);
        if (!defined('DB_USER')) define('DB_USER', $dbUser);
        if (!defined('DB_PASS')) define('DB_PASS', $dbPass);
        if (!defined('DB_NAME')) define('DB_NAME', $dbName);
        if (!defined('DB_PORT')) define('DB_PORT', $dbPort);
    } catch (Exception $e) {
        error_log("AWS Secrets Manager Error: " . $e->getMessage());
        // Fallback warning - if DB constants are defined, PDO connection attempt will proceed with local fallback
    }
}

// Define default DB constants if still undefined
if (!defined('DB_HOST')) define('DB_HOST', $dbHost);
if (!defined('DB_USER')) define('DB_USER', $dbUser);
if (!defined('DB_PASS')) define('DB_PASS', $dbPass);
if (!defined('DB_NAME')) define('DB_NAME', $dbName);
if (!defined('DB_PORT')) define('DB_PORT', $dbPort);

try {
    $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";
    $conn = new PDO($dsn, $dbUser, $dbPass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection failed: " . $e->getMessage());
}
?>

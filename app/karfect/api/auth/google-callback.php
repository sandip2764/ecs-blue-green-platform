<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../../includes/db_config.php';

$clientId = GOOGLE_CLIENT_ID;
$clientSecret = GOOGLE_CLIENT_SECRET;
$redirectUri = BASE_PATH . 'api/auth/google-callback.php';

header('Content-Type: application/json');

try {
    if (isset($_GET['code'])) {
        $code = $_GET['code'];
        $tokenUrl = 'https://oauth2.googleapis.com/token';
        $postData = [
            'code' => $code,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code'
        ];

        $ch = curl_init($tokenUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        $response = curl_exec($ch);
        if ($response === false) {
            echo json_encode(['status' => 'error', 'message' => 'CURL Error: ' . curl_error($ch)]);
            curl_close($ch);
            exit;
        }
        curl_close($ch);

        $data = json_decode($response, true);
        if (isset($data['access_token'])) {
            $userInfoUrl = 'https://www.googleapis.com/oauth2/v3/userinfo';
            $ch = curl_init($userInfoUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $data['access_token']]);
            $userInfo = curl_exec($ch);
            curl_close($ch);

            $user = json_decode($userInfo, true);
            $email = $user['email'];
            $name = $user['name'];

            $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $userId = $stmt->fetchColumn();

            if ($userId) {
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_name'] = $name;
            } else {
                $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
                $stmt->execute(['name' => $name, 'email' => $email]);
                $_SESSION['user_id'] = $conn->lastInsertId();
                $_SESSION['user_name'] = $name;
            }

            $cookie_name = "user_login";
            $cookie_value = $_SESSION['user_id'] . '|' . $name;
            $cookie_expiry = time() + (30 * 24 * 60 * 60);
            setcookie($cookie_name, $cookie_value, $cookie_expiry, '/');

            header('Location: ' . BASE_PATH . 'index.php');
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error getting access token', 'response' => $data]);
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No code received from Google']);
        exit;
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
?>

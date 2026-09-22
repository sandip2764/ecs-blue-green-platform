<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require './db_config.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
            exit;
        }

        if (empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Password is required']);
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            $cookie_name = "user_login";
            $cookie_value = $user['id'] . '|' . $user['name'];
            $cookie_expiry = time() + (30 * 24 * 60 * 60);
            setcookie($cookie_name, $cookie_value, $cookie_expiry, BASE_PATH);

            echo json_encode(['status' => 'success', 'message' => 'Login successful']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
?>
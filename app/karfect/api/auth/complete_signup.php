<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../../includes/db_config.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_SESSION['email'] ?? '';
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($email)) {
            echo json_encode(['status' => 'error', 'message' => 'Session email missing']);
            exit;
        }
        if (empty($name)) {
            echo json_encode(['status' => 'error', 'message' => 'Name is required']);
            exit;
        }
        if ($password !== $confirm_password) {
            echo json_encode(['status' => 'error', 'message' => 'Passwords do not match']);
            exit;
        }
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/', $password)) {
            echo json_encode(['status' => 'error', 'message' => 'Password must be 8+ chars with 1 uppercase, 1 number, 1 special char']);
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hashed_password]);

        $user_id = $conn->lastInsertId();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;

        unset($_SESSION['otp']);
        unset($_SESSION['email']);
        echo json_encode(['status' => 'success', 'message' => 'Signup completed']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../../includes/db_config.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_otp = filter_var($_POST['otp'], FILTER_SANITIZE_STRING);
        $email = $_SESSION['email'] ?? '';

        if (empty($email)) {
            echo json_encode(['status' => 'error', 'message' => 'Session email missing']);
            exit;
        }
        if (empty($user_otp)) {
            echo json_encode(['status' => 'error', 'message' => 'OTP is required']);
            exit;
        }
        if (!isset($_SESSION['otp']) || $user_otp != $_SESSION['otp']) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid OTP']);
            exit;
        }

        echo json_encode(['status' => 'success', 'message' => 'OTP verified']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
?>
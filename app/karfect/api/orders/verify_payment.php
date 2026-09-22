<?php
require '../../includes/db_config.php';

header('Content-Type: application/json');

// Debug session
error_log("Verify Payment - Session ID: " . session_id());
error_log("Verify Payment - User ID: " . ($_SESSION['user_id'] ?? 'Not set'));

$razorpay_payment_id = $_POST['razorpay_payment_id'] ?? '';
$razorpay_order_id = $_POST['razorpay_order_id'] ?? '';
$razorpay_signature = $_POST['razorpay_signature'] ?? '';

$key_secret = 'ndRaBO5CoVIJsYDJwuEdowvy';
$generated_signature = hash_hmac('sha256', $razorpay_order_id . '|' . $razorpay_payment_id, $key_secret);

if ($generated_signature === $razorpay_signature) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid signature']);
}
?>
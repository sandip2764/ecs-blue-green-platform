<?php
require '../../includes/db_config.php';

header('Content-Type: application/json');

// Debug session
error_log("Session ID: " . session_id());
error_log("User ID: " . ($_SESSION['user_id'] ?? 'Not set'));

if (!isset($_SESSION['user_id'])) {
    error_log("User not logged in - Session data: " . print_r($_SESSION, true));
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$amount = $_POST['amount'] ?? 0;
if ($amount <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid amount']);
    exit;
}

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api.razorpay.com/v1/orders',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_USERPWD => 'rzp_test_kOQpzpZ1wKCAs7:ndRaBO5CoVIJsYDJwuEdowvy',
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode([
        'amount' => $amount,
        'currency' => 'INR',
        'receipt' => 'order_' . time()
    ])
]);

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);
if (isset($data['id'])) {
    echo json_encode(['status' => 'success', 'razorpay_order_id' => $data['id']]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to create Razorpay order']);
}
?>
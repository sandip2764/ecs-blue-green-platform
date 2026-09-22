<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../../includes/db_config.php';

header('Content-Type: application/json');

// Debug session
error_log("Save Order - Session ID: " . session_id());
error_log("Save Order - User ID: " . ($_SESSION['user_id'] ?? 'Not set'));

if (!isset($_SESSION['user_id'])) {
    error_log("Save Order - User not logged in - Session data: " . print_r($_SESSION, true));
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$razorpay_order_id = $_POST['razorpay_order_id'] ?? '';
$payment_id = $_POST['payment_id'] ?? '';
$amount = $_POST['amount'] ?? 0;

if (!$razorpay_order_id || !$payment_id || $amount <= 0) {
    error_log("Save Order - Invalid payment details: " . print_r($_POST, true));
    echo json_encode(['status' => 'error', 'message' => 'Invalid payment details']);
    exit;
}

// Fetch default address
$stmt = $conn->prepare("SELECT * FROM addresses WHERE user_id = ? AND is_default = 1 LIMIT 1");
$stmt->execute([$_SESSION['user_id']]);
$address = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$address) {
    error_log("Save Order - No default address found for user: " . $_SESSION['user_id']);
    echo json_encode(['status' => 'error', 'message' => 'No default address found']);
    exit;
}

// Validate address fields
if (!isset($address['latitude']) || !isset($address['longitude']) || !isset($address['address'])) {
    error_log("Save Order - Address fields missing: " . print_r($address, true));
    echo json_encode(['status' => 'error', 'message' => 'Address data incomplete']);
    exit;
}

// Fetch cart total and items
$stmt = $conn->prepare("SELECT c.service_id, c.quantity, c.image, s.title, s.discounted_price as price FROM cart c JOIN services s ON c.service_id = s.id WHERE c.user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$cart_items) {
    error_log("Save Order - Cart is empty for user: " . $_SESSION['user_id']);
    echo json_encode(['status' => 'error', 'message' => 'Cart is empty']);
    exit;
}

$cart_total = 0;
foreach ($cart_items as $item) {
    $cart_total += $item['quantity'] * $item['price'];
}

$total_amount = $cart_total * 1.18; // Including GST

try {
    $conn->beginTransaction();

    // Save order
    $stmt = $conn->prepare("INSERT INTO orders (order_id, user_id, total_amount, status, latitude, longitude, address, created_at) VALUES (?, ?, ?, 'Pending', ?, ?, ?, NOW())");
    $stmt->execute([$razorpay_order_id, $_SESSION['user_id'], $total_amount, $address['latitude'], $address['longitude'], $address['address']]);

    // Save order items
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, service_id, title, quantity, price, image) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($cart_items as $item) {
        $stmt->execute([$razorpay_order_id, $item['service_id'], $item['title'], $item['quantity'], $item['price'], $item['image']]);
    }

    // Save transaction
    $transaction_id = 'txn_' . time();
    $stmt = $conn->prepare("INSERT INTO transactions (transaction_id, order_id, razorpay_order_id, payment_id, amount, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, 'Success', NOW(), NOW())");
    $stmt->execute([$transaction_id, $razorpay_order_id, $razorpay_order_id, $payment_id, $amount]);

    // Update order status to Success
    $stmt = $conn->prepare("UPDATE orders SET status = 'Success' WHERE order_id = ? AND user_id = ?");
    $stmt->execute([$razorpay_order_id, $_SESSION['user_id']]);

    // Clear cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);

    // Set order_id in session for order_success.php
    $_SESSION['order_id'] = $razorpay_order_id;

    $conn->commit();
    echo json_encode(['status' => 'success', 'order_id' => $razorpay_order_id]);
} catch (Exception $e) {
    $conn->rollBack();
    error_log("Save Order - Error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Failed to save order: ' . $e->getMessage()]);
}
?>
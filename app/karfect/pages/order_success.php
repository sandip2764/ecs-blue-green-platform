<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../includes/db_config.php';
require '../includes/send_order_email.php';
require '../includes/generate_invoice.php';

// Check if order_id is set
if (!isset($_SESSION['order_id'])) {
    header('Location: ' . BASE_PATH . 'index.php');
    exit;
}

$order_id = $_SESSION['order_id'];

// Fetch order details (using PDO)
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->execute([$order_id]);
$order_details = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order_details) {
    die("Order not found.");
}

// Fetch user details
$user_id = $order_details['user_id'];
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?"); // Fixed: user_id to id
$stmt->execute([$user_id]);
$user_details = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user_details) {
    die("User not found.");
}

// Fetch order items
$stmt = $conn->prepare("SELECT title as product_name, quantity, price as unit_price FROM order_items WHERE order_id = ?");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Send email
$email_result = sendOrderEmail($order_details, $user_details, $order_items);

// Generate invoice
$invoice = generateInvoice($order_details, $user_details, $order_items);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success - Karfect</title>
    <link href="https://api.fontshare.com/v2/css?f[]=synonym@400&f[]=amulya@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/header.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_PATH; ?>favicon.ico?v=<?php echo time(); ?>">
    <style>
        .order-success-container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            text-align: center;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .order-success-container h2 {
            font-family: "Geist", sans-serif;
            font-size: 24px;
            color: #18181B;
            margin-bottom: 20px;
        }
        .order-success-container p {
            font-family: "Geist", sans-serif;
            font-size: 16px;
            color: #757575;
            margin-bottom: 20px;
        }
        .download-invoice-btn, .track-order-btn {
            display: inline-block;
            padding: 10px 20px;
            font-family: "Geist", sans-serif;
            font-size: 14px;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.2s ease, transform 0.2s ease;
            margin: 10px;
        }
        .download-invoice-btn {
            background-color: #6b48ff;
            color: #fff;
        }
        .download-invoice-btn:hover {
            background-color: #5a3de6;
            transform: scale(1.02);
        }
        .track-order-btn {
            background-color: #18181B;
            color: #fff;
        }
        .track-order-btn:hover {
            background-color: #333;
            transform: scale(1.02);
        }
        @media (max-width: 768px) {
            .order-success-container {
                margin: 80px auto;
                padding: 15px;
            }
            .order-success-container h2 {
                font-size: 20px;
            }
            .order-success-container p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="order-success-container">
        <h2>Order Placed Successfully!</h2>
        <p>Thank you for your order, <?php echo htmlspecialchars($user_details['name']); ?>! Your order #<?php echo htmlspecialchars($order_id); ?> has been placed.</p>
        <p>
            <?php
            if ($email_result['status'] === 'success') {
                echo "Check your email (" . htmlspecialchars($user_details['email']) . ") for order details.";
            } else {
                echo "Order placed, but failed to send email. Please check your account for details.";
            }
            ?>
        </p>
        <a href="#" class="download-invoice-btn" onclick="document.getElementById('invoice-form').submit(); return false;">Download Invoice</a>
        <a href="<?php echo BASE_PATH; ?>pages/order-tracking.php?order_id=<?php echo htmlspecialchars($order_id); ?>" class="track-order-btn">Track Your Order</a>
    </div>

    <form id="invoice-form" method="post" action="<?php echo BASE_PATH; ?>includes/download_invoice.php" style="display: none;">
        <input type="hidden" name="latex_content" value="<?php echo htmlspecialchars($invoice['content']); ?>">
        <input type="hidden" name="filename" value="<?php echo htmlspecialchars($invoice['filename']); ?>">
    </form>
</body>
</html>
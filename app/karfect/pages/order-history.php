<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../includes/db_config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Fetch user's orders
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Karfect</title>
    <link href="https://api.fontshare.com/v2/css?f[]=synonym@400&f[]=amulya@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/karfect-cart.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_PATH; ?>favicon.ico?v=<?php echo time(); ?>">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="order-history-container">
        <h2>Order History</h2>
        <?php if ($orders): ?>
            <div class="order-list">
                <?php foreach ($orders as $order): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-info">
                                <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['order_id']); ?></p>
                                <p><strong>Placed On:</strong> <?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></p>
                                <p><strong>Total Amount:</strong> ₹<?php echo number_format($order['total_amount'], 2); ?></p>
                                <p><strong>Status:</strong> <span class="status-box status-<?php echo strtolower($order['status']); ?>"><?php echo htmlspecialchars($order['status']); ?></span></p>
                            </div>
                            <button class="toggle-details">Details ▼</button>
                        </div>
                        <div class="order-items" style="display: none;">
                            <?php
                            // Fetch order items
                            $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
                            $stmt->execute([$order['order_id']]);
                            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <?php if ($items): ?>
                                <?php foreach ($items as $item): ?>
                                    <div class="order-item">
                                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="item-image">
                                        <div class="item-details">
                                            <p class="item-title"><?php echo htmlspecialchars($item['title']); ?></p>
                                            <p class="item-quantity">Quantity: <?php echo $item['quantity']; ?></p>
                                            <p class="item-price">₹<?php echo number_format($item['price'], 2); ?> × <?php echo $item['quantity']; ?> = ₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No items found for this order.</p>
                            <?php endif; ?>
                            <a href="<?php echo BASE_PATH; ?>pages/order-tracking.php?order_id=<?php echo urlencode($order['order_id']); ?>" class="view-tracking-button">Track Order</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="no-orders">No orders found.</p>
        <?php endif; ?>
    </div>

    <script src="<?php echo BASE_PATH; ?>assets/js/karfect-cart.js?v=<?php echo time(); ?>"></script>
</body>
</html>
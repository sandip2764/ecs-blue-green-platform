<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../../includes/db_config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../login.php');
    exit;
}

// Fetch default address
$stmt = $conn->prepare("SELECT * FROM addresses WHERE user_id = ? AND is_default = 1 LIMIT 1");
$stmt->execute([$_SESSION['user_id']]);
$default_address = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Karfect</title>
    <link href="https://api.fontshare.com/v2/css?f[]=synonym@400&f[]=amulya@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/cart.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/karfect-cart.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_PATH; ?>favicon.ico?v=<?php echo time(); ?>">
</head>
<body>
    <?php include '../../includes/header.php'; ?>

    <div class="cart-container">
        <!-- Address Container -->
        <div class="address-container">
            <h3>Delivery Address</h3>
            <?php if ($default_address): ?>
                <div class="address-details">
                    <p><strong><?php echo htmlspecialchars($default_address['name']); ?></strong></p>
                    <p><?php echo htmlspecialchars($default_address['address']); ?><?php echo $default_address['landmark'] ? ', ' . htmlspecialchars($default_address['landmark']) : ''; ?></p>
                    <p>Phone: <?php echo htmlspecialchars($default_address['phone']); ?></p>
                </div>
                <button class="change-address-button">Change Address</button>
            <?php else: ?>
                <p>No default address set. <a href="<?php echo BASE_PATH; ?>pages/manage-address.php">Add an address</a></p>
            <?php endif; ?>
        </div>

        <!-- Address Modal -->
        <div class="address-modal" id="addressModal" style="display: none;">
            <div class="address-modal-content">
                <span class="close-modal">&times;</span>
                <h3>Select Delivery Address</h3>
                <div class="address-list">
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM addresses WHERE user_id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    $addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($addresses):
                        foreach ($addresses as $address):
                    ?>
                        <div class="address-option" data-address-id="<?php echo $address['id']; ?>">
                            <p><strong><?php echo htmlspecialchars($address['name']); ?></strong></p>
                            <p><?php echo htmlspecialchars($address['address']); ?><?php echo $address['landmark'] ? ', ' . htmlspecialchars($address['landmark']) : ''; ?></p>
                            <p>Phone: <?php echo htmlspecialchars($address['phone']); ?></p>
                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <p>No addresses found. <a href="<?php echo BASE_PATH; ?>pages/manage-address.php">Add an address</a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <h2>Your Cart</h2>
        <div class="cart-items">
            <?php
            $stmt = $conn->prepare("
                SELECT c.id, c.service_id, c.quantity, c.image, s.title, s.discounted_price
                FROM cart c
                JOIN services s ON c.service_id = s.id
                WHERE c.user_id = ?
            ");
            $stmt->execute([$_SESSION['user_id']]);
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $subtotal = 0;
            if ($items):
                foreach ($items as $item):
                    $item_total = $item['quantity'] * $item['discounted_price'];
                    $subtotal += $item_total;
            ?>
                <div class="cart-item" data-cart-id="<?php echo $item['id']; ?>">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="cart-item-image">
                    <div class="cart-item-details">
                        <span class="cart-item-title"><?php echo htmlspecialchars($item['title']); ?></span>
                        <span class="cart-item-price">₹<?php echo number_format($item['discounted_price'], 2); ?> x <?php echo $item['quantity']; ?></span>
                        <div class="cart-item-quantity">
                            <button class="cart-quantity-button decrease" data-cart-id="<?php echo $item['id']; ?>">-</button>
                            <span class="cart-quantity-display"><?php echo $item['quantity']; ?></span>
                            <button class="cart-quantity-button increase" data-cart-id="<?php echo $item['id']; ?>">+</button>
                        </div>
                    </div>
                    <button class="cart-item-remove" data-cart-id="<?php echo $item['id']; ?>">Remove</button>
                </div>
            <?php endforeach; ?>
            <?php else: ?>
                <p>Your cart is empty</p>
            <?php endif; ?>
        </div>
        <div class="cart-summary">
            <div class="cart-subtotal">
                <span>Subtotal</span>
                <span class="cart-subtotal-amount">₹<?php echo number_format($subtotal, 2); ?></span>
            </div>
            <div class="cart-gst">
                <span>GST (18%)</span>
                <span class="cart-gst-amount">₹<?php echo number_format($subtotal * 0.18, 2); ?></span>
            </div>
            <div class="cart-total">
                <span>Total</span>
                <span class="cart-total-amount">₹<?php echo number_format($subtotal * 1.18, 2); ?></span>
            </div>
            <button class="cart-checkout-button" data-total="<?php echo $subtotal * 1.18; ?>" <?php echo $default_address ? '' : 'disabled'; ?>>Proceed to Checkout</button>
            <?php if (!$default_address): ?>
                <p class="error-message">Please add a default address to proceed.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Success Popup -->
    <div class="success-popup" id="successPopup" style="display: none;">
        <div class="success-popup-content">
            <div class="checkmark-circle">
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark-circle-fill" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
            </div>
            <h3>Order Placed Successfully!</h3>
            <p>Your order has been placed. Track your order now.</p>
            <button class="track-order-button" id="trackOrderButton">Track Your Order</button>
        </div>
    </div>

    <!-- Razorpay Script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="<?php echo BASE_PATH; ?>assets/js/cart.js?v=<?php echo time(); ?>"></script>
    <script src="<?php echo BASE_PATH; ?>assets/js/karfect-cart.js?v=<?php echo time(); ?>"></script>
</body>
</html>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../../includes/db_config.php';

header('Content-Type: application/json');

try {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please login to add to cart']);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $service_id = filter_var($_POST['service_id'], FILTER_VALIDATE_INT);
        $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT, ['options' => ['default' => 1, 'min_range' => 1]]);

        if (!$service_id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid service ID']);
            exit;
        }

        $stmt = $conn->prepare("SELECT id, image FROM services WHERE id = ?");
        $stmt->execute([$service_id]);
        $service = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$service) {
            echo json_encode(['status' => 'error', 'message' => 'Service not found']);
            exit;
        }

        $stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND service_id = ?");
        $stmt->execute([$_SESSION['user_id'], $service_id]);
        $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart_item) {
            $new_quantity = $cart_item['quantity'] + $quantity;
            $stmt = $conn->prepare("UPDATE cart SET quantity = ?, image = ? WHERE id = ?");
            $stmt->execute([$new_quantity, $service['image'], $cart_item['id']]);
        } else {
            $stmt = $conn->prepare("INSERT INTO cart (user_id, service_id, quantity, image) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $service_id, $quantity, $service['image']]);
        }

        echo json_encode(['status' => 'success', 'message' => 'Added to cart']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
?>
<?php
// Turn off error reporting to prevent HTML output in JSON
error_reporting(0);
ini_set('display_errors', 0);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../../includes/db_config.php';

header('Content-Type: application/json');

try {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please login']);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $service_id = filter_var($_POST['service_id'] ?? 0, FILTER_VALIDATE_INT);
        $cart_id = filter_var($_POST['cart_id'] ?? 0, FILTER_VALIDATE_INT);
        $quantity = filter_var($_POST['quantity'] ?? 0, FILTER_VALIDATE_INT);

        if ($quantity < 1) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid quantity']);
            exit;
        }

        if ($service_id > 0) {
            $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND service_id = ?");
            $stmt->execute([$quantity, $_SESSION['user_id'], $service_id]);
        } else if ($cart_id > 0) {
            $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
            $stmt->execute([$quantity, $cart_id, $_SESSION['user_id']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid cart or service ID']);
            exit;
        }

        echo json_encode(['status' => 'success', 'message' => 'Cart updated']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
?>
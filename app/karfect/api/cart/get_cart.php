<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../../includes/db_config.php';

header('Content-Type: application/json');

try {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'items' => [], 'subtotal' => 0, 'gst' => 0, 'total' => 0]);
        exit;
    }

    $stmt = $conn->prepare("
        SELECT c.id, c.service_id, c.quantity, s.title, s.discounted_price, s.image
        FROM cart c
        JOIN services s ON c.service_id = s.id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $subtotal = 0;
    foreach ($items as &$item) {
        $item['total_price'] = $item['quantity'] * $item['discounted_price'];
        $subtotal += $item['total_price'];
    }
    $gst = $subtotal * 0.18;
    $total = $subtotal + $gst;

    echo json_encode([
        'status' => 'success',
        'items' => $items,
        'subtotal' => number_format($subtotal, 2),
        'gst' => number_format($gst, 2),
        'total' => number_format($total, 2)
    ]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
?>
<?php
session_start();
header('Content-Type: application/json');

include '../../includes/db_config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);

try {
    // Reset all addresses to non-default
    $stmt = $conn->prepare("UPDATE addresses SET is_default = 0 WHERE user_id = ?");
    $stmt->execute([$user_id]);

    // Set the selected address as default
    $stmt = $conn->prepare("UPDATE addresses SET is_default = 1 WHERE id = ? AND user_id = ?");
    $stmt->execute([$data['addressId'], $user_id]);

    echo json_encode(['success' => true, 'message' => 'Default address set successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error setting default address: ' . $e->getMessage()]);
}
?>
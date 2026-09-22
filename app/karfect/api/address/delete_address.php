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
    $stmt = $conn->prepare("DELETE FROM addresses WHERE id = ? AND user_id = ?");
    $stmt->execute([$data['addressId'], $user_id]);

    echo json_encode(['success' => true, 'message' => 'Address deleted successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error deleting address: ' . $e->getMessage()]);
}
?>
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
    $stmt = $conn->prepare("UPDATE addresses SET name = ?, phone = ?, address = ?, landmark = ?, type = ?, latitude = ?, longitude = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([
        $data['name'],
        $data['phone'],
        $data['address'],
        $data['landmark'] ?: null,
        $data['type'],
        $data['latitude'],
        $data['longitude'],
        $data['addressId'],
        $user_id
    ]);

    echo json_encode(['success' => true, 'message' => 'Address updated successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error updating address: ' . $e->getMessage()]);
}
?>
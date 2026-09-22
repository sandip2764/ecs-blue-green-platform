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
    // Check if user already has 5 addresses
    $stmt = $conn->prepare("SELECT COUNT(*) FROM addresses WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $count = $stmt->fetchColumn();

    if ($count >= 5) {
        echo json_encode(['success' => false, 'message' => 'You can only add up to 5 addresses']);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO addresses (user_id, name, phone, address, landmark, type, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $user_id,
        $data['name'],
        $data['phone'],
        $data['address'],
        $data['landmark'] ?: null,
        $data['type'],
        $data['latitude'],
        $data['longitude']
    ]);

    echo json_encode(['success' => true, 'message' => 'Address added successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error adding address: ' . $e->getMessage()]);
}
?>
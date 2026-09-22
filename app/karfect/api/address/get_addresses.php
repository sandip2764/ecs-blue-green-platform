<?php
session_start();
header('Content-Type: application/json');

include '../../includes/db_config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("SELECT * FROM addresses WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'addresses' => $addresses]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error fetching addresses: ' . $e->getMessage()]);
}
?>
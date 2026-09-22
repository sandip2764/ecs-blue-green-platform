<?php
require '../../includes/db_config.php';

header('Content-Type: application/json');

// Debug session
error_log("Update Default Address - Session ID: " . session_id());
error_log("Update Default Address - User ID: " . ($_SESSION['user_id'] ?? 'Not set'));

if (!isset($_SESSION['user_id'])) {
    error_log("Update Default Address - User not logged in - Session data: " . print_r($_SESSION, true));
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$address_id = $_POST['address_id'] ?? '';
if (!$address_id) {
    echo json_encode(['status' => 'error', 'message' => 'Address ID is required']);
    exit;
}

try {
    $conn->beginTransaction();
    $stmt = $conn->prepare("UPDATE addresses SET is_default = 0 WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $stmt = $conn->prepare("UPDATE addresses SET is_default = 1 WHERE id = ? AND user_id = ?");
    $stmt->execute([$address_id, $_SESSION['user_id']]);
    $conn->commit();
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['status' => 'error', 'message' => 'Failed to update address']);
}
?>
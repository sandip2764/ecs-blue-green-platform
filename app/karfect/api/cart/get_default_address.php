<?php
require '../../includes/db_config.php';

header('Content-Type: application/json');

// Debug session
error_log("Get Default Address - Session ID: " . session_id());
error_log("Get Default Address - User ID: " . ($_SESSION['user_id'] ?? 'Not set'));

if (!isset($_SESSION['user_id'])) {
    error_log("Get Default Address - User not logged in - Session data: " . print_r($_SESSION, true));
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM addresses WHERE user_id = ? AND is_default = 1 LIMIT 1");
$stmt->execute([$_SESSION['user_id']]);
$address = $stmt->fetch(PDO::FETCH_ASSOC);

if ($address) {
    echo json_encode(['status' => 'success', 'address' => $address]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No default address found']);
}
?>
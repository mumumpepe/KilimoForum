<?php
// Include database connection
include("db_connection.php");

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

// Retrieve user ID from session
$user_id = $_SESSION['user_id'];

// Get POST data
$message = isset($_POST['message']) ? trim($_POST['message']) : "";
$seller_farmer_id = isset($_POST['seller_farmer_id']) ? intval($_POST['seller_farmer_id']) : 0;
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

// Validate message
if (empty($message)) {
    echo json_encode(['status' => 'error', 'message' => 'Message cannot be empty.']);
    exit;
}

// Insert message into the database
$send_query = "INSERT INTO messages (message_content, user_id, seller_farmer_id, product_id) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($send_query);
$stmt->bind_param("siii", $message, $user_id, $seller_farmer_id, $product_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Message sent successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Message not sent, please try again later.']);
}
?>

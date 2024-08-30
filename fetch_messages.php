<?php
// Include database connection
include("db_connection.php");

// Get user_id and seller_farmer_id from query parameters
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$seller_farmer_id = isset($_GET['seller_farmer_id']) ? intval($_GET['seller_farmer_id']) : 0;

// Initialize response array
$response = array(
    'user_messages' => array(),
    'seller_messages' => array()
);

// Retrieve user messages
$user_messages_query = "SELECT * FROM messages WHERE user_id = ? AND seller_farmer_id = ? AND role = 'customer' ORDER BY timestamp ASC";
$stmt = $conn->prepare($user_messages_query);
$stmt->bind_param("ii", $user_id, $seller_farmer_id);
$stmt->execute();
$user_messages_result = $stmt->get_result();

while ($row = $user_messages_result->fetch_assoc()) {
    $response['user_messages'][] = $row;
}

// Retrieve seller messages
$seller_messages_query = "SELECT * FROM messages WHERE user_id = ? AND seller_farmer_id = ? AND role <> 'farmer' ORDER BY timestamp ASC";
$stmt = $conn->prepare($seller_messages_query);
$stmt->bind_param("ii", $seller_farmer_id, $user_id);
$stmt->execute();
$seller_messages_result = $stmt->get_result();

while ($row = $seller_messages_result->fetch_assoc()) {
    $response['seller_messages'][] = $row;
}

// Output response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

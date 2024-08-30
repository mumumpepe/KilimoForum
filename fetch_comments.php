<?php
session_start();

// Check if the user is logged in and has the "customer" role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'customer') {
    echo json_encode(['success' => false, 'message' => 'You cannot view comments, please login first.']);
    exit();
}

//database connection
include("db_connection.php");

// Get the product ID
$product_id = $_POST['product_id'];

// Fetch comments for the product
$query = "SELECT c.comment_content, c.timestamp, u.username FROM comment c JOIN users u ON c.user_id = u.user_id WHERE c.post_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();

$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

echo json_encode(['success' => true, 'comments' => $comments]);

$stmt->close();
$conn->close();
?>

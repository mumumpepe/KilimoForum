<?php
include("db_connection.php");

$reply_content = $_POST['reply_content'];
$parent_comment_id = $_POST['parent_comment_id'];
$product_id = $_POST['product_id'];
$user_id = $_POST['user_id'];

$query = "INSERT INTO comment_replies (product_id, user_id, parent_comment_id, reply_content) VALUES ('$product_id', '$user_id', '$parent_comment_id', '$reply_content')";
if ($conn->query($query) === TRUE) {
    $reply_id = $conn->insert_id;
    $query = "SELECT * FROM comment_replies WHERE reply_id = '$reply_id'";
    $result = $conn->query($query);
    $reply = $result->fetch_assoc();
    echo json_encode(array('success' => true, 'reply' => $reply));
} else {
    echo json_encode(array('success' => false, 'message' => 'There was an error posting your reply.'));
}
?>

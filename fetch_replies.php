<?php
include("db_connection.php");

$comment_id = $_POST['comment_id'];
$query = "SELECT * FROM comment_replies WHERE parent_comment_id = '$comment_id' ORDER BY reply_id DESC";
$result = $conn->query($query);

$replies = array();
while ($row = $result->fetch_assoc()) {
    $replies[] = $row;
}

echo json_encode(array('success' => true, 'replies' => $replies));
?>

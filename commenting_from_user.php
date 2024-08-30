<?php
//session control
session_start();

// Check if the user is logged in and has the "customer" role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'customer') {
    echo json_encode(['success' => false, 'message' => 'You cannot post a comment, please login first.']);
    exit();
}

//database connection
include("db_connection.php");

// Validate form data
if (!isset($_POST['farmer_seller_id'], $_POST['user_id'], $_POST['product_id'], $_POST['comment_content'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid form data.']);
    exit();
}

$farmer_seller_id = $_POST['farmer_seller_id'];
$user_id = $_POST['user_id'];
$product_id = $_POST['product_id'];
$comment_content = $_POST['comment_content'];

// Ensure the comment content is not empty
if (empty($comment_content)) {
    echo json_encode(['success' => false, 'message' => 'Comment content cannot be empty.']);
    exit();
}

// Prepare and execute query to insert the comment into the comment table
$comment_query = "INSERT INTO comment (comment_content, post_id, user_id, seller_farmer_id) VALUES (?, ?, ?, ?)";
if ($stmt = $conn->prepare($comment_query)) {
    $stmt->bind_param('siis', $comment_content, $product_id, $user_id, $farmer_seller_id);

    if ($stmt->execute()) {
        // Fetch the new comment to return
        $comment_id = $stmt->insert_id;
        $query = "SELECT comment_content, timestamp FROM comment WHERE comment_id = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('i', $comment_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $new_comment = $result->fetch_assoc();

            // Fetch the username of the commenter
            $query = "SELECT username FROM users WHERE user_id = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param('i', $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                echo json_encode([
                    'success' => true,
                    'comment' => [
                        'username' => $user['username'],
                        'comment_content' => $new_comment['comment_content'],
                        'timestamp' => $new_comment['timestamp']
                    ]
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error fetching username.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error fetching comment details.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error executing comment insertion.']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Error preparing comment insertion statement.']);
}
$conn->close();
?>

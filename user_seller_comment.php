<?php
//session control 
session_start();

// Check if the user is logged in and has the "administrator" role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'seller') {
    header("Location: index.php");
}

//database connection
include("db_connection.php");

//seller id
$seller_id = $_SESSION['user_id'];

//query to select all the comments from the comment table
$comment = "SELECT * FROM comment WHERE seller_farmer_id = '".$seller_id."' ";
$result = $conn->query($comment);

if(!$result){
    echo "$conn->error";
    echo "There was an error with fetching customers's contents please try again later";
}

$fetchedComments = array();
while ($row = $result->fetch_assoc()){
    $fetchedComments[] = $row;
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Users' Comments</title>
    <style>
        table{
            border-collapse: collapse;
        }
    </style>
      <link rel="stylesheet" href="styles.css">
</head>
<nav>
    <ul>
    <li><a href="seller_dashboard.php">Home</a></li>
        <li><a href="seller_add_tools.php">Add Tool</a></li>
        <li><a href="seller_tools.php">Tools By Me</a></li>
        <li><a href="#">Comments</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>
<body>
    <h1>Users's Comments</h1>
    <table border="1px solid black">
        <thead>
            <th>Username</th>
            <th>Content</th>
            <th>Actions</th>
        </thead>
        <?php foreach($fetchedComments as $row): ?>
        <tr>
            <td>
                <?php 
                $user_id = $row['user_id'];

                //retrieving the username 
                $username = "SELECT username FROM users WHERE user_id = '".$user_id."'";
                $username_result = $conn->query($username);
                $fetchedRow = $username_result->fetch_assoc();
                if(!$username_result){
                    echo "$conn->error";
                    echo "There was an error with fetching the username from the database please try again later";
                }
                $real_username = $fetchedRow['username'];
                echo $real_username; ?>
            </td>
            <td>
                <?php echo $row['comment_content'] ?>
            </td>
            <td>
                <a href="">Reply</a>
            </td>
        </tr>
            <?php  endforeach ?>
    </table>
</body>
</html>
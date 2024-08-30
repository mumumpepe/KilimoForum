<?php
// Session control 
session_start();

// Check if the user is logged in and has the "seller" role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'seller') {
    header("Location: index.php");
    exit();
}

// Database connection
include("db_connection.php");

// Seller id
$seller_id = $_SESSION['user_id'];

// Query to select the latest message for each product
$messages = "
    SELECT m.*
    FROM messages m
    JOIN (
        SELECT product_id, MAX(timestamp) AS latest_timestamp
        FROM messages
        WHERE seller_farmer_id = '$seller_id'
        GROUP BY product_id
    ) latest_messages ON m.product_id = latest_messages.product_id 
    AND m.timestamp = latest_messages.latest_timestamp
    ORDER BY m.timestamp DESC
";

$result = $conn->query($messages);

if (!$result) {
    echo "$conn->error";
    echo "There was an error with fetching customers' messages, please try again later.";
    exit();
}

$fetchedMessages = array();
while ($row = $result->fetch_assoc()) {
    $fetchedMessages[] = $row;
}
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users' Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        table {
            border-collapse: collapse;
            width: 90%;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f3f4f6;
            border-bottom: 2px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        td a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        td a:hover {
            text-decoration: underline;
        }
        /* Navigation Styling */
        nav {
            background-color: #333;
            padding: 10px 0;
        }
        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
        }
        nav li {
            margin: 0 15px;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
        }
        nav a:hover {
            text-decoration: underline;
        }
        /* Header Styling */
        h1 {
            text-align: center;
            margin-top: 20px;
            font-size: 2rem;
            color: #333;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="farmer_add_product.php">Add Product</a></li>
            <li><a href="farmer_products.php">Product By Me</a></li>
            <li><a href="user_farmer_comment.php">Comments</a></li>
            <li><a href="#">Messages</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <h1>Users' Messages</h1>
   <center> <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($fetchedMessages as $row): ?>
            <tr>
                <td>
                    <?php 
                    $user_id = $row['user_id'];
                    $seller_farmer_id = $row['seller_farmer_id'];
                    $real_user_id = $row['user_id'];
                    $product_id = $row['product_id'];

                    // Retrieving the username 
                    $username_query = "SELECT username FROM users WHERE user_id = '".$user_id."'";
                    $username_result = $conn->query($username_query);
                    if ($username_result && $username_result->num_rows > 0) {
                        $fetchedRow = $username_result->fetch_assoc();
                        $real_username = $fetchedRow['username'];
                        echo htmlspecialchars($real_username, ENT_QUOTES, 'UTF-8');
                    } else {
                        echo "Error fetching username.";
                    }
                    ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($row['message_content'], ENT_QUOTES, 'UTF-8'); ?>
                </td>
                <td>
                    <a href="seller_reply_messages.php?seller_farmer_id=<?php echo htmlspecialchars($seller_farmer_id, ENT_QUOTES, 'UTF-8'); ?>&user_id=<?php echo htmlspecialchars($real_user_id, ENT_QUOTES, 'UTF-8'); ?>&product_id=<?php echo htmlspecialchars($product_id, ENT_QUOTES, 'UTF-8'); ?>">Chat</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
   </center>
</body>
</html>

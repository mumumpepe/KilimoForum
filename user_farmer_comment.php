<?php
//session control 
session_start();

// Check if the user is logged in and has the "administrator" role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'farmer') {
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users' Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        body {
            background-color: #F9FAFB; /* Light gray background */
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table th, table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #E2E8F0; /* Light border for table rows */
        }
        table th {
            background-color: #EDF2F7; /* Light gray background for header */
            font-weight: bold;
        }
        table tr:nth-child(even) {
            background-color: #F7FAFC; /* Alternating row colors for readability */
        }
        table a {
            color: #3182CE; /* Link color */
            text-decoration: none;
        }
        table a:hover {
            text-decoration: underline;
        }
        nav {
            background-color: #4A5568; /* Dark gray background */
        }
        nav ul {
            display: flex;
            justify-content: center;
            padding: 1rem;
            list-style-type: none;
        }
        nav ul li {
            margin: 0 1rem;
        }
        nav ul li a {
            color: #EDF2F7; /* Light gray text */
            text-decoration: none;
            font-weight: bold;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
        h1 {
            text-align: center;
            color: #2D3748; /* Dark gray text */
            margin-top: 2rem;
            font-size: 2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="farmer_add_product.php">Add Product</a></li>
            <li><a href="farmer_products.php">Product By Me</a></li>
            <li><a href="#">Comments</a></li>
            <li><a href="farmer_messages.php">Messages</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <h1>Users' Comments</h1>

    <div class="container mx-auto px-4 py-6">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead>
                <tr>
                    <th class="py-3 px-4 text-left">Username</th>
                    <th class="py-3 px-4 text-left">Content</th>
                    <th class="py-3 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($fetchedComments as $row): ?>
                <tr>
                    <td class="py-3 px-4">
                        <?php 
                        $user_id = $row['user_id'];

                        // Retrieving the username 
                        $username = "SELECT username FROM users WHERE user_id = '".$user_id."'";
                        $username_result = $conn->query($username);
                        $fetchedRow = $username_result->fetch_assoc();
                        if(!$username_result){
                            echo "$conn->error";
                            echo "There was an error fetching the username from the database. Please try again later.";
                        }
                        $real_username = $fetchedRow['username'];
                        echo htmlspecialchars($real_username); ?>
                    </td>
                    <td class="py-3 px-4">
                        <?php echo htmlspecialchars($row['comment_content']); ?>
                    </td>
                    <td class="py-3 px-4">
                        <a href="reply.php?comment_id=<?php echo $row['comment_id']; ?>" class="text-blue-500 hover:underline">Reply</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

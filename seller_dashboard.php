<?php

session_start();

// Check if the user is logged in and has the "administrator" role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'seller') {
    echo "You do not have permission to access this page.";
    // Add a CSS class to make the page content appear faded and unclickable
    echo '<style>body { pointer-events: none; }</style>';
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kilimo Forum</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        h1{
            text-align: center;
        }

        a{
            text-decoration: none;
        }
    </style>
</head>
<body>


<nav>
    <ul>
        <li><a href="seller_dashboard.php">Home</a></li>
        <li><a href="seller_add_tools.php">Add Tool</a></li>
        <li><a href="seller_tools.php">Tools By Me</a></li>
        <li><a href="user_seller_comment.php">Comments</a></li>
        <li><a href="seller_messages.php">Messages</a></li>
        <li><a href="logout.php">Logout</a></li>
        
    </ul>
</nav>

<h1>Welcome Seller (<?php echo $_SESSION['username'] ?>)</h1>
<br><br>
<a href="logout.php">Logout</a>
</body>
</html>

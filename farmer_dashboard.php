<?php

session_start();

// Check if the user is logged in and has the "administrator" role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'farmer') {
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
        /* General Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Body and Navigation Styles */
        body {
            font-family: Arial, sans-serif;
            background: #FFF6F5;
            margin: 0;
            padding: 0;
        }

        nav {
            background: #007bff;
            color: white;
            padding: 10px 0;
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        /* Main Content Styles */
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
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
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    
    <div class="container">
        <h1>Farmer Dashboard</h1>
    </div>
</body>
</html>

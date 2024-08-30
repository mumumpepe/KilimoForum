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
    <title>Seller| Add Tool</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav>
    <ul>
    <li><a href="seller_dashboard.php">Home</a></li>
        <li><a href="seller_add_tools.php">Add Tool</a></li>
        <li><a href="seller_tools.php">Tools By Me</a></li>
        <li><a href="user_seller_comment.php">Comments</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>


    <form action="seller_add_tools1.php" method="POST">
        <h1>Seller| Add Tool </h1>
    <table>
        <tr>
            <td>
Name
            </td>
            <td>
<input type="text" name="product_name">
            </td>
        </tr>
        <tr>
            <td>
Description
            </td>
            <td>
<textarea name="product_description"></textarea>
            </td>
        </tr>
        <tr>
            <td>
Price($)
            </td>
            <td>
<input type="number" min="0" name="product_price">
            </td>
        </tr>
        <tr>
            <td>
Category
            </td>
            <td>
                <select name="product_category" id="">
                    <option value="product">Agricultural Product</option>
                    <option value="tool">Agricultural Tool</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <button type="submit">Upload</button>
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
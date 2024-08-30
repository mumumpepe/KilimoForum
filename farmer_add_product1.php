<?php

session_start();

// Check if the user is logged in and has the "administrator" role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'farmer') {
    echo "You do not have permission to access this page.";
    // Add a CSS class to make the page content appear faded and unclickable
    echo '<style>body { pointer-events: none; }</style>';
    exit();
}

$user_id = $_SESSION['user_id'];

//database connection
include("db_connection.php");

//storing variables
$product_name = $_POST['product_name'];
$product_description = $_POST['product_description'];
$product_price = $_POST['product_price'];
$product_category = $_POST['product_category'];


//insertion to database
$insert = "INSERT INTO product(product_name, description, price, category, user_id)
            VALUES('".$product_name."', '".$product_description."', '".$product_price."', '".$product_category."', '".$user_id."')";
$insert_result = $conn->query($insert);

if(!$insert_result){
    echo "Error: $conn->error";
    echo "<br> There was an error with inserting the product details to the database, please try again later";
} else {
    echo "Product Added Successfully";}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer| Add Product</title>
</head>
<body>
<nav>
    <ul>
        <li><a href="famer_dashboard.php">Home</a></li>
        <li><a href="farmer_add_product.php">Add Product</a></li>
        <li><a href="farmer_products.php">Product By Me</a></li>
        <li><a href="logout.php">Logout</a></li>
        
    </ul>
</nav>

    <a href="farmer_add_product.php">Add New Product</a>
    <a href="farmer_dashboard.php">Home</a>
</body>
</html>
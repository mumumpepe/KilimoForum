<?php
session_start();

// Check if the user is logged in and has the "administrator" role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'farmer' && $_SESSION["role"] !== 'seller') {
    echo "You do not have permission to access this page.";
    // Add a CSS class to make the page content appear faded and unclickable
    echo '<style>body { pointer-events: none; }</style>';
    exit();
}

//database connection
include('db_connection.php');

//getting the product_id
$product_id = $_GET['product_id']; 
$role = $_GET['role'];

$delete = "DELETE FROM product WHERE product_id = '".$product_id."'";
$result = $conn->query($delete);

if(!$result){
    echo "Error:$conn->error";
    echo "There was an error with deleting the selected product from the database, please try again later";
} else {
    if($role == "farmer"){
        header("Location: farmer_products.php");
    } elseif($role == "seller"){
        header("Location: seller_tools.php");
    } else {
        header("Location: logout.php");
    }
}


?>
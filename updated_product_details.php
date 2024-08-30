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

//variables declaration
$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_description = $_POST['product_description'];
$product_price = $_POST['product_price'];
$seller_farmer_role = $_POST['seller_farmer_role'];

//database insertion
$update_product_details = "UPDATE product SET product_name = '".$product_name."', description = '".$product_description."', price = '".$product_price."' WHERE product_id = '".$product_id."'";
$result = $conn->query($update_product_details);

if(!$result){
    echo "Error:$conn->error";
    echo "<br> There was an error with updating the product details, please try again later";
} else {
    if($seller_farmer_role == 'farmer'){
        header("Location: farmer_products.php");
    } elseif($seller_farmer_role == 'seller'){
        header("Location: seller_tools.php");
    } 
    else{
        header("Location: logout.php");
    }
    
}
?>
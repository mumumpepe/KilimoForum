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

//variable initialization
$seller_farmer_role = "";


//retrieving the current data from the database
$product_details = "SELECT * FROM product WHERE product_id = '".$product_id."'";
$result = $conn->query($product_details);

if(!$result){
    echo "Error: $conn->error";
    echo "<br> There was an error with fetching the current product details please try again later";
}
 
$fetchedDetails = array();
while ($row = $result->fetch_assoc()){
    $fetchedDetails[] = $row;

    $product_name = $row['product_name'];
    $product_description = $row['description'];
    $product_price = $row['price'];
    $user_id = $row['user_id'];
}

//knowing role and give out a unique heading for farmer/seller
$role = "SELECT role FROM users WHERE user_id = '".$user_id."'";
$role_result = $conn->query($role);

if(!$role){
    echo "Error:$conn->error";
    echo "<br> There was an error with fetching the role for the given user";
}

$fetched_role = $role_result->fetch_assoc();
$real_fetched_role = $fetched_role['role'];

$new_seller_farmer_role = $real_fetched_role;

if($real_fetched_role == "farmer"){
    $seller_farmer_role = "Farmer| Edit Product Details";
} elseif ($real_fetched_role == "seller"){
    $seller_farmer_role = "Seller| Edit Tool Details";
} else{
    $seller_farmer_role = "Unknown Role";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer| Add Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="farmer_dashboard.php">Home</a></li>
        <li><a href="farmer_add_product.php">Add Product</a></li>
        <li><a href="farmer_products.php">Product By Me</a></li>
        <li><a href="user_farmer_comment.php">Comments</a></li>
        <li><a href="logout.php">Logout</a></li>
        
    </ul>
</nav>


    <form action="updated_product_details.php" method="POST">
        <h1><?php echo $seller_farmer_role ?></h1>
    <table>
        <tr>
            <td>
Name
            </td>
            <td>
<input type="text" name="product_name" value ="<?php echo $product_name ?>">
            </td>
        </tr>
        <tr>
            <td>
Description
            </td>
            <td>
<input type = "text" name="product_description" value = "<?php echo $product_description ?>">
            </td>
        </tr>
        <tr>
            <td>
Price($)
            </td>
            <td>
<input type="number" min="0" name="product_price" value="<?php echo $product_price ?>">
            </td>
        </tr>
        <tr>

        </tr>
        <tr>
            <td>
                <button type="submit">Save Changes</button>
            </td>
        </tr>
    </table>
    <input type="hidden" name = "product_id" value = "<?php echo $product_id ?>">
    <input type="hidden" name = "seller_farmer_role" value = "<?php echo $new_seller_farmer_role ?>">
    </form>
</body>
</html>
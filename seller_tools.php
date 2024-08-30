<?php

session_start();

// Check if the user is logged in and has the "administrator" role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'seller') {
    echo "You do not have permission to access this page.";
    // Add a CSS class to make the page content appear faded and unclickable
    echo '<style>body { pointer-events: none; }</style>';
    exit();
}

//database connection
include("db_connection.php");

$user_id = $_SESSION["user_id"];

//fetching details based on the provided user id
$query = "SELECT * FROM product WHERE user_id ='".$user_id."' ";
$result = $conn->query($query);

if(!$result){
    echo "Error: $conn->error";
    echo "<br> There was an error with fetching the products details, please try again later";
}

$fetchedData = array();
while($row = $result->fetch_assoc()){
    $fetchedData[] = $row;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer| Self Products</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table{
                border-collapse: collapse;
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
        <li><a href="logout.php">Logout</a></li>
        
    </ul>
</nav>

    <h1>My Tools</h1>
    <table border="1px solid black">
        <thead>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Category</th>
            <th>Actions</th>
        </thead>
<?php  foreach($fetchedData as $row): ?>
        <tr>
            <td>
                <?php echo $row['product_name'] ?>
            </td>
            <td>
                <?php echo $row['description'] ?>
            </td>
            <td>
                <?php echo $row['price'] ?>
            </td>
            <td>
                <?php echo $row['category'] ?>
            </td>
            <td>
            <a href="farmer_seller_edit_product.php?product_id=<?php echo $row['product_id'] ?>">Edit</a>
            <a href="farmer_seller_delete_product.php?product_id=<?php echo $row['product_id'] ?>&role=seller">Delete</a>
            </td>
        </tr>
<?php endforeach ?>
    </table>
    
</body>
</html>
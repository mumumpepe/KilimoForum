<?php
// Database connection parameters
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "webforum";

// Create a connection to the database

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check the connection
if($conn){

} else {
    echo "Database connection failed";
}


$query = "SELECT * FROM product";
$result = $conn->query($query);

if(!$result){
    echo "There is an error";
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
    <title>Products</title>
    <style>
        table{
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <table border="1px solid black">
        <thead>
            <th>Product Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Category</th>
        </thead>
        <?php foreach($fetchedData as $row): ?>
<tr>
    <td><?php echo $row['product_name'] ?></td>
    <td><?php echo $row['description'] ?></td>
    <td><?php echo $row['price'] ?></td>
    <td><?php echo $row['category'] ?></td>
</tr>


            <?php endforeach ?>
    </table>
</body>
</html>
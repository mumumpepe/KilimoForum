<?php
//database connection
include("db_connection.php");

//session start
session_start();


//getting the user id to export to send to the database table for the messages
$user_id = $_SESSION['user_id'];


$message = $_POST['message'];
$seller_id = $_POST['seller_id'];
$product_id = $_POST['product_id'];
$role = "customer";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $message = $_POST["message"];

    $Send = "INSERT INTO messages(message_content,user_id, seller_farmer_id, product_id, role )
            VALUES('$message', '$user_id', '$seller_id', '$product_id', '$role');";

$result = $conn->query($Send);
//ensuring query execution 
if(!$result){
    echo "Error: $conn->error";
    $errormsg = "Message not Sent, Please try again later";
} else {
    $success = "Sent";
}

}


?>
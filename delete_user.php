<?php

session_start();

// Check if the user is logged in and has the "administrator" role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'administrator') {
    echo "You do not have permission to access this page.";
    // Add a CSS class to make the page content appear faded and unclickable
    echo '<style>body { pointer-events: none; }</style>';
    exit();
}

// Database connection
include("db_connection.php");

// Check if the user is an admin (you can implement admin authentication)
$isAdmin = true; // Set this based on your authentication logic

if (!$isAdmin) {
    // Redirect non-admin users to a different page
    header("Location: logout.php");
    exit();
}

//retrieving a users id for the selected user
$user_id = $_GET['id'];

//query to delete the user's data
$delete = "DELETE FROM users WHERE user_id = '".$user_id."'";
$result = $conn->query($delete);

if(!$result){
    echo "Error: $conn->error";
    echo "<br> There was an error with deleting the selected user's details, please try again later";
} else {
    header("Location: administrator_dashboard.php?table=users");
}


?>
<?php

// Start the session

session_start();



// Check if the user is logged in (modify this based on your authentication logic)

if (!isset($_SESSION['username'])) {

    header("Location: login.php");

     exit;

}

?>




   







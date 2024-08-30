<?php

// Database connection parameters
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "webforum";

// Create a connection to the database

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check the connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}



?>
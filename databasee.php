<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "test_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select all records from the 'users' table
$sql = "SELECT id, name, email FROM users";
$result = $conn->query($sql);

// Check if there are results and display them
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Name: " . $row["name"]. " - Email: " . $row["email"]. "<br>";
    }
} else {
    echo "0 results";
}

// Close the connection
$conn->close();
?>

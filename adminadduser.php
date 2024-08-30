<?php
session_start();

$errorMessage = ""; // Define the errorMessage variable here
$successMessage = ""; // Define the successMessage variable here

//database connection
include("db_connection.php");

$username = "";
$password = "";
$email = "";
$role = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    // Check if the user already exists
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $errorMessage = "User already exists. Please choose a different username.";
    } else {
        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $insertQuery = "INSERT INTO users (username, email, password_hash, registration_date, role) VALUES ('$username', '$email', '$passwordHash', NOW(), '$role')";

        if ($conn->query($insertQuery) === TRUE) {
            $_SESSION['success_message'] = "Registration successful!";
            // Redirect to the same page to clear the form and display the success message
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $errorMessage = "Error: " . $conn->error;
        }
    }
}

$conn->close();

// Retrieve and clear success message from session
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        /* Your CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
            text-align: center;
        }

        h2 {
            margin: 0 0 20px;
            color: #333;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select { /* Added select field for role */
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 12px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: #dc3545;
            margin-top: 10px;
        }

        .success-message {
            color: #28a745;
            margin-top: 10px;
        }

        /* Button to go back */
        .go-back-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Register</h2>
    
    <?php
    if ($errorMessage !== "") {
        echo "<p class='error-message'>$errorMessage</p>";
    }
    
    if ($successMessage !== "") {
        echo "<p class='success-message'>$successMessage</p>";
    }
    ?>

    <!-- Registration form -->
    <form action="adminadduser.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="role">Role:</label> <!-- Added Role field -->
        <select id="role" name="role" required>
            <option value="farmer">Farmer</option>
            <option value="seller">Seller</option>
            <option value="administrator">Administrator</option>
        </select>
        
        <input type="submit" value="Register">
    </form>
    
    <p>Already have an account? <a href="login.php">Login</a></p>
    
    <button onclick="goBack()" class="go-back-button">Go Back to Home</button>

    <script>
        // Function to go back to the previous page
        function goBack() {
            window.history.back();
        }
    </script>
</div>
</body>
</html>


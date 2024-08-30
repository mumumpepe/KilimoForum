<?php
session_start(); // Start the session

$loginError = isset($_SESSION["loginError"]) ? $_SESSION["loginError"] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Database connection
    include("db_connection.php");

    // Check if username exists
    $sql = "SELECT user_id, username, password_hash, role FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password_hash"];
        $role = $row["role"];

        if (password_verify($password, $hashedPassword)) {
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;
            $_SESSION["loginError"] = "";

            // Redirect based on the user's role
            switch ($role) {
                case 'customer':
                    header("Location: home_template.php");
                    exit();
                case 'farmer':
                    header("Location: farmer_dashboard.php");
                    exit();
                case 'seller':
                    header("Location: seller_dashboard.php");
                    exit();
                case 'administrator':
                    header("Location: administrator_dashboard.php");
                    exit();
                default:
                    $_SESSION["loginError"] = "Invalid role.";
            }
        } else {
            $_SESSION["loginError"] = "Incorrect password.";
        }
    } else {
        $_SESSION["loginError"] = "Username does not exist.";
    }

    $stmt->close();
    $conn->close();

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login | Maige POS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <style>
        body {
            background: url('https://images.unsplash.com/photo-1562142610-f85d1c79fa88') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background: #FFF6F5;
        }
        .login-dark {
            width: 100%;
            max-width: 400px;
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
        }
        .login-dark .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-dark .logo img {
            max-width: 150px;
        }
        .login-dark form {
            color: #333;
        }
        .login-dark .illustration {
            text-align: center;
            padding: 15px 0;
            font-size: 80px;
            color: #4CAF50;
        }
        .login-dark form .form-control {
            background: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #333;
        }
        .login-dark form .btn-primary {
            background: #4CAF50;
            border: none;
            border-radius: 4px;
            padding: 10px;
            color: white;
            font-size: 16px;
            box-shadow: none;
            margin-top: 20px;
            text-shadow: none;
        }
        .login-dark form .btn-primary:hover, .login-dark form .btn-primary:active {
            background: #45a049;
        }
        .login-dark form .forgot {
            display: block;
            text-align: center;
            font-size: 14px;
            color: #333;
            text-decoration: none;
        }
        .login-dark form .forgot:hover, .login-dark form .forgot:active {
            text-decoration: underline;
        }
        .login-dark .alert {
            margin-top: 20px;
            display: <?php echo $loginError ? 'block' : 'none'; ?>;
        }
        h1{
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="login-dark">
        <h1>Login</h1>
        <br>
        <div class="logo">
            <img src="logo.jpeg" alt="Company Logo">
        </div>
        <form action="login.php" method="POST">
            <h2 class="sr-only">Login Form</h2>
            <div class="form-group"><input class="form-control" type="text" name="username" placeholder="Username"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"></div>
            <div class="form-group"><p>Not a Member?<a href="register.php"> Sign Up</a></p></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Log In</button></div>
            <?php if ($loginError): ?>
                <div class="alert alert-danger"><?php echo $loginError; ?></div>
            <?php endif; ?>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

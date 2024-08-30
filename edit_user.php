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

//selecting the current user details
$user_details = "SELECT * FROM users WHERE user_id = '".$user_id."'";
$result = $conn->query($user_details);

if(!$result){
    echo "Error:$conn->error";
    echo "<br> There was an error with fetching the selected user's details, please try again later";
}

$fetchedDetails = array();
while ($row = $result->fetch_assoc()){
    $fetchedDetails[] = $row;

    $username = $row['username'];
    $email = $row['email'];
    $password = $row['password_hash'];
    $role = $row['role'];
}


$password_hash = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
        //checking if the new password is entered
        if(!isset($_POST['previous_password'])){
            $password_hash = $_POST['previous_password'];
        } else {
            $hash = $_POST['password'];
            $password_hash = password_hash($hash, PASSWORD_DEFAULT);
        }

        //new user details 
        $username = $_POST['username'];
        $user_id = $_POST['user_id'];
        $email = $_POST['email'];
        $role = $_POST['role'];
   

        //query to update the details
$update = "UPDATE users SET username = '".$username."', email = '".$email."', password_hash = '".$password_hash."', role = '".$role."' WHERE user_id = '".$user_id."'";
$update_result = $conn->query($update);

if(!$update_result) {
    echo "Error: $conn->error";
    echo "There was an error with updating the user's details, please try again later";
} else{
    header("Location: administrator_dashboard.php?table=users");
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Details</title>
</head>
<body>
    <form action="edit_user.php" method ="POST">
        <h1>Edit User Details</h1>
        <table>
            <tr>
                <td>
                    Username
                </td>
                <td>
                    <input type="text" value="<?php echo $username ?>" name="username">
                </td>
            </tr>
            <tr>
                <td>
                    Email
                </td>
                <td>
                <input type="text" value="<?php echo $email ?>" name="email">
            </td>
            </tr>
            <tr>
                <td>
                    Password
                </td>
                <td>
                <input type="text" name ="password">
            </td>
            </tr>
            <tr>
                <td>
                    Role
                </td>
                <td>
                <select name="role" id="">
                    <option value="<?php echo $role ?>" selected><?php echo $role ?></option>
                    <option value="customer">customer</option>
                    <option value="farmer">farmer</option>
                    <option value="Seller">seller</option>
                </select>
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit">Save Changes</button>
                    <input type="hidden" name="previous_password" value =<?php echo $password ?>>
                    <input type="hidden" name="user_id" value =<?php echo $user_id ?>>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
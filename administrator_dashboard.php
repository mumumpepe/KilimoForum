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
    header("Location: index.php");
    exit();
}

// Initialize variables for table selection
$selectedTable = isset($_GET['table']) ? $_GET['table'] : 'users';

// Fetch data from the selected table
switch ($selectedTable) {
    case 'users':
        $tableTitle = 'Users';
        $sql = "SELECT * FROM users";
        break;
    case 'comment':
        $tableTitle = 'Comments';
        $sql = "SELECT * FROM comment GROUP BY post_id";
        break;
    case 'forum_post':
        $tableTitle = 'Forum Posts';
        $sql = "SELECT * FROM forum_post";
        break;
    case 'order_details':
        $tableTitle = 'Order Details';
        $sql = "SELECT * FROM order_details";
        break;
    case 'orders':
        $tableTitle = 'Orders';
        $sql = "SELECT * FROM orders";
        break;
    case 'product':
        $tableTitle = 'Products';
        $sql = "SELECT * FROM product";
        break;
    default:
        // Invalid table selection, handle accordingly
        die("Invalid table selection");
}

$result = $conn->query($sql);

// Check for database errors
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Fetch and store the data in an array
$fetchedData = array();
while ($row = $result->fetch_assoc()) {
    $fetchedData[] = $row;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: 'Lato', sans-serif;
  background-color: #f5f5f5;
  margin: 0;
  padding: 0;
}

h1 {
  background-color: #333;
  color: #fff;
  padding: 20px;
  text-align: center;
  margin: 0;
}

form {
  width: 80%;
  max-width: 600px;
  margin: 20px auto;
  padding: 20px;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
}

/* Style the select element */
select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
  background-color: #fff;
  color: #333;
  box-sizing: border-box; /* Ensures padding does not exceed the width */
}

/* Style the select element when hovered */
select:hover {
  border-color: #007bff; /* Change border color on hover */
}

/* Style the select element when focused (clicked) */
select:focus {
  outline: none; /* Remove the default focus outline */
  border-color: #007bff; /* Change border color when focused */
}

/* Style the submit button */
input[type="submit"] {
  width: 100%; /* Match the width of the select element */
  margin-top: 10px; /* Add top margin */
  background-color: #333;
  color: #fff;
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
  box-sizing: border-box; /* Ensures padding does not exceed the width */
}

input[type="submit"]:hover {
  background-color: #555;
}

h2 {
  margin: 20px;
  text-align: center;
}

.table-container {
  width: 100%;
  overflow-x: auto;
  margin: 20px 0;
}

table {
  width: 100%;
  border-collapse: collapse;
  background-color: #fff;
  border: 1px solid #ddd;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

table, th, td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
  box-sizing: border-box; /* Ensures padding does not exceed the width */
}

th {
  background-color: #333;
  color: #fff;
}

tr:nth-child(even) {
  background-color: #f9f9f9;
}

tr:hover {
  background-color: #f1f1f1;
}

.actions {
  text-align: center;
}

.actions a {
  margin: 0 5px;
  text-decoration: none;
  color: #fff;
  padding: 5px 10px;
  border-radius: 4px;
  display: inline-block;
}

.edit-button {
  background-color: #007bff;
}

.delete-button {
  background-color: #dc3545;
}

.actions a:hover {
  opacity: 0.8;
}

/* Overlay menu styles */
.overlay {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: rgba(0,0,0, 0.9);
  overflow-x: hidden;
  transition: 0.5s;
}

.overlay-content {
  position: relative;
  top: 25%;
  width: 100%;
  text-align: center;
}

.overlay a {
  padding: 8px;
  text-decoration: none;
  font-size: 36px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.overlay a:hover, .overlay a:focus {
  color: #f1f1f1;
}

.overlay .closebtn {
  position: absolute;
  top: 20px;
  right: 45px;
  font-size: 60px;
}

@media screen and (max-height: 450px) {
  .overlay a {font-size: 20px}
  .overlay .closebtn {
    font-size: 40px;
    top: 15px;
    right: 35px;
  }
}

/* Responsive table adjustments */
@media (max-width: 768px) {
  table {
    font-size: 14px;
  }

  th, td {
    padding: 8px;
  }
}

th{
    text-align: center;
}



</style>
</head>
<body>

<div id="myNav" class="overlay">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="overlay-content">
    <a href="adminadduser.php">Add Staff Member</a>
    <a href="logout.php">Logout</a>
  </div>
</div>
<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; </span>
<h1>Admin Dashboard</h1>

<!-- Table Selection Dropdown -->
<form action="administrator_dashboard.php" method="GET">
    <label for="table">Select Table:</label>
    <div class ="select-container">
    <select name="table" id="table">
        <option value="users" <?php if ($selectedTable === 'users') echo 'selected'; ?>>Users</option>
        <option value="comment" <?php if ($selectedTable === 'comment') echo 'selected'; ?>>Comments</option>
        <option value="order_details" <?php if ($selectedTable === 'order_details') echo 'selected'; ?>>Order Details</option>
        <option value="orders" <?php if ($selectedTable === 'orders') echo 'selected'; ?>>Orders</option>
        <option value="product" <?php if ($selectedTable === 'product') echo 'selected'; ?>>Products</option>
    </select>
    </div>
    <input type="submit" value="Show Table">
</form>

<!-- Display selected table data -->
<h2><?php echo $tableTitle; ?></h2>

<?php
// Display table data based on the selected table
if ($selectedTable === 'users'): ?>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Password Hash</th>
                <th>Registration Date</th>
                <th>Role</th>
                <th colspan = "2">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($fetchedData as $row): ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['password_hash']; ?></td>
                    <td><?php echo $row['registration_date']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td class="actions">
                        <a class="edit-button" href='edit_user.php?id=<?php echo $row['user_id']; ?>'>Edit</a>
                    </td>
                    <td class="actions">
                        <a class="delete-button" href='delete_user.php?id=<?php echo $row['user_id']; ?>'>Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php elseif ($selectedTable === 'comment'): ?>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>Comment ID</th>
                <th>Product ID</th>
                <th>User ID</th>
                <th>Comment</th>
                <th>Creation Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($fetchedData as $row): ?>
                <tr>
                    <td><?php echo $row['comment_id']; ?></td>
                    <td><?php echo $row['post_id']; ?></td>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['comment_content']; ?></td>
                    <td><?php echo $row['timestamp']; ?></td>
                    <td class="actions">
                        <a class="edit-button" href='view_comment.php?id=<?php echo $row['user_id']; ?>'>Info</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php elseif ($selectedTable === 'order_details'): ?>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Order ID</th>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($fetchedData as $row): ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['product_id']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td class="actions">
                        <a class="edit-button" href='edit_order_details.php?id=<?php echo $row['user_id']; ?>'>Edit</a>
                        <a class="delete-button" href='delete_order_details.php?id=<?php echo $row['user_id']; ?>'>Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php elseif ($selectedTable === 'orders'): ?>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Total Amount</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($fetchedData as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['total_amount']; ?></td>
                    <td class="actions">
                        <a class="edit-button" href='edit_order.php?id=<?php echo $row['id']; ?>'>Edit</a>
                        <a class="delete-button" href='delete_order.php?id=<?php echo $row['id']; ?>'>Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php elseif ($selectedTable === 'product'): ?>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
                <th>User ID</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($fetchedData as $row): ?>
                <tr>
                    <td><?php echo $row['product_id']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['user_id']; ?></td>
                    <td class="actions">
                        <a class="edit-button" href='edit_product.php?id=<?php echo $row['id']; ?>'>Edit</a>
                        <a class="delete-button" href='delete_product.php?id=<?php echo $row['id']; ?>'>Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<!-- Add other admin features or navigation links -->

<script>
function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}
</script>
     
</body>
</html>

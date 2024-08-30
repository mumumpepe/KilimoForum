<?php
//session control 
session_start();

// Check if the user is logged in and has the "administrator" role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'farmer') {
    header("Location: index.php");
}

//database connection
include("db_connection.php");



/*getting the values for the seller, user  and product id
$seller_farmer_id = $_GET['seller_farmer_id'];
$product_id = $_GET['product_id'];
$user_id = $_GET['user_id'];
*/


// Initialize variables to avoid undefined variable warnings
$success = "";
$errormsg = "";

// Fetching real role for the seller/farmer
$seller_id = $product_id = $customer_id = null;

if ($_SERVER["REQUEST_METHOD"] == "GET" || $_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_GET['user_id'] ?? $_POST['user_id'];
    $product_id = $_GET['product_id'] ?? $_POST['product_id'];
    $seller_id = $_SESSION['user_id'];

}

// Handling message sending
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    $role = "farmer";

    $Send = "INSERT INTO messages(message_content, user_id, seller_farmer_id, product_id, role)
             VALUES('$message', '$customer_id', '$seller_id', '$product_id', '$role')";

    $result = $conn->query($Send);

    if ($result) {
        $success = "Sent";
    } else {
        $errormsg = "Message not sent. Please try again later.";
    }
}

// Fetching messages for both customer and seller/farmer
$customer_messages = [];
$seller_farmer_messages = [];


//reversal of side for chatting customer==seller's side and vice versa
$customer_query = "SELECT * FROM messages WHERE user_id = '$customer_id' AND seller_farmer_id = '$seller_id' AND product_id = '$product_id' AND role = 'customer'";
$seller_farmer_query = "SELECT * FROM messages WHERE user_id = '$customer_id' AND seller_farmer_id = '$seller_id' AND product_id = '$product_id' AND role = 'farmer'";

$customer_result = $conn->query($customer_query);
$seller_farmer_result = $conn->query($seller_farmer_query);

if ($customer_result) {
    while ($row = $customer_result->fetch_assoc()) {
        $customer_messages[] = $row;
    }
} else {
    echo "Error: $conn->error";
    echo "<br> There was an error fetching the customer messages.";
}

if ($seller_farmer_result) {
    while ($row = $seller_farmer_result->fetch_assoc()) {
        $seller_farmer_messages[] = $row;
    }
} else {
    echo "Error: $conn->error";
    echo "<br> There was an error fetching the seller/farmer messages.";
}


// Merge and sort messages by timestamp
$all_messages = array_merge($customer_messages, $seller_farmer_messages);
usort($all_messages, function ($a, $b) {
    return strtotime($a['timestamp']) - strtotime($b['timestamp']);
});
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messaging</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* General Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #FFF6F5;
            margin: 0;
            padding: 0;
        }

        /* Header */
        h1 {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw; /* Set width to 75% of viewport width */
            background: white;
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
            text-align: center;
            font-size: 2rem; /* Increase font size for better visibility */
            font-weight: bold;
            z-index: 10;
        }

        /* Main Container */
        .main-container {
            width: 75vw; /* Set container width to 75% of viewport width */
            margin: 60px auto 0; /* Add top margin to accommodate the fixed header */
            padding: 10px;
            height: calc(100vh - 60px); /* Adjust height to fit within viewport minus the header */
            display: flex;
            flex-direction: column;
            background: white;
        }

        /* Conversation Container */
        .conversation {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            overflow-y: auto; /* Enable scrolling for messages container */
            padding-right: 10px; /* Prevent content from being hidden behind the scrollbar */
        }

        .message-container {
            display: flex;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 12px;
            max-width: 60%;
        }

        .message-container.customer {
            background-color: #e6f7ff; /* Light blue for customer */
            align-self: flex-start;
        }

        .message-container.seller, .message-container.farmer {
            background-color: #d9f7be; /* Light green for seller/farmer */
            align-self: flex-end;
        }

        .message-content {
            display: flex;
            flex-direction: column;
        }

        .message-content span {
            font-size: 0.8em;
            color: #888;
            margin-top: 5px;
        }

        /* Input and Send Button */
        .new-message {
            margin-top: 10px;
            padding: 10px;
            border-top: 1px solid #ddd;
            background: white;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
        }

        .new-message form {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .new-message textarea {
            width: 80%;
            height: 50px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-right: 10px;
            resize: none;
        }

        .new-message button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .new-message button:hover {
            background-color: #0056b3;
        }

        /* Hide scrollbar */
        .conversation::-webkit-scrollbar {
            display: none; /* Chrome, Safari */
        }

        .conversation {
            scrollbar-width: none; /* Firefox */
        }
    </style>
</head>
<body>
    <h1>Conversation with Customer</h1>
    <div class="main-container">
        <div class="conversation">
            <?php foreach ($all_messages as $message): ?>
                <div class="message-container <?php echo $message['role']; ?>">
                    <div class="message-content">
                        <p><?php echo $message['message_content']; ?></p>
                        <span><?php echo $message['timestamp']; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="new-message">
            <form action="farmer_reply_messages.php" method="post" class="flex items-center space-x-2">
                <input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <input type="hidden" name="user_id" value="<?php echo $customer_id; ?>">
                <textarea name="message" id="message" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Type your message..."></textarea>
                <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</body>
</html>

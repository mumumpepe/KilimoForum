<?php
session_start();

// Database connection
include("db_connection.php");

// Initialize variables to avoid undefined variable warnings
$success = "";
$errormsg = "";

// Fetching real role for the seller/farmer
$seller_id = $product_id = $user_id = $fetched_role = null;

if ($_SERVER["REQUEST_METHOD"] == "GET" || $_SERVER["REQUEST_METHOD"] == "POST") {
    $seller_id = $_GET['seller_id'] ?? $_POST['seller_id'];
    $product_id = $_GET['product_id'] ?? $_POST['product_id'];
    $user_id = $_SESSION['user_id'];

    // Fetching seller/farmer role
    $get_role = "SELECT role FROM users WHERE user_id = $seller_id";
    $get_role_result = $conn->query($get_role);

    if ($get_role_result) {
        $fetched_seller_role = $get_role_result->fetch_assoc();
        $fetched_role = $fetched_seller_role['role'];
    } else {
        echo "Error: $conn->error";
        echo "<br> There was an error retrieving the seller/farmer role from the database.";
    }
}

// Handling message sending
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    $role = "customer"; // Assuming the user is a customer

    $Send = "INSERT INTO messages(message_content, user_id, seller_farmer_id, product_id, role)
             VALUES('$message', '$user_id', '$seller_id', '$product_id', '$role')";

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

$customer_query = "SELECT * FROM messages WHERE user_id = '$user_id' AND seller_farmer_id = '$seller_id' AND product_id = '$product_id' AND role = 'customer'";
$seller_farmer_query = "SELECT * FROM messages WHERE user_id = '$user_id' AND seller_farmer_id = '$seller_id' AND product_id = '$product_id' AND role = '$fetched_role'";

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
        /* Custom Styles */
        .message-container {
            background-color: #f5f5f5;
            position: relative;
            max-width: 75%;
            padding: 10px;
            border-radius: 12px;
            margin-bottom: 8px;
        }
        .message-container.customer {
            background-color: #e6f7ff; /* Light blue for customer */
            align-self: flex-start;
            border-bottom-left-radius: 0;
        }
        .message-container.seller, .message-container.farmer {
            background-color: #d9f7be; /* Light green for seller/farmer */
            align-self: flex-end;
            border-bottom-right-radius: 0;
        }
        .message-box {
            position: relative;
            width: 100%;
            padding: 10px;
            background: white;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
        }
        .message-box textarea {
            resize: none;
            height: 50px;
        }
        .chat-container {
            max-width: 75vw;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .message-scroll-container {
            overflow-y: auto;
            height: calc(100vh - 120px); /* Adjust height to fit the container without the message box */
        }
        /* Hide scrollbar for WebKit-based browsers */
        .message-scroll-container::-webkit-scrollbar {
            display: none; /* Chrome, Safari */
        }
        /* Hide scrollbar for Firefox */
        .message-scroll-container {
            scrollbar-width: none; /* Firefox */
        }
        /* Fixed Header Styles */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: white;
            z-index: 10;
        }
        .main-content {
            padding-top: 60px; /* Adjust padding based on header height */
        }
    </style>
</head>
<body class="bg-[#FFF6F5] font-sans">

    <header class="header shadow-md py-4 px-6">
        <h1 class="text-2xl font-bold text-center">Conversation with <?php echo $fetched_role; ?></h1>
    </header>

    <div class="chat-container main-content">
        <main class="flex-grow p-4">
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 flex flex-col h-full">
                <div class="message-scroll-container flex flex-col space-y-4">
                    <?php foreach ($all_messages as $message): ?>
                        <div class="message-container flex <?php echo $message['role']; ?>">
                            <div class="message-content flex flex-col">
                                <p class="text-gray-900"><?php echo $message['message_content']; ?></p>
                                <span class="text-gray-500 text-sm mt-1"><?php echo $message['timestamp']; ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="message-box flex items-center space-x-2">
                    <form action="chat_with_farmer_seller.php" method="post" class="w-full flex items-center space-x-2">
                        <input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <textarea name="message" id="message" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Type your message..."></textarea>
                        <button type="submit" class="bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>

</body>
</html>

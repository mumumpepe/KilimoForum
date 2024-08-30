<?php
session_start();

// Check if the user is logged in and has the "farmer" role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'farmer') {
    echo "You do not have permission to access this page.";
    // Add a CSS class to make the page content appear faded and unclickable
    echo '<style>body { pointer-events: none; }</style>';
    exit();
}

// Database connection
include("db_connection.php");

$user_id = $_SESSION["user_id"];

// Fetching details based on the provided user id
$query = "SELECT * FROM product WHERE user_id ='".$user_id."'";
$result = $conn->query($query);

if (!$result) {
    echo "Error: $conn->error";
    echo "<br> There was an error fetching the product details, please try again later.";
}

$fetchedData = array();
while ($row = $result->fetch_assoc()) {
    $fetchedData[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer | Self Products</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans h-screen">

<!-- Responsive Navbar -->
<nav class="bg-blue-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo / Brand Name -->
        <div class="flex items-center">
            <a href="farmer_dashboard.php">
                <img src="logo.jpeg" alt="logo" class="h-10 w-auto">
            </a>
        </div>
        
        <!-- Hamburger Icon for Mobile -->
        <div class="block md:hidden">
            <button id="nav-toggle" class="focus:outline-none text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        
        <!-- Links for Large Screens -->
        <ul class="hidden md:flex space-x-6 text-white">
            <li><a href="farmer_dashboard.php" class="hover:text-gray-200">Home</a></li>
            <li><a href="farmer_add_product.php" class="hover:text-gray-200">Add Product</a></li>
            <li><a href="farmer_products.php" class="hover:text-gray-200">Product By Me</a></li>
            <li><a href="user_farmer_comment.php" class="hover:text-gray-200">Comments</a></li>
            <li><a href="logout.php" class="hover:text-gray-200">Logout</a></li>
        </ul>
    </div>
    
    <!-- Dropdown Menu for Mobile -->
    <div id="nav-content" class="hidden md:hidden bg-blue-700 text-white">
        <ul class="flex flex-col space-y-2 p-4">
            <li><a href="farmer_dashboard.php" class="hover:text-gray-200">Home</a></li>
            <li><a href="farmer_add_product.php" class="hover:text-gray-200">Add Product</a></li>
            <li><a href="farmer_products.php" class="hover:text-gray-200">Product By Me</a></li>
            <li><a href="user_farmer_comment.php" class="hover:text-gray-200">Comments</a></li>
            <li><a href="logout.php" class="hover:text-gray-200">Logout</a></li>
        </ul>
    </div>
</nav>

<!-- JavaScript for toggling the mobile menu -->
<script>
    document.getElementById('nav-toggle').onclick = function() {
        document.getElementById('nav-content').classList.toggle('hidden');
    }
</script>

<h1 class="text-2xl font-bold text-center mt-8 text-gray-700">My Products</h1>

<div class="max-w-6xl mx-auto mt-8 h-full">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-full">
        <?php 
        foreach ($fetchedData as $row): 
        ?>
        <div class="bg-white shadow-lg rounded-lg p-6 h-full flex flex-col justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800"><?php echo htmlspecialchars($row['product_name']); ?></h2>
                <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($row['description']); ?></p>
                <p class="text-gray-800 font-medium mt-4">Price: <?php echo htmlspecialchars($row['price']); ?></p>
                <p class="text-gray-800 font-medium mt-2">Category: <?php echo htmlspecialchars($row['category']); ?></p>
                <div class="mt-4">
                    <?php
                    $product_id = $row['product_id'];
                    $folder_name_query = "SELECT user_id FROM product WHERE product_id = '".$product_id."'";
                    $result_folder_name = $conn->query($folder_name_query);

                    if (!$result_folder_name) {
                        echo "Error: $conn->error";
                        echo "<br> There was an error fetching the folder name for the post.";
                    }

                    $directory = $result_folder_name->fetch_assoc();
                    $directory_name = $directory['user_id'];

                    $fileDir = "uploads/$directory_name/$product_id";

                    if (is_dir($fileDir)) {
                        $files = scandir($fileDir);
                        foreach ($files as $file) {
                            if ($file !== '.' && $file !== '..') {
                                $filePath = "$fileDir/$file";
                                $fileType = mime_content_type($filePath);

                                if (strpos($fileType, 'image') !== false) {
                                    echo "<img src='$filePath' alt='Product Image' class='w-full h-48 object-cover mt-4 rounded-lg border'>";
                                } elseif (strpos($fileType, 'video') !== false) {
                                    echo "<video controls class='w-full h-48 mt-4 rounded-lg border'><source src='$filePath' type='$fileType'>Your browser does not support the video tag.</video>";
                                }
                                break; // Display only the first valid file
                            }
                        }
                    } else {
                        // No files, display upload form
                        echo "<form action='upload_file.php' method='post' enctype='multipart/form-data' class='mt-4'>";
                        echo "<input type='hidden' name='MAX_FILE_SIZE' value='100000000' />";
                        echo "<input type='hidden' name='product_id' value='{$row['product_id']}' />";
                        echo "<input type='hidden' name='directory_name' value='$directory_name' />";
                        echo "<input type='file' name='the_file[]' class='mt-2 border rounded-lg p-2' multiple/>";
                        echo "<button type='submit' class='mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600'>Upload</button>";
                        echo "</form>";
                    }
                    ?>
                </div>
            </div>
            <div class="mt-4 flex space-x-4">
                <a href="farmer_seller_edit_product.php?product_id=<?php echo $row['product_id']; ?>" class="text-blue-500 hover:text-blue-600">Edit</a>
                <a href="farmer_seller_delete_product.php?product_id=<?php echo $row['product_id']; ?>&role=farmer" class="text-red-500 hover:text-red-600">Delete</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>

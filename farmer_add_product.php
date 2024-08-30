<?php

session_start();

// Check if the user is logged in and has the "administrator" role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'farmer') {
    echo "You do not have permission to access this page.";
    // Add a CSS class to make the page content appear faded and unclickable
    echo '<style>body { pointer-events: none; }</style>';
    exit();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer | Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
    </style>
</head>
<body class="bg-gray-100">

<nav class="bg-gray-800 text-white">
    <ul class="flex justify-center space-x-4 p-4">
        <li><a href="farmer_dashboard.php" class="hover:underline">Home</a></li>
        <li><a href="farmer_add_product.php" class="hover:underline">Add Product</a></li>
        <li><a href="farmer_products.php" class="hover:underline">Product By Me</a></li>
        <li><a href="user_farmer_comment.php" class="hover:underline">Comments</a></li>
        <li><a href="logout.php" class="hover:underline">Logout</a></li>
    </ul>
</nav>

<div class="container bg-white shadow-md rounded-lg p-6 mt-6">
    <h1 class="text-2xl font-bold mb-6 text-center">Farmer | Add Product</h1>
    <form action="farmer_add_product1.php" method="POST">
        <table class="w-full table-auto border-collapse">
            <tr>
                <td class="py-2 px-4 border-b">Name</td>
                <td class="py-2 px-4 border-b">
                    <input type="text" name="product_name" class="w-full p-2 border rounded" required>
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border-b">Description</td>
                <td class="py-2 px-4 border-b">
                    <textarea name="product_description" class="w-full p-2 border rounded" rows="4" required></textarea>
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border-b">Price($)</td>
                <td class="py-2 px-4 border-b">
                    <input type="number" name="product_price" min="0" class="w-full p-2 border rounded" required>
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border-b">Category</td>
                <td class="py-2 px-4 border-b">
                    <select name="product_category" class="w-full p-2 border rounded" required>
                        <option value="product">Agricultural Product</option>
                        <option value="tool">Agricultural Tool</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="py-4 text-center">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Upload</button>
                </td>
            </tr>
        </table>
    </form>
</div>

</body>
</html>

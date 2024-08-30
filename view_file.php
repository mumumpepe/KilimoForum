<?php
// Check if the necessary parameters are provided
if (!isset($_GET["user_id"]) || !isset($_GET["product_id"]) || !isset($_GET["file_name"])) {
    echo "Invalid parameters";
    exit();
}

// Retrieve parameters from the URL
$userId = $_GET["user_id"];
$product_id = $_GET["product_id"];
$fileName = $_GET["file_name"];
$id = $_GET['product_id'];

// Construct the file path
$filePath = "uploads/$userId/$product_id/$fileName";

// Check if the file exists
if (file_exists($filePath)) {
    // Determine the MIME type
    $fileType = mime_content_type($filePath);

    // Set appropriate headers for the MIME type
    header("Content-Type: $fileType");

    // Output the file contents
    readfile($filePath);
} else {
    // File not found
    echo "File not found";
}
?>

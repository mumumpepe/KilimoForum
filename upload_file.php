<?php
// Function to display messages
function displayMessage($message, $type = 'success') {
    echo '<div class="message ' . $type . '">' . $message . '</div>';
}

// Handle multiple file uploads
$errors = [];
$uploadedFiles = [];

if (!isset($_FILES['the_file']) || !is_array($_FILES['the_file']['name'])) {
    displayMessage('Problem: No files uploaded or invalid file array', 'error');
    exit;
}

// Loop through each file
foreach ($_FILES['the_file']['name'] as $key => $fileName) {
    $fileTmpName = $_FILES['the_file']['tmp_name'][$key];
    $fileError = $_FILES['the_file']['error'][$key];
    $fileType = $_FILES['the_file']['type'][$key];

    // Check for upload errors
    if ($fileError) {
        switch ($fileError) {
            case 1:
                $errors[] = 'File exceeded upload_max_filesize';
                break;
            case 2:
                $errors[] = 'File exceeded max_file_size';
                break;
            case 3:
                $errors[] = 'File only partially uploaded';
                break;
            case 4:
                $errors[] = 'No file uploaded';
                break;
            case 6:
                $errors[] = 'Cannot upload file: No temp directory specified';
                break;
            case 7:
                $errors[] = 'Upload failed: Cannot write to disk';
                break;
            default:
                $errors[] = 'Unknown error';
                break;
        }
        continue;
    }

    // Check if the file has the right MIME type
    $allowedFileTypes = ['video/*', 'image/*'];
if (!fnmatch($allowedFileTypes[0], $fileType) && !fnmatch($allowedFileTypes[1], $fileType)) {
    $errors[] = 'File type ' . $fileType . ' is not supported';
    continue;
}


    // Variables for file directories
    $product_id = $_POST['product_id'];
    $directory_name = $_POST['directory_name'];

    // Create user directory if not exists
    $userDir = 'uploads/' . $directory_name;
    if (!file_exists($userDir)) {
        mkdir($userDir, 0777, true); // Create directory with full permissions
    }

    // Create productId number directory if not exists
    $productIdDir = $userDir . '/' . $product_id;
    if (!file_exists($productIdDir)) {
        mkdir($productIdDir, 0777, true); // Create directory with full permissions
    }

    // Put the file where we'd like it
    $upfile = $productIdDir . '/' . $fileName;
    if (is_uploaded_file($fileTmpName)) {
        if (!move_uploaded_file($fileTmpName, $upfile)) {
            $errors[] = 'Could not move file to destination directory';
            continue;
        }
        $uploadedFiles[] = $upfile;
    } else {
        $errors[] = 'Possible file upload attack. Filename: ' . $fileName;
    }
}

// Display messages
if (!empty($errors)) {
    foreach ($errors as $error) {
        displayMessage('Problem: ' . $error, 'error');
    }
} else {
    displayMessage('Media file(s) uploaded successfully');
}

// Show the uploaded files
if (!empty($uploadedFiles)) {
    echo '<div class="file-display">';
    foreach ($uploadedFiles as $filePath) {
        $fileType = mime_content_type($filePath);

        if (strpos($fileType, 'image') !== false) {
            // Display image
            echo '<img src="' . $filePath . '" class="uploaded-image" />';
        } elseif (strpos($fileType, 'video') !== false) {
            // Display uploaded video
            echo '<video src="' . $filePath . '" controls class="uploaded-video"><source src="' . $filePath . '" type="' . $fileType . '">Your browser does not support the video tag.</video>';
        } else {
            // Unsupported file type
            echo 'Uploaded file: <a href="' . $filePath . '">' . basename($filePath) . '</a>';
        }
    }
    echo '</div>';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Uploading File</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(0, 0, 0, 0.7);
            margin: 0;
            padding: 0;
        }

        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: #fff;
            text-align: center;
            max-width: 500px;
            margin: 0 auto;
        }

        .message.success {
            background-color: #28a745;
            border: 1px solid #1e7e34;
        }

        .message.error {
            background-color: #dc3545;
            border: 1px solid #c82333;
        }

        .file-display {
            margin-top: 20px;
            text-align: center;
            padding: 20px;
        }

        .uploaded-image {
            max-width: 100%;
            max-height: 400px;
            display: block;
            margin: 0 auto;
            border-radius: 8px;
        }

        .uploaded-video {
            width: 80vw;
            height: 80vh;
            border-radius: 8px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <script>
        // Redirect to previous page after 3 seconds
        setTimeout(function() {
            window.history.back();
        }, 3000);
    </script>
</body>
</html>

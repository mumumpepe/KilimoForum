<?php
//session control
session_start();

include("edited_home.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7fafc;
            color: #2d3748;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            min-height: 100vh;
        }

        .nav, .main-content {
            padding: 16px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 16px;
        }


        .nav.fixed {
            position: fixed;
            height: 100%;
            top: 0;
            padding: 16px;
            background-color: #edf2f7;
            box-shadow: none;
        }

        
    .nav {
        position: fixed;
        top: 0;
        bottom: 0;
        display: flex;
        flex-direction: column;
        justify-content: center; /* Centers content vertically */
        padding: 10px;
        background-color: #f8f9fa; /* Optional: Add a background color */
        border-right: 1px solid #ddd; /* Optional: Add a border for better separation */
    }

    .nav.left {
        left: 0;
        width: 15%;
    }

    .nav.right {
        right: 0;
        width: 15%;
    }


        .nav a {
            display: block;
            padding: 12px;
            margin-bottom: 8px;
            background-color: #38a169;
            color: #ffffff;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease-in-out;
        }

        .nav a:hover {
            background-color: #2f855a;
        }

        .main-content {
            width: 100%;
            padding-top: 16px;
            padding-bottom: 16px;
            text-align: center;
        }

        .main-content h1 {
            font-size: 24px;
            font-weight: bold;
            color: #2f855a;
            margin-bottom: 24px;
        }

        .main-content .product {
            margin-bottom: 24px;
            padding: 16px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        .main-content .product img, .main-content .product video {
            max-width: 100%;
            border-radius: 8px;
        }

        .main-content table {
            width: 100%;
            border-collapse: collapse;
        }

        .main-content table td {
            padding: 8px;
            vertical-align: top;
        }

        .main-content .btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #38a169;
            color: #ffffff;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 8px;
            transition: background-color 0.3s ease-in-out;
        }

        .main-content .btn:hover {
            background-color: #2f855a;
        }

        @media (min-width: 1024px) {
            .nav {
                width: 25%;
            }

            .main-content {
                width: 50%;
                margin-left: 25%;
                margin-right: 25%;
            }
        }

    </style>
</head>
<body>

<div class="container">

    <!-- Left Navigation -->
    <div class="nav fixed left">
        <a href="#">Home</a>
        <a href="#">Forum</a>
        <a href="#">Tools</a>
        <a href="#">Products</a>
        <a href="#">Trends</a>
        <a href="#">Bests</a>
        <a href="#">Home</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Kilimo Forum</h1>

        <div class="products">
            <?php foreach($fetcheProducts as $row): ?>
            <div class="product">
                <table>
                    <tr>
                        <td colspan="2">
                            <?php
                            $fileName = "";
                            $product_id = $row['product_id'];
                            $directory_name = $row['user_id'];

                            // Check if file directory exists
                            $fileDir = "uploads/$directory_name/{$row['product_id']}";
                            if (is_dir($fileDir)) {
                                // file directory exists
                                $files = scandir($fileDir);
                                if (count($files) > 2) {
                                    // Display view and delete icons if there are files
                                    foreach ($files as $file) {
                                        if ($file !== '.' && $file !== '..') {
                                            $fileName = $file;
                                        }
                                    }
                                } else {
                                    echo "No Uploaded Video/Picture";
                                }
                            } else {
                                echo "No Uploaded Video/Picture";
                            }

                            // Construct the file path
                            $filePath = "uploads/{$row['user_id']}/{$row['product_id']}/$fileName";

                            // Check if the file exists
                            if (file_exists($filePath)) {
                                // Determine the MIME type
                                $fileType = mime_content_type($filePath);

                                // Output the video or image tag based on the MIME type
                                if (strpos($fileType, 'video') !== false) {
                                    // If the file is a video
                                    echo '<video src="' . $filePath . '" controls class="w-full rounded-lg"></video>';
                                } elseif (strpos($fileType, 'image') !== false) {
                                    // If the file is an image
                                    echo '<img src="' . $filePath . '" alt="Product Image" class="w-full rounded-lg">';
                                } else {
                                    echo 'File type not supported';
                                }
                            } else {
                                // File not found
                                echo "File not found";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo $row['product_name'] ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo $row['description'] ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo $row['price'] ?></td>
                    </tr>
                    <tr>
                        <td><a href="chat_with_farmer_seller.php?seller_id=<?php echo $row['user_id'] ?>&product_id=<?php echo $row['product_id'] ?>" class="btn">Chat With Seller</a></td>
                        <td><button class="btn" onclick="showCommentBox('<?php echo $row['product_id'] ?>')">Comment</button></td>
                    </tr>
                    <tr>
                        <td><a href="purchase_from_farmer.php" class="btn">Purchase</a></td>
                        <td>Share</td>
                    </tr>
                    <tr>
                    <form id="commentForm_<?php echo $row['product_id']; ?>" action="commenting_from_user.php" method="POST">
                        <td>
                            <textarea id="comment_<?php echo $row['product_id'] ?>" name="comment_content" class="w-full p-2 border rounded" style="display:none;"></textarea>
                            <button type="button" id="button_<?php echo $row['product_id']; ?>" class="btn mt-2" style="display:none;" onclick="postComment('<?php echo $row['product_id'] ?>')">Post</button>
                            <button type="button" id="close_<?php echo $row['product_id']; ?>" class="btn mt-2" style="display:none;" onclick="closeCommentBox('<?php echo $row['product_id'] ?>')">Close</button>
                            <input type="hidden" name="farmer_seller_id" value="<?php echo $row['user_id'] ?>">
                            <input type="hidden" name="product_id" value="<?php echo $row['product_id'] ?>">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                        </td>
                    </form>
                    </tr>
                    <tr>
                        <td class="comment-box" id="comment-box_<?php echo $row['product_id'] ?>">
                            <div class="comment-container" id="comments_<?php echo $row['product_id'] ?>">
                                <div>No comments yet.</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Right Navigation -->
    <div class="nav fixed right">
        <a href="#">Profile</a>
        <a href="#">Forum</a>
        <a href="#">Tools</a>
        <a href="#">Products</a>
        <a href="#">Trends</a>
        <a href="#">Bests</a>
        <a href="logout.php">Logout</a>
    </div>

</div>

</body>
</html>

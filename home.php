<?php
//session control
session_start();

//database connection
include("db_connection.php");

//select all the products in the database
$query = "SELECT * FROM product";
$result = $conn->query($query);

if(!$result){
    echo "$conn->error";
    echo "There was an error with fetching the products from the database, please try again later";
}

$fetcheProducts = array();
while($row = $result->fetch_assoc()){
    $fetcheProducts[] = $row;
}

// Fetch comments for each product
$comments = array();
foreach ($fetcheProducts as $product) {
    $product_id = $product['product_id'];
    $comment_query = "SELECT * FROM comment WHERE post_id = '$product_id' ORDER BY timestamp DESC";
    $comment_result = $conn->query($comment_query);
    if ($comment_result) {
        while ($comment_row = $comment_result->fetch_assoc()) {
            $comments[$product_id][] = $comment_row;
        }
    } else {
        $comments[$product_id] = array();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kilimo Forum</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        h1 {
            text-align: center;
        }
        a {
            text-decoration: none;
        }
        th {
            text-align: left;
        }
        textarea, button.comment-button, button.close-button, .comment-box {
            display: none;
        }
        .button-visible {
            display: block;
        }
        .comment-container {
            max-height: 200px; /* Adjust as needed */
            overflow-y: auto;
        }
        .comment {
            border-top: 1px solid #ccc;
            margin-top: 10px;
            padding-top: 10px;
        }
        .comment-author {
            font-weight: bold;
        }
        .comment-timestamp {
            font-size: 0.8em;
            color: #999;
        }
    </style>

</head>
<body>
<nav>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li>
            <a href="/forums">Forums</a>
            <ul class="dropdown">
                <li><a href="tools.php">Tools</a></li>
                <li><a href="techniques">Techniques</a></li>
                <li><a href="product-reviews">Product Reviews</a></li>
                <li><a href="buy-sell">Buy/Sell</a></li>
            </ul>
        </li>
        <li>
            <a href="/products">Products</a>
            <ul class="dropdown">
                <li><a href="new-arrivals">New Arrivals</a></li>
                <li><a href="best-sellers">Best Sellers</a></li>
                <li><a href="categories">Categories</a></li>
            </ul>
        </li>
        <li><a href="/articles">Articles</a></li>
        <li><a href="/events">Events</a></li>
        <li><a href="/resources">Resources</a></li>
        <li><a href="/about">About Us</a></li>
        <li><a href="/contact">Contact Us</a></li>
        <li>
            <a href="/profile">Account</a>
            <ul class="dropdown">
                <li><a href="/profile">My Profile</a></li>
                <li><a href="/profile/settings">Settings</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </li>
        <li><a href="/login">Login/Signup</a></li>
        <li>
            <form action="/search" method="GET">
                <input type="text" name="query" placeholder="Search...">
            </form>
        </li>
    </ul>
</nav>
<h1>Welcome to KilimoForum </h1>
<br><hr>
<table>
    <?php foreach($fetcheProducts as $row): ?>
        <tr>
            <td>

        <?php

        /*
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

    // Set appropriate headers for the MIME type
    header("Content-Type: $fileType");

    // Output the file contents
   // readfile($filePath);
   echo ' <video src ="<?php echo $filePath.$fileType ?>" controls > ';
} else {
    // File not found
    echo "File not found";
}

*/

         ?>

</td>


        </tr>
        <tr>
            <td>
                <strong><?php echo $row['product_name'] ?></strong>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $row['description'] ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $row['price'] ?>
            </td>
        </tr>
        <tr>
            <td><a href="chat_with_farmer_seller.php?seller_id=<?php echo $row['user_id'] ?>&product_id=<?php echo $row['product_id'] ?>">Chat With Seller</a></td>
            <td><button class="button-visible" onclick="showCommentBox('<?php echo $row['product_id'] ?>')">Comment</button></td>
            <td><a href="purchase_from_farmer.php">Purchase</a></td>
        </tr>
        <tr>
            <form id="commentForm_<?php echo $row['product_id']; ?>" action="commenting_from_user.php" method="POST">
            <td>
                <textarea id="comment_<?php echo $row['product_id'] ?>" name="comment_content"></textarea>
                <button type="button" id="button_<?php echo $row['product_id']; ?>" class="comment-button" onclick="postComment('<?php echo $row['product_id'] ?>')">Post</button>
                <button type="button" id="close_<?php echo $row['product_id']; ?>" class="close-button" onclick="closeCommentBox('<?php echo $row['product_id'] ?>')">Close</button>
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
    <?php endforeach; ?>
</table>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
function showCommentBox(productId) {
    document.getElementById('comment_' + productId).style.display = 'block';
    document.getElementById('button_' + productId).style.display = 'block';
    document.getElementById('close_' + productId).style.display = 'block';
    document.getElementById('comment-box_' + productId).style.display = 'block';

    loadComments(productId);
}

function closeCommentBox(productId) {
    document.getElementById('comment_' + productId).style.display = 'none';
    document.getElementById('button_' + productId).style.display = 'none';
    document.getElementById('close_' + productId).style.display = 'none';
    document.getElementById('comment-box_' + productId).style.display = 'none';
}


function loadComments(productId) {
    $.ajax({
        url: 'fetch_comments.php',
        type: 'POST',
        data: { product_id: productId },
        success: function(response) {
            console.log('AJAX Response:', response); // Add this line
            const res = JSON.parse(response);
            if (res.success) {
                const commentContainer = document.getElementById('comments_' + productId);
                commentContainer.innerHTML = '';
                res.comments.forEach(comment => {
                    const commentDiv = document.createElement('div');
                    commentDiv.className = 'comment';
                    commentDiv.innerHTML = `
                        <div class="comment-author">${comment.username}</div>
                        <div class="comment-content">${comment.comment_content}</div>
                        <div class="comment-timestamp">${comment.timestamp}</div>
                    `;
                    commentContainer.appendChild(commentDiv);
                });
            } else {
                alert(res.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ', status, error);
            alert('There was an error loading comments. Please try again.');
        }
    });
}



function postComment(productId) {
    const commentContent = document.getElementById('comment_' + productId).value;
    if (!commentContent.trim()) {
        alert('Comment cannot be empty.');
        return;
    }

    $.ajax({
        url: 'commenting_from_user.php',
        type: 'POST',
        data: {
            comment_content: commentContent,
            farmer_seller_id: document.querySelector('input[name="farmer_seller_id"]').value,
            product_id: productId,
            user_id: document.querySelector('input[name="user_id"]').value
        },
        success: function(response) {
            const res = JSON.parse(response);
            if (res.success) {
                const commentContainer = document.getElementById('comments_' + productId);
                const newComment = document.createElement('div');
                newComment.className = 'comment';
                newComment.innerHTML = `
                    <div class="comment-author">${res.comment.username}</div>
                    <div class="comment-content">${res.comment.comment_content}</div>
                    <div class="comment-timestamp">${res.comment.timestamp}</div>
                `;
                commentContainer.prepend(newComment); // Add new comment to the top
                document.getElementById('comment_' + productId).value = ''; // Clear the textarea
                // Do not close the comment box
            } else {
                alert(res.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ', status, error);
            alert('There was an error posting your comment. Please try again.');
        }
    });
}
</script>

</body>
</html>

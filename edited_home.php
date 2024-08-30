<?php


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
    <style>
    a {
        text-decoration: none;
        color: #007bff; /* Change link color */
    }

    a:hover {
        text-decoration: underline;
    }

    th {
        text-align: left;
        padding: 8px;
    }

    textarea {
        width: 100%;
        padding: 8px;
        margin: 4px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        padding: 8px 16px;
        margin: 4px;
        border: none;
        border-radius: 4px;
        color: #fff;
        cursor: pointer;
        font-size: 0.9em;
    }

    .comment-button {
        background-color: #28a745; /* Green for post button */
    }

    .close-button {
        background-color: #dc3545; /* Red for close button */
    }

    .comment-box {
        display: none;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
    }

    .button-visible {
        display: block;
    }

    .comment-container {
        max-height: 200px; /* Adjust as needed */
        overflow-y: auto;
        margin-top: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #fff;
    }

    .comment {
        border-top: 1px solid #ccc;
        margin-top: 10px;
        padding-top: 10px;
    }

    .comment-author {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .comment-timestamp {
        font-size: 0.8em;
        color: #999;
        margin-top: 5px;
    }

    .reply-container {
        margin-left: 20px;
        margin-top: 10px;
    }

    .reply {
        border-top: 1px solid #eee;
        padding: 8px 0;
    }

    .reply-author {
        font-weight: bold;
    }

    .reply-content {
        margin-top: 5px;
    }

    .reply-timestamp {
        font-size: 0.8em;
        color: #aaa;
        margin-top: 5px;
    }
</style>

</head>
<body>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
function showCommentBox(productId) {
    // Close all comment boxes first
    closeAllCommentBoxes();

    // Show the comment box, Post, and Close buttons for the selected product
    document.getElementById('comment_' + productId).style.display = 'block';
    document.getElementById('button_' + productId).style.display = 'block';
    document.getElementById('close_' + productId).style.display = 'block';
    document.getElementById('comment-box_' + productId).style.display = 'block';

    loadComments(productId);
}

function closeAllCommentBoxes() {
    const commentTextareas = document.querySelectorAll('textarea[id^="comment_"]');
    const commentButtons = document.querySelectorAll('button[id^="button_"]');
    const closeButtons = document.querySelectorAll('button[id^="close_"]');
    const commentBoxes = document.querySelectorAll('td[id^="comment-box_"]');

    commentTextareas.forEach(textarea => textarea.style.display = 'none');
    commentButtons.forEach(button => button.style.display = 'none');
    closeButtons.forEach(button => button.style.display = 'none');
    commentBoxes.forEach(box => box.style.display = 'none');
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
            const res = JSON.parse(response);
            if (res.success) {
                const commentContainer = document.getElementById('comments_' + productId);
                commentContainer.innerHTML = ''; // Clear existing comments

                res.comments.forEach(comment => {
                    const commentDiv = document.createElement('div');
                    commentDiv.className = 'comment';
                    commentDiv.id = 'comment_' + comment.comment_id;
                    commentDiv.innerHTML = `
                        <div class="comment-author">${comment.username}</div>
                        <div class="comment-content">${comment.comment_content}</div>
                        <div class="comment-timestamp">${comment.timestamp}</div>
                        <div id="reply-form_${comment.comment_id}" style="display: none;">
                            <textarea id="reply_${comment.comment_id}" placeholder="Write a reply..."></textarea>
                            <button onclick="postReply(${comment.comment_id}, ${productId})">Submit Reply</button>
                        </div>
                        <div class="reply-container" id="replies_${comment.comment_id}">
                            <!-- Replies will be loaded here -->
                        </div>
                    `;
                    commentContainer.prepend(commentDiv); // Add the latest comment to the top
                    loadReplies(comment.comment_id); // Load replies for the current comment
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

// This function will automatically display the comment box for all products on page load
function initializeCommentBoxes() {
    <?php foreach($fetcheProducts as $product): ?>
        showCommentBox('<?php echo $product['product_id']; ?>');
    <?php endforeach; ?>
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
                closeAllCommentBoxes(); // Close all comment boxes after posting
                showCommentBox(productId); // Reopen the current one to see the comment
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



function toggleReplyForm(commentId) {
    const form = document.getElementById('reply-form_' + commentId);
    form.style.display = (form.style.display === 'none') ? 'block' : 'none';
}

function loadReplies(commentId) {
    $.ajax({
        url: 'fetch_replies.php',
        type: 'POST',
        data: { comment_id: commentId },
        success: function(response) {
            const res = JSON.parse(response);
            if (res.success) {
                const replyContainer = document.getElementById('replies_' + commentId);
                replyContainer.innerHTML = ''; // Clear existing replies
                res.replies.forEach(reply => {
                    const replyDiv = document.createElement('div');
                    replyDiv.className = 'reply';
                    replyDiv.innerHTML = `
                        <div class="reply-author">${reply.username}</div>
                        <div class="reply-content">${reply.reply_content}</div>
                        <div class="reply-timestamp">${reply.timestamp}</div>
                    `;
                    replyContainer.appendChild(replyDiv);
                });
            } else {
                alert(res.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ', status, error);
            alert('There was an error loading replies. Please try again.');
        }
    });
}

function postReply(commentId, productId) {
    const replyContent = document.getElementById('reply_' + commentId).value;
    if (!replyContent.trim()) {
        alert('Reply cannot be empty.');
        return;
    }

    $.ajax({
        url: 'posting_reply.php',
        type: 'POST',
        data: {
            reply_content: replyContent,
            parent_comment_id: commentId,
            product_id: productId,
            user_id: document.querySelector('input[name="user_id"]').value
        },
        success: function(response) {
            const res = JSON.parse(response);
            if (res.success) {
                const replyContainer = document.getElementById('replies_' + commentId);
                const newReply = document.createElement('div');
                newReply.className = 'reply';
                newReply.innerHTML = `
                    <div class="reply-author">${res.reply.username}</div>
                    <div class="reply-content">${res.reply.reply_content}</div>
                    <div class="reply-timestamp">${res.reply.timestamp}</div>
                `;
                replyContainer.prepend(newReply); // Add the new reply to the top
                document.getElementById('reply_' + commentId).value = ''; // Clear the textarea
                toggleReplyForm(commentId); // Close the reply form
            } else {
                alert(res.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ', status, error);
            alert('There was an error posting your reply. Please try again.');
        }
    });
}

</script>

</body>
</html>

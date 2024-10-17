var currentPostId; // Store the postId globally

// Function to open the modal and load the comments for a specific post
function openCommentsModal(postId) {
    currentPostId = postId; // Set the current post ID
    $("#CommentsModal")[0].showModal(); // Open the modal

    // Load comments via AJAX
    $.ajax({
        type: "GET",
        url: "../Actions/dashBoard.php",
        data: { postId: currentPostId, action: "getComments" },
        dataType: "json",
        success: function(response) {
            if (response.status === "success") {
                // Clear previous comments
                $("#commentsContainer").html("");

                // Append comments dynamically
                response.comments.forEach(function(comment) {
                    $("#commentsContainer").append(`
                        <div class="outline outline-1 outline-gray-300 inline-block rounded-full px-5 py-3 my-2">
                            <p class="block"><strong>${comment.author}</strong></p>
                            <p class="block">${comment.text}</p>
                        </div>
                    `);
                });
            } else {
                console.error("Error loading comments: " + response.message);
            }
        },
        error: function(err) {
            console.error(err);
        }
    });
}

// Function to add a new comment
function addComment() {
    var commentText = $("#commentOnPost").val();
    if (commentText.trim() === "") {
        alert("Comment cannot be empty");
        return;
    }

    // Send the comment to the server
    $.ajax({
        type: "POST",
        url: "../Actions/dashBoard.php",
        data: {
            postId: currentPostId,
            comment: commentText,
            action: "addComment"
        },
        dataType: "json",
        success: function(response) {
            if (response.status === "success") {
                // Append the new comment to the comments container
                $("#commentsContainer").append(`
                    <div class="outline outline-1 outline-gray-300 inline-block rounded-full px-5 py-3 my-2">
                        <p class="block"><strong>${response.comment.author}</strong></p>
                        <p class="block">${response.comment.text}</p>
                    </div>
                `);
                $("#commentOnPost").val(""); // Clear the input field
            } else {
                console.error("Error adding comment: " + response.message);
            }
        },
        error: function(err) {
            console.error(err);
        }
    });
}

function getComments(postId) {
    $.ajax({
        type: "POST",
        url: "../Actions/comments.php",
        data: {
            postId: postId,
            action: "getComments"
        },
        dataType: "json",
        success: function(response) {
            if (response.status === "success") {
                // Clear previous comments
                $("#commentsContainer").html("");

                // Append comments dynamically  
                response.comments.forEach(function(comment) {
                    $("#commentsContainer").append(`
                        <div class="outline outline-1 outline-gray-300 inline-block rounded-full px-5 py-3 my-2">
                            <p class="block"><strong>${comment.author}</strong></p>
                            <p class="block">${comment.text}</p>
                        </div>
                    `);
                });
            } else {
                console.error("Error loading comments: " + response.message);
            }
        },  
        error: function(err) {
            console.error(err);
        }
    });  
}

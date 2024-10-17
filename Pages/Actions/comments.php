<?php
include_once("../database/DB.class.php");

if (isset($_POST['action'])) {
    
    if ($_POST['action'] == 'getComments') {
        try {
            $db = new DB();
            $post_id = $_POST['post_id'];
            // Call the custom function to get comments with authors
            $comments = $db->getPostCommentsWithAuthors($post_id); 
            
            if ($comments) {
                echo json_encode([
                    "status" => "success",
                    "comments" => $comments
                ]);
            } else {
                echo json_encode([
                    "status" => "success",
                    "comments" => []
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    
    }

    if ($_POST['action'] == 'addComment') {
        try {
            $post_id = $_POST['post_id'];
            $commentText = $_POST['content']; 
            $user_id = 22; 
    
            $db = new DB();
            
            $commentData = [
                'post_id' => $post_id,
                'content' => $commentText,
                'user_id' => $user_id,
            ];
            
            // Insert the comment and get the new comment ID
            $newCommentId = $db->insert('comments', $commentData);
            
            echo json_encode([
                "status" => "success",
                "message" => "Comment added successfully",
                "newCommentId" => $newCommentId
            ]);
 
        } catch (Exception $e) {
            // Handle any exceptions and return the error message
            echo json_encode([
                "status" => "error",
                "message" => "Error: " . $e->getMessage() // Provide detailed error message
            ]);
        }
    }
    
    
    
}


<?php
include_once("../database/DB.class.php");

if (isset($_POST['action'])) {
    
    // Save a new post
    if ($_POST['action'] == 'savePost') {
        try {
            $postData = $_POST['data'];
            $db = new DB();
            $newPost = $db->insert('posts', $postData);

            // Return success response with the new post ID
            if ($newPost) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Post saved successfully",
                    "postId" => $newPost
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to save post"
                ]);
            }
        } catch (Exception $e) {
            // Handle any exceptions and return an error message
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    // Get all posts
    if ($_POST['action'] == 'getPosts') {
        try {
            $db = new DB();
            $posts = $db->getRows('posts', []);
            echo json_encode($posts);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    // Delete a post
    if ($_POST['action'] == 'deletePost') {
        try {
            $postId = $_POST['postId'];
            $db = new DB();
            $deleteResult = $db->delete('posts', ['id' => $postId]);

            if ($deleteResult) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Post deleted successfully"
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to delete post"
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    // Get a post by ID
    if ($_POST['action'] == 'getPostById') {
        try {
            $postId = $_POST['postId'];
            $db = new DB();
            $post = $db->getRows('posts', ['id' => $postId]);
            echo json_encode([
                "status" => "success",
                "data" => $post
            ]);

        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    // Update a post
    if ($_POST['action'] == 'updatePost') {
        try {
            $postId = (int)$_POST['postId'];
            $postData = $_POST['data'];

            $db = new DB();
            $updateResult = $db->update('posts', $postData, ['id' => $postId]);

            if ($updateResult) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Post updated successfully"
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to update post"
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }
}

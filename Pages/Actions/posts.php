<?php
include_once("../database/DB.class.php");

if(!isset($_SESSION)){
    session_start();
  }

if (isset($_POST['action'])) {
    
    // Save a new post
    if ($_POST['action'] == 'savePost') {
        try {
            $postData = [
                'title' => $_POST['title'],
                'category' => $_POST['category'],
                'summary' => $_POST['summary'],
                'status' => $_POST['status'],
                'content'  => $_POST['content'],
                'author'  => $_SESSION['name']
            ];
    
            if (!empty($_FILES['img']['name'])) {
                $imageName = $_FILES['img']['name'];
                $imageTmpName = $_FILES['img']['tmp_name'];
                $imagePath = '../images/' . $imageName;
                move_uploaded_file($imageTmpName, $imagePath);
    
                $postData['img'] = $imagePath;
            }
    
            $db = new DB();
            $newPost = $db->insert('posts', $postData);
 
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
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    // Search posts
    if ($_POST['action'] == 'searchPosts') {
        try {
            $db = new DB();
            $posts = $db->searchPost('posts', ['title' => $_POST['value']]);
            echo json_encode($posts);
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
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
    
            // If data is sent in a nested format, retrieve it
            if (isset($_POST['data'])) {
                $postData = $_POST['data']; // This assumes that the form data is serialized into 'data'
            } else {
                // If the data is flat, just pull the individual fields from $_POST
                $postData = [
                    'title' => $_POST['title'],
                    'category' => $_POST['category'],
                    'summary' => $_POST['summary'],
                    'status' => $_POST['status'],
                    'content' => $_POST['content'],
                ];
            }
    
            // Handle image if it's part of the update
            if (!empty($_FILES['img']['name'])) {
                $imageName = $_FILES['img']['name'];
                $imageTmpName = $_FILES['img']['tmp_name'];
                $imagePath = '../images/' . $imageName;
                move_uploaded_file($imageTmpName, $imagePath);
    
                $postData['img'] = $imagePath; // Add image path to the post data for updating
            }
    
            // Update the post in the database
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

    if ($_POST['action'] == 'getPostsLikesComments') {
        try {
            $db = new DB();
            $posts = $db->getPostLikesComments('posts', []);
            echo json_encode($posts);
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }
    
}

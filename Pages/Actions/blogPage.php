<?php
include_once("../database/DB.class.php");

$postContent = null; // Initialize variable to hold post data

// Check if postId is passed
if (isset($_GET['postId'])) {
    $id = $_GET['postId'];
    try {
        // Create DB instance
        $db = new DB();

        // Fetch post data from 'posts' table based on postId from URL
        $postContent = $db->getRows('posts', ['id' => $id]);
        // print_r($postContent);

    } catch (Exception $e) {
        // Handle exception if there's an issue fetching the post
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Post ID not provided!";
}
?>

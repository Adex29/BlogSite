<?php
include_once("../database/DB.class.php");

$postContent = null;


if (isset($_GET['postId'])) {
    $id = $_GET['postId'];
    try {
 
        $db = new DB();

        $postContent = $db->getRows('posts', ['id' => $id]);

    } catch (Exception $e) {

        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Post ID not provided!";
}
?>

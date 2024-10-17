<?php
session_start();

include_once("../database/DB.class.php");

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'addLike') {
        try {
            
            $post_id = $_POST['post_id'];

            $db = new DB();

            $result = $db->insert('likes', [
                'post_id' => $post_id,
                'user_id' => $_SESSION['userId']
            ]);

            if ($result) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Post liked successfully."
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to like the post."
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
?>

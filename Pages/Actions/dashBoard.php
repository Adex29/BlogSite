<?php
include_once("../database/DB.class.php");

if(isset($_POST['action'])) {
    if($_POST['action'] == 'saveUser') {
        try {

            $userData = $_POST['data'];
            $db = new DB();
            $newUser = $db->insert('users', $userData);

            // Return success response with the new user ID
            if ($newUser) {
                echo json_encode([
                    "status" => "success",
                    "message" => "User saved successfully",
                    "userId" => $newUser
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to save user"
                ]);
            }
        } catch (Exception $e) {
            // Handle any exceptions and return an error message
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    if($_POST['action'] == 'getUsers') {
        try {
            $db = new DB();
            $users = $db->getRows('users', []);
            echo json_encode($users);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    if($_POST['action'] == 'deleteUser') {
        try {
            $userId = $_POST['userId'];
            $db = new DB();
            $deleteResult = $db->delete('users', ['id' => $userId]);
    
            if ($deleteResult) {
                echo json_encode([
                    "status" => "success",
                    "message" => "User deleted successfully"
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to delete user"]);
            }
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()]);
        }
    }

    if($_POST['action'] == 'getUserById') {
        try {
            $userId = $_POST['userId'];
            $db = new DB();
            $user = $db->getRows('users', ['id' => $userId]);
            echo json_encode([
                "status" => "success",
                "data" => $user
            ]);

        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    if ($_POST['action'] == 'updateUser') {
        try {
            $userId = (int)$_POST['userId'];
            $userData = $_POST['data'];
    
            $db = new DB();
            $updateResult = $db->update('users', $userData, ['id' => $userId]);
    
            if ($updateResult) {
                echo json_encode([
                    "status" => "success",
                    "message" => "User updated successfully"
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to update user"
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

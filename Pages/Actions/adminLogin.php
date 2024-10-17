<?php
session_start();

include_once("../database/DB.class.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Authenticate') {
    try {
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            echo json_encode([
                "status" => "error",
                "message" => "Username and password cannot be empty.",
            ]);
            exit();
        }

        $db = new DB();

        $user = $db->getRows('users', ['email' => $email]);

        if ($user) {
            $hashedPassword = $user[0]['password'];

            if (password_verify($password, $hashedPassword)) {

                if ($user[0]['role'] == 'admin') {
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['userId'] = $user[0]['id'];
                    $_SESSION['name'] = $user[0]['first_name'] ." ". $user[0]['last_name'];
                    
                    echo json_encode([
                        "status" => "success",
                        "message" => "Authentication successful",
                        "userId" => $user[0]['id'],
                        "redirectUrl" => "../Admin/MainDashboard.php",
                        "name" => $_SESSION['name']
                    ]);
                } else{
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['userId'] = $user[0]['id'];
                    
                    echo json_encode([
                        "status" => "success",
                        "message" => "Authentication successful",
                        "userId" => $user[0]['id'],
                        "redirectUrl" => "../User/homePage.php"
                    ]);
                }
                
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Invalid username or password",
                ]);
            }
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "User not found",
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => "An error occurred: " . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request."
    ]);
}

?>

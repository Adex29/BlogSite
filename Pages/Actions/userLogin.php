<?php
if(!isset($_SESSION)){
    session_start();
  }

include_once("../database/DB.class.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Authenticate') {

    try {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            echo json_encode([
                "status" => "error",
                "message" => "Email and password cannot be empty.",
            ]);
            exit();
        }

        $db = new DB();

        $user = $db->getRows('users', ['email' => $email]);

        if ($user) {
            $hashedPassword = $user[0]['password'];
            $userRole = $user[0]['role'];

            if (password_verify($password, $hashedPassword)) {
                if ($userRole === 'user') {
                    $_SESSION['isLoggedIn'] = true;
                    $_SESSION['userId'] = $user[0]['id'];
                    $_SESSION['role'] = 'user';

                    echo json_encode([
                        "status" => "success",
                        "message" => "Login successful.",
                        "redirectUrl" => "../User/homePage.php",
                    ]);
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "Access denied. Only users can log in.",
                    ]);
                }
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Invalid email or password.",
                ]);
            }
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "User not found.",
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => "An error occurred: " . $e->getMessage(),
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request.",
    ]);
}

?>

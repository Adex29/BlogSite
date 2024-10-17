<?php
session_start();

include_once("../database/DB.class.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Authenticate') {
    try {
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if username and password are not empty
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

            // Verify the password against the hashed password
            if (password_verify($password, $hashedPassword)) {
                // Set session variables
                $_SESSION['loggedIn'] = true;
                $_SESSION['userId'] = $user[0]['id']; // Storing user ID in session
                
                echo json_encode([
                    "status" => "success",
                    "message" => "Authentication successful",
                    "userId" => $user[0]['id'],  // or any other user data you want to return
                    "redirectUrl" => "../Admin/MainDashboard.php" // Redirect URL on success
                ]);
            } else {
                // Password is incorrect; return an error response
                echo json_encode([
                    "status" => "error",
                    "message" => "Invalid username or password",
                ]);
            }
        } else {
            // User not found; return an error response
            echo json_encode([
                "status" => "error",
                "message" => "User not found",
            ]);
        }
    } catch (Exception $e) {
        // Handle any exceptions and return an error message
        echo json_encode([
            "status" => "error",
            "message" => "An error occurred: " . $e->getMessage()
        ]);
    }
} else {
    // Handle incorrect request method or missing action
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request."
    ]);
}

?>

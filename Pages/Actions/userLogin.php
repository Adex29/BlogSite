<?php
session_start();

include_once("../database/DB.class.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Authenticate') {

    try {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if email and password are not empty
        if (empty($email) || empty($password)) {
            echo json_encode([
                "status" => "error",
                "message" => "Email and password cannot be empty.",
            ]);
            exit();
        }

        $db = new DB();

        // Fetch user data from the database based on the email
        $user = $db->getRows('users', ['email' => $email]);

        if ($user) {
            $hashedPassword = $user[0]['password'];
            $userRole = $user[0]['role']; // Assuming there's a 'role' column in the users table

            // Verify the password against the hashed password
            if (password_verify($password, $hashedPassword)) {
                // Check if the user role is 'user'
                if ($userRole === 'user') {
                    // Set session variables for logged-in user
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['userId'] = $user[0]['id']; // Storing user ID in session
                    $_SESSION['role'] = 'user'; // Storing user role in session

                    echo json_encode([
                        "status" => "success",
                        "message" => "Login successful.",
                        "redirectUrl" => "../User/homePage.php", // Redirect URL for user home page
                    ]);
                } else {
                    // If the role is not 'user', deny access
                    echo json_encode([
                        "status" => "error",
                        "message" => "Access denied. Only users can log in.",
                    ]);
                }
            } else {
                // Password is incorrect
                echo json_encode([
                    "status" => "error",
                    "message" => "Invalid email or password.",
                ]);
            }
        } else {
            // User not found
            echo json_encode([
                "status" => "error",
                "message" => "User not found.",
            ]);
        }
    } catch (Exception $e) {
        // Handle any exceptions and return an error message
        echo json_encode([
            "status" => "error",
            "message" => "An error occurred: " . $e->getMessage(),
        ]);
    }
} else {
    // Handle invalid request method or missing action
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request.",
    ]);
}

?>

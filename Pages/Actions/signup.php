<?php
if(!isset($_SESSION)){
    session_start();
  }
include_once("../database/DB.class.php");

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'SignUp') {
    try {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate input
        if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
            echo json_encode([
                "status" => "error",
                "message" => "All fields are required.",
            ]);
            exit();
        }

        // Check if passwords match
        if ($password !== $confirm_password) {
            echo json_encode([
                "status" => "error",
                "message" => "Passwords do not match.",
            ]);
            exit();
        }

        $db = new DB();

        // Check if the email already exists
        $existingUser = $db->getRows('users', ['email' => $email]);

        if ($existingUser) {
            echo json_encode([
                "status" => "error",
                "message" => "Email already exists.",
            ]);
            exit();
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare data for insertion
        $data = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $hashedPassword,
        ];

        // Debugging: Output the data to see what is being inserted
        // Uncomment the line below to see the debug information
        // echo json_encode(["status" => "debug", "data" => $data]); exit();

        // Insert the new user into the database
        if ($db->insert('users', $data)) {
            echo json_encode([
                "status" => "success",
                "message" => "Sign-up successful.",
                "redirectUrl" => "../User/homePage.php", // Redirect URL on success
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "An error occurred while creating the account.",
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

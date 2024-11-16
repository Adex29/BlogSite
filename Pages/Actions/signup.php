<?php
require_once 'vendor/autoload.php';

if (!isset($_SESSION)) {
    session_start();
}
include_once("../database/DB.class.php");

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start(); // Start output buffering

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'SignUp') {
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

            // Insert the new user into the database
            $data = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => $hashedPassword,
                'role' => 'user',
                'method' => 'local'
            ];

            if ($db->insert('users', $data)) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Sign-up successful.",
                    "redirectUrl" => "../User/Login.php",
                ]);
                exit();
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "An error occurred while creating the account.",
                ]);
                exit();
            }
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => "An error occurred: " . $e->getMessage(),
            ]);
            exit();
        }
    }

    if ($action === 'GoogleSignUp') {
        try {
            $id_token = $_POST['id_token'] ?? '';

            if (empty($id_token)) {
                echo json_encode([
                    "status" => "error",
                    "message" => "ID token is missing.",
                ]);
                exit();
            }

            $client = new Google_Client(['client_id' => '286853462386-49vh36onqvjfej8l121pu3h90uh3pk3v.apps.googleusercontent.com']);
            $payload = $client->verifyIdToken($id_token);

            if ($payload) {
                $google_id = $payload['sub'];
                $first_name = $payload['given_name'];
                $last_name = $payload['family_name'];
                $email = $payload['email'];

                $db = new DB();
                $existingUser = $db->getRows('users', ['email' => $email]);

                if ($existingUser) {
                    echo json_encode([
                        "status" => "success",
                        "message" => "User already exists. Redirecting...",
                        "redirectUrl" => "../User/Login.php",
                    ]);
                    exit();
                } else {
                    $data = [
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'role' => 'user',
                        'method' => 'google'
                    ];

                    if ($db->insert('users', $data)) {
                        echo json_encode([
                            "status" => "success",
                            "message" => "Sign-up successful. Redirecting...",
                            "redirectUrl" => "../User/Login.php",
                        ]);
                        exit();
                    } else {
                        echo json_encode([
                            "status" => "error",
                            "message" => "An error occurred while creating the account.",
                        ]);
                        exit();
                    }
                }
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Invalid ID token.",
                ]);
                exit();
            }
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => "An error occurred: " . $e->getMessage(),
            ]);
            exit();
        }
    }

    echo json_encode([
        "status" => "error",
        "message" => "Invalid request.",
    ]);
    exit();
}

?>

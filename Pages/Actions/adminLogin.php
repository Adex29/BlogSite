<?php
require_once 'vendor/autoload.php';

if (!isset($_SESSION)) {
    session_start();
}

include_once("../database/DB.class.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Authenticate') {
    try {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            echo json_encode(["status" => "error", "message" => "Email and password cannot be empty."]);
            exit();
        }

        $db = new DB();
        $user = $db->getRows('users', ['email' => $email]);

        if ($user) {
            $hashedPassword = $user[0]['password'];
            $userRole = $user[0]['role'];

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['userId'] = $user[0]['id'];
                $_SESSION['role'] = $userRole;
                $_SESSION['name'] = $user[0]['first_name'] . ' ' . $user[0]['last_name'];

                $redirectUrl = ($userRole === 'admin') ? "../Admin/MainDashboard.php" : "../User/homePage.php";

                echo json_encode(["status" => "success", "message" => "Login successful.", "redirectUrl" => $redirectUrl]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid email or password."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "User not found."]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "An error occurred: " . $e->getMessage()]);
    }
    exit();
}


use Google\Client;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idToken'])) {
    try {
        $idToken = $_POST['idToken'] ?? '';
        $client = new Client(['client_id' => '286853462386-49vh36onqvjfej8l121pu3h90uh3pk3v.apps.googleusercontent.com']);
        $payload = $client->verifyIdToken($idToken);

        if ($payload) {
            $email = $payload['email'];
            $name = $payload['name'];

            $db = new DB();
            $user = $db->getRows('users', ['email' => $email]);

            if ($user) {
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['userId'] = $user[0]['id'];
                $_SESSION['role'] = $user[0]['role'];
                $_SESSION['name'] = $user[0]['first_name'] . ' ' . $user[0]['last_name'];

                $redirectUrl = ($user[0]['role'] === 'admin') ? "../Admin/MainDashboard.php" : "../User/homePage.php";

                echo json_encode([
                    "status" => "success",
                    "message" => "Login successful.",
                    "redirectUrl" => $redirectUrl
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Google account not linked to any user."
                ]);
            }
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid Google ID token."
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => "An error occurred: " . $e->getMessage()
        ]);
    }
    exit();
}


if (isset($_POST['action']) && $_POST['action'] === 'FacebookSignIn') {
    try {
        $access_token = $_POST['access_token'] ?? '';

        if (empty($access_token)) {
            echo json_encode([
                "status" => "error",
                "message" => "Access token is missing.",
            ]);
            exit();
        }

        // Verify the Facebook access token
        $url = "https://graph.facebook.com/me?access_token=" . $access_token . "&fields=id,first_name,last_name,email";
        $response = file_get_contents($url);
        $facebook_data = json_decode($response, true);

        if (isset($facebook_data['error'])) {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid Facebook access token.",
            ]);
            exit();
        }

        // Extract user data
        $email = $facebook_data['email'] ?? null;
        $first_name = $facebook_data['first_name'] ?? '';
        $last_name = $facebook_data['last_name'] ?? '';
        $facebook_id = $facebook_data['id'];

        if (!$email) {
            echo json_encode([
                "status" => "error",
                "message" => "Facebook account does not have an email associated.",
            ]);
            exit();
        }

        $db = new DB();
        $user = $db->getRows('users', ['email' => $email]);

        if ($user) {
 
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['userId'] = $user[0]['id'];
            $_SESSION['role'] = $user[0]['role'];
            $_SESSION['name'] = $user[0]['first_name'] . ' ' . $user[0]['last_name'];

            $redirectUrl = ($user[0]['role'] === 'admin') ? "../Admin/MainDashboard.php" : "../User/homePage.php";

            echo json_encode([
                "status" => "success",
                "message" => "Login successful.",
                "redirectUrl" => $redirectUrl
            ]);
        } else {
           echo json_encode([
               "status" => "error",
               "message" => "User not found.",
           ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => "An error occurred: " . $e->getMessage()
        ]);
    }
    exit();
}


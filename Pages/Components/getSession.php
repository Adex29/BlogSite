<?php
session_start();

header('Content-Type: application/json');

if (isset($_POST['action']) && $_POST['action'] === 'getSession') {
    if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
        echo json_encode([
            'isLoggedIn' => true,
            'status' => 'success'
        ]);
    } else {
        echo json_encode([
            'isLoggedIn' => false,
            'status' => 'error'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid action.'
    ]);
}
?>

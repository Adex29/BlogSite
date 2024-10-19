<?php
if(!isset($_SESSION)){
    session_start();
  }

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    header("location: ../Admin/Login.php");
    exit();
}

if (isset($_POST['action']) && $_POST['action'] === 'Logout') {
    session_destroy();
    $_SESSION['loggedIn'] = false;
    echo json_encode([
        'status' => 'success',
        'redirectUrl' => '../Admin/Login.php'
    ]);
    exit();
}

?>

<?php
session_start();


if(!isset($_SESSION['loggedIn'])){
    header("location: ../Admin/Login.php");
}

if(isset($_POST['logout'])){
    session_destroy();
    $_SESSION['loggedIn'] = false;
    header("location: ../Admin/Login.php");
}
?>
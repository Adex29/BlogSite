<?php
if(!isset($_SESSION)){
    session_start();
  }

header("location: ../Admin/Login.php");
session_destroy();

?>

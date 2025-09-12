<?php 
    require '../layouts/main.php';
    require '../database.php'; 
    include '../layouts/navbarAdmin.php';
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: ../auth/login.php");
        exit;
    }
?>
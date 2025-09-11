<?php require '../layouts/main.php';
    include '../layouts/navbarClient.php';
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: ../auth/login.php");
        exit;
    }
?>

    gallery

<?php include '../layouts/footer.php';?>


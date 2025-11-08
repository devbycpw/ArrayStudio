<?php
    require '../database.php';
    require '../layouts/main.php';

    $id_booking = $_GET["id_booking"];
    $data = "SELECT * FROM bookings WHERE id_booking = '$id_booking'";
    
    echo $data["id_user"];
?>

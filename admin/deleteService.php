<?php
    require '../database.php';
    $id = $_GET["id_service"];
    if (hapus($id)>0) {
        echo "<script>alert('data berhasil dihapus!');document.location.href='services.php';</script>";
    }else {
        echo "<script>alert('data gagal dihapus!');document.location.href='services.php';</script>";
    }
?>
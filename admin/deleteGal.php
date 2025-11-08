<?php
    require '../database.php';
    $id = $_GET["id_gallery"];
    if (hapus_Gall($id)>0) {
        echo "<script>alert('data berhasil dihapus!');document.location.href='gallery.php';</script>";
    }else {
        echo "<script>alert('data gagal dihapus!');document.location.href='gallery.php';</script>";
    }
?>
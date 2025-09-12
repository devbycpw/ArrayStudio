<?php 
require '../layouts/main.php';
require '../database.php';

if (isset($_POST["submit"])) {
    if (tambah($_POST) > 0) {
        echo "<script>alert('Data berhasil ditambahkan!');document.location.href='services.php';</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan!');document.location.href='services.php';</script>";
    }
}
?>
    <h1 style="color:#ff9900;">Tambah Service</h1>

    <form action="" method="POST" style="max-width:400px;">
        <label for="name" style="color:#e0e0e0;">Nama Service</label>
        <input type="text" name="name" id="name" required class="form-control">

        <label for="description" style="color:#e0e0e0;">Description</label>
        <textarea name="description" id="description" required class="form-control"></textarea>

        <label for="price" style="color:#e0e0e0;">Harga</label>
        <input type="number" name="price" id="price" required class="form-control" min="0">

        <button type="submit" name="submit" class="btn btn-warning mt-3">Tambah Data!</button>
    </form>
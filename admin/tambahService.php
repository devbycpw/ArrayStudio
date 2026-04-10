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

<div class="container py-5">
    <div class="card shadow-sm service-card mx-auto border-0" style="max-width: 600px;">
        <div class="card-body">
            <h2 class="mb-4 text-center fw-bold text-dark">Tambah Service</h2>

            <form action="" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Service</label>
                    <input type="text" name="name" id="name" required class="form-control" placeholder="Masukkan nama service">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" required class="form-control" rows="3" placeholder="Masukkan deskripsi service"></textarea>
                </div>

                <div class="mb-4">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" name="price" id="price" required class="form-control" min="0" placeholder="Masukkan harga">
                </div>

                <button type="submit" name="submit" class="btn btn-gradient w-100">
                    + Tambah Data
                </button>
            </form>
        </div>
    </div>
</div>

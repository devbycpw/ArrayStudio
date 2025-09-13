<?php 
require '../database.php';
require '../layouts/main.php';

// cek data yang dilempar lewat URL
$id_service = $_GET['id_service'];
$data_service = query("SELECT * FROM services WHERE id_service=$id_service")[0]; 

// cek user klik submit
if (isset($_POST["submit"])) {
    if (edit($_POST) > 0) {
        echo "<script>alert('Data berhasil diedit!');document.location.href='services.php';</script>";
    } else {
        echo "<script>alert('Data gagal diedit!');document.location.href='services.php';</script>";
    }
}
?>

<div class="container py-5">
    <div class="card shadow-lg mx-auto" style="max-width: 600px; background-color:#1a1a1a; border:1px solid #333;">
        <div class="card-body">
            <h2 class="mb-4 text-center" style="color:#ff9900;">Edit Service</h2>

            <form action="" method="POST">
                <input type="hidden" name="id_service" value="<?= $data_service["id_service"] ?>">

                <div class="mb-3">
                    <label for="name" class="form-label" style="color:#e0e0e0;">Nama Service</label>
                    <input type="text" name="name" id="name" 
                           value="<?= htmlspecialchars($data_service["name"]) ?>" 
                           class="form-control bg-dark text-light" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label" style="color:#e0e0e0;">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" 
                              class="form-control bg-dark text-light" required><?= htmlspecialchars($data_service["description"]) ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="price" class="form-label" style="color:#e0e0e0;">Harga</label>
                    <input type="number" name="price" id="price" 
                           value="<?= htmlspecialchars($data_service["price"]) ?>" 
                           class="form-control bg-dark text-light" required min="0">
                </div>

                <button type="submit" name="submit" 
                        class="btn w-100" style="background-color:#ff9900; color:#1a1a1a; font-weight:bold;">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>

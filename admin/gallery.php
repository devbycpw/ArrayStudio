<?php 
require '../layouts/main.php';
require '../database.php'; 
include '../layouts/navbarAdmin.php';
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../auth/login.php");
    exit;
}

$gallery = query("SELECT * FROM gallery");
$i = 1;
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-warning">📷 Management Gallery</h2>
        <a href="tambahGal.php" class="btn btn-warning fw-bold">+ Add Picture</a>
    </div>

    <div class="card shadow-lg" style="background-color:#1a1a1a; border:1px solid #333;">
        <div class="card-body">
            <table class="table table-dark table-hover align-middle text-center">
                <thead>
                    <tr class="table-active">
                        <th>No.</th>
                        <th>Picture</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($gallery)) : ?>
                        <?php foreach ($gallery as $row): ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td>
                                    <img src="../img/<?= htmlspecialchars($row["image_url"]); ?>" 
                                         alt="Gallery Image" 
                                         class="img-thumbnail" 
                                         style="max-width: 120px; border-radius: 8px;">
                                </td>
                                <td>
                                    <a href="deleteGal.php?id_gallery=<?= $row['id_gallery']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Yakin ingin menghapus gambar ini?')">
                                       🗑 Delete
                                    </a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3" class="text-muted">Belum ada gambar di gallery.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

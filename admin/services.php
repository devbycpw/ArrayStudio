<?php 
    require '../layouts/main.php';
    require '../database.php'; 
    include '../layouts/navbarAdmin.php';
    session_start();
    if(!isset($_SESSION["login"])){
        if ($_SESSION["role"] != 'admin') {
            header("Location: ../auth/login.php");
            exit;
        }
    }
    $data_services = query('SELECT * FROM services');
?>
<div class="container-fluid" style="background:var(--main-bg); min-height: 100vh; padding: 2rem;">

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-dark fw-bold">Manage Services</h2>
    <a href="tambahService.php" class="btn btn-primary" style="background-color:var(--primary-gold-dark);border:none;">
      + Add Service
    </a>
  </div>

  <div class="card shadow-sm service-card border-0">
    <div class="card-body">
      <table class="table table-hover align-middle">
        <thead>
          <tr class="text-dark fw-bold">
            <th scope="col">#</th>
            <th scope="col">Service Name</th>
            <th scope="col">Description</th>
            <th scope="col">Price</th>
            <th scope="col" class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; foreach ($data_services as $row): ?>
          <tr>
            <td><?= $i; ?></td>
            <td><?= htmlspecialchars($row['name']); ?></td>
            <td><?= htmlspecialchars($row['description']); ?></td>
            <td>Rp <?= number_format($row['price'],0,',','.'); ?></td>
            <td class="text-center">
              <a href="editService.php?id_service=<?= $row['id_service']; ?>" 
                 class="btn btn-sm btn-warning me-2">
                ✏️ Edit
              </a>
              <a href="deleteService.php?id_service=<?= $row['id_service']; ?>" 
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('Yakin ingin menghapus?')">
                🗑️ Delete
              </a>
            </td>
          </tr>
          <?php $i++; endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

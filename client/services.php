<?php 
    require '../layouts/main.php';
    require '../database.php'; 
    include '../layouts/navbarClient.php';
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: ../auth/login.php");
        exit;
    }

    $sql = "SELECT * FROM services";
    $result = $conn->query($sql);
?>

<style>
  body {
    background-color: #0d0d0d;
    color: #e0e0e0;
  }
  .card-custom {
    background-color: #1a1a1a;
    border: 1px solid #333;
    border-radius: 12px;
    transition: transform 0.2s ease-in-out;
  }
  .card-custom:hover {
    transform: translateY(-4px);
    border-color: #ff9900;
    box-shadow: 0 4px 12px rgba(255, 153, 0, 0.2);
  }
  .btn-primary-custom {
    background-color: #ff9900;
    border: none;
    color: #0d0d0d;
    font-weight: 600;
  }
  .btn-primary-custom:hover {
    background-color: #ffd580;
    color: #0d0d0d;
  }
  .price {
    color: #66ccff;
    font-weight: bold;
  }
</style>

<div class="container py-5">
  <h1 class="text-center text-warning fw-bold mb-4">Our Services</h1>

  <?php if ($result->num_rows > 0) : ?>
    <div class="row g-4">
      <?php while($row = $result->fetch_assoc()) : ?>
        <div class="col-md-4">
          <div class="card card-custom h-100 p-3">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title text-warning"><?= htmlspecialchars($row['name']) ?></h5>
              <p class="card-text flex-grow-1"><?= htmlspecialchars($row['description']) ?></p>
              <p class="card-text price">Rp <?= number_format($row['price'], 0, ',', '.') ?></p>

              <form action="booking.php" method="get">
                <input type="hidden" name="id_service" value="<?= $row['id_service'] ?>">
                <button type="submit" class="btn btn-primary-custom w-100">Book Now</button>
              </form>

              <p class="card-text mt-2">
                <small class="text-secondary"><?= timeAgo($row['created_at']) ?></small>
              </p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else : ?>
    <p class="text-center text-muted">No services available at the moment.</p>
  <?php endif; ?>
</div>

<?php include '../layouts/footer.php'; ?>

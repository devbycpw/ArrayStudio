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


    <link rel="stylesheet" href="../static/services.css">


<div class="container py-5">
  <h1 class="text-center text-dark fw-bold mb-4">Our Services</h1>

  <?php if ($result->num_rows > 0) : ?>
    <div class="row g-4">
      <?php while($row = $result->fetch_assoc()) : ?>
        <div class="col-md-4">
          <div class="card service-card shadow-sm border-0 h-100 p-3">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title text-dark fw-bold"><?= htmlspecialchars($row['name']) ?></h5>
              <p class="card-text flex-grow-1"><?= htmlspecialchars($row['description']) ?></p>
              <p class="card-text price">Rp <?= number_format($row['price'], 0, ',', '.') ?></p>

              <form action="booking.php" method="get">
                <input type="hidden" name="id_service" value="<?= $row['id_service'] ?>">
                <button type="submit" class="btn btn-gradient w-100">Book Now</button>
              </form>

              <p class="card-text mt-2">
                <small class="text-secondary"><?= isset($row['created_at']) ? timeAgo($row['created_at']) : 'New' ?></small>
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

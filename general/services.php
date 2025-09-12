<?php 
require '../layouts/main.php';
require '../database.php'; 
include '../layouts/navbarGeneral.php';

// Ambil data service
$sql = "SELECT * FROM services";
$result = $conn->query($sql);

if (isset($_POST["submit"])) {

    echo "<script>
        alert('Silahkan login terlebih dahulu');
        document.location.href='../auth/login.php';
    </script>";
}
?>

    <link rel="stylesheet" href="../static/services.css">


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

                            <form method="post">
                                <button type="submit" name="submit" class='btn btn-primary-custom w-100'>Book Now</button>
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

<?php 
require '../layouts/main.php';
require '../database.php'; 
include '../layouts/navbarGeneral.php';

// Ambil data service
$sql = "SELECT * FROM services";
$result = $conn->query($sql);

// Cek jika tombol book now ditekan
if (isset($_POST["submit"])) {

    // Redirect ke login 
    echo "<script>
        alert('Silahkan login terlebih dahulu');
        document.location.href='../auth/login.php';
    </script>";
}
?>

<h1>Daftar Services</h1>

<?php if ($result->num_rows > 0) : ?>
    <?php while($row = $result->fetch_assoc()) : ?>
        <div class='card mb-3'>
            <div class='card-body'>
                <h5 class='card-title'><?= htmlspecialchars($row['name']) ?></h5>
                <p class='card-text'><?= htmlspecialchars($row['description']) ?></p>
                <p class='card-text'>Rp <?= number_format($row['price'], 0, ',', '.') ?></p>
                
                <!-- Form diisi dengan ID service -->
                <input type='hidden' name='id_service' value='<?= $row['id_service'] ?>'>
                <form method="post">
                    <button type="submit" name="submit" class='btn btn-dark'>Book Now</button>
                </form>

                <p class='card-text'>
                    <small class='text-body-secondary'><?= timeAgo($row['created_at']) ?></small>
                </p>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>

<?php include '../layouts/footer.php'; ?>

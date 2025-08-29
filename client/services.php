<?php require '../layouts/main.php';
    require '../database.php'; 
    include '../layouts/navbarClient.php';
    $sql = "SELECT * FROM services";
    $result = $conn->query($sql);
?>
    <h1>Daftar Services</h1>
        <?php if ($result->num_rows > 0) : ?>
            <?php while($row = $result->fetch_assoc()) :?>
                <div class='card mb-3'>
                    <div class='card-body'>
                        <h5 class='card-title'><?= $row['name']?></h5>
                        <p class='card-text'><?= $row['description']?></p>
                        <p class='card-text'>Rp <?= number_format($row['price'],0,',','.')?></p>
                        <form action='booking.php' method='get'>
                            <input type='hidden' name='id_service' value='<?= $row['id_service']?>'>
                            <button class='btn btn-dark'>book now</button>
                        </form>
                        <p class='card-text'><small class='text-body-secondary'><?= timeAgo($row['created_at'])?></small></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    <?php include '../layouts/footer.php';?>

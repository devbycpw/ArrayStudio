<?php 
    require '../layouts/main.php';
    require '../database.php'; 
    include '../layouts/navbarGeneral.php';
    $gallery = query("SELECT * FROM gallery");
    $i = 1;
?>
    <div class="container my-4">
        <div class="row">
            <?php foreach ($gallery as $row) : ?>
            <div class="col-md-3 mb-4"> <!-- 12 / 3 = 4 kolom -->
                <div class="card h-100">
                <img src="../img/<?= $row["image_url"]; ?>" class="card-img-top" alt="...">
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    
    
    <?php include '../layouts/footer.php';?>


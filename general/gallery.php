<?php 
    require '../layouts/main.php';
    require '../database.php'; 
    include '../layouts/navbarGeneral.php';
    $gallery = query("SELECT * FROM gallery");
    $i = 1;
?>
<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 15px rgba(255, 153, 0, 0.5);
    }

    .card:hover img {
        transform: scale(1.05);
    }

    body {
        background-color: #0d0d0d;
        color: #e0e0e0;
    }
</style>

<div class="container my-5">
    <h1 class="text-center mb-5" style="color: #ff9900; font-weight: 700;">Our Gallery</h1>
    <div class="row">
        <?php foreach ($gallery as $row) : ?>
        <div class="col-6 col-md-4 col-lg-3 mb-4"> 
            <div class="card h-100 border-0 shadow-sm" 
                 style="background-color: #1a1a1a; border: 1px solid #333; transition: transform 0.3s, box-shadow 0.3s;">
                <div class="overflow-hidden rounded">
                    <img src="../img/<?= $row["image_url"]; ?>" 
                         class="card-img-top img-fluid" 
                         alt="Gallery Image" 
                         style="object-fit: cover; height: 200px; transition: transform 0.3s;">
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>



<?php include '../layouts/footer.php';?>

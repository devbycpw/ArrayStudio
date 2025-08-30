<?php 
    require '../database.php';
    require '../layouts/main.php';
    include '../layouts/navbarClient.php';

    $service = query("SELECT * FROM services");
    $id_service = $_GET["id_service"] ?? null;
    
    if (isset($_POST['submit'])) {
        if (insbook($_POST)) {
            echo "<script>alert('Booking berhasil, sedang menunggu konfirmasi admin.');document.location.href='index.php';</script>";
        }else {
            echo "<script>alert('Booking gagal, sedang menunggu konfirmasi admin.');</script>";
        }
    }
?>  
    <form action="" method="post">
        <label for="username">Nama Lengkap: </label>
        <input type="text" id="username" name="username">

        <label for="email">Email: </label>
        <input type="email" name="email" id="email  ">

        <label for="">service : </label>
        <select name="service" id="service">
            <?php foreach ($service as $row) : ?>
                <option value="<?=$row['id_service']?>"
                    <?= ($id_service==$row['id_service']) ? 'selected' : ''?>>
                    <?=$row['name'];?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="schedule">schedule</label>
        <input type="date" id="schedule" name="schedule">
        <button type="submit" name="submit">Book Now</button>
    </form>
<?php
    include '../layouts/footer.php';
?>
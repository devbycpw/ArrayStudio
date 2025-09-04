<?php 
    session_start();
    require '../database.php';
    require '../layouts/main.php';
    include '../layouts/navbarClient.php';

    $id_service = isset($_GET['id_service']) ? $_GET['id_service'] : null;
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $services = query("SELECT * FROM services");

    
    if (isset($_POST['submit'])) {
        if (insbook($_POST)) {
            echo "<script>alert('Booking berhasil, sedang menunggu konfirmasi admin.');document.location.href='index.php';</script>";
        }else {
            echo "<script>alert('Booking gagal, sedang menunggu konfirmasi admin.');</script>";
        }
    }
?>  
    
    <label for="username">Nama Lengkap: </label>
    <input type="text" id="username" name="username" value="<?= $username ?>" readonly>

    <label for="email">Email: </label>
    <input type="email" name="email" id="email" value="<?= $email ?>" readonly>
    
    <form action="" method="post">
        <label for="">service : </label>
        <select name="service" id="service" required>
            <option value="">-- pilih kategori --</option>
            <?php foreach ($services as $row) : ?>
                <option value="<?=$row['id_service']?>"
                    <?= ($id_service==$row['id_service']) ? 'selected' : ''?>>
                    <?=$row['name'];?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="schedule">schedule</label>
        <input type="date" id="schedule" name="schedule" min="<?= date('Y-m-d') ?>" required>
        <button type="submit" name="submit">Book Now</button>
    </form>
<?php
    include '../layouts/footer.php';
?>
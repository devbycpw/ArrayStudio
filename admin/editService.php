<?php require '../database.php';
require '../layouts/main.php';

    // cek data yang dilempar lewat url
    $id_service = $_GET['id_service'];
    $data_service = query("SELECT * FROM services WHERE id_service=$id_service")[0]; 
    
    // cek user click submit
    if (isset($_POST["submit"])) {
        if (edit($_POST) >0) {
            echo "<script>alert('data berhasil diedit!');document.location.href='services.php';</script>";
        }else {
            echo "<script>alert('data gagal diedit!');document.location.href='services.php';</script>";
        }
    }

?>

<h1>Edit Service</h1>
<form action="" method="POST">
    <input type="hidden" name="id_service" value="<?= $data_service["id_service"] ?>">
    <label for="name"></label>
    <input type="text" name="name" id="name" value="<?= $data_service["name"]; ?>">
    <label for="description"></label>
    <input type="text" name="description" id="description" value="<?= $data_service["description"]; ?>">
    <label for="price"></label>
    <input type="text" name="price" id="price" value="<?= $data_service["price"]; ?>">
    <button type="submit" name="submit">Edit data!</button>
</form>
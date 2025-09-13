<?php 
    require '../layouts/main.php';
    require '../database.php'; 
    include '../layouts/navbarAdmin.php';
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: ../auth/login.php");
        exit;
    }
    $gallery = query("SELECT * FROM gallery");
    $i = 1;
?>

<h1>Management Galery</h1>


<a href="tambahGal.php">+ Add Picture</a>
<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Picture</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach( $gallery as $row): ?>
        <tr>
            <td><?= $i; ?></td>
            <td> <img src="../img/<?= $row["image_url"]; ?>" alt="" width="100px"></td>
            <td> <a href="editGal.php?id_gallery=<?= $row['id_gallery'];?>">Edit</a> | <a href="deleteGal.php?id_gallery=<?= $row['id_gallery']; ?>">Delete</a></td>
        </tr>
        <?php $i++; ?>
        <?php endforeach?>
</tbody>
</table>


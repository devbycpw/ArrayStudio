<?php 
    require '../layouts/main.php';
    require '../database.php'; 
    include '../layouts/navbarAdmin.php';
    session_start();
    if(!isset($_SESSION["login"])){
        if ($_SESSION["role"] != 'admin') {
            header("Location: ../auth/login.php");
            exit;
        }
    }
    $data_services = query('SELECT * FROM services');
?>

<table>
        <tr>
            <th>no.</th>
            <th>Name Services</th>
            <th>Description</th>
            <th>Price</th>
            <th>Action</th>
        </tr>

        <?php $i = 1;?>
        <?php foreach ($data_services as $row) : ?>    
            <tr>
                <td><?=$i;?></td>
                <td><?=htmlspecialchars($row['name'])?></td>
                <td><?=htmlspecialchars($row['description'])?></td>
                <td><?=number_format($row["price"],0,',','.')?></td>
                <td><a href="editService.php?id_service=<?= $row["id_service"]; ?>">Edit</a> | <a href="deleteService.php?id_service=<?= $row["id_service"];?>" onclick="return confirm('yakin?')">Delete</a></td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    </table>
    <a href="tambahService.php">Tambah Data</a>
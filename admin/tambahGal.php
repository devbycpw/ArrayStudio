<?php
    require '../database.php';
    if (isset($_POST["submit"])) {
        if (tambahFile($_POST) > 0) {
            echo "<script>alert('picture has upload'); document.location.href='gallery.php'</script>";
        }else{
            echo "<script>alert('data gagal ditambahkan!');document.location.href='gallery.php';</script>";
        }
    }
?>

    <h1>+ Add Picture</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="category">Category: </label>
        <input type="text" name="category" id="category">
        <label for="picture">Picture: </label>
        <input type="file" name="picture" id="picture">
        <button type="submit" name="submit">Add</button>
    </form>

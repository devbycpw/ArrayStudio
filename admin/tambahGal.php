<?php
    require '../database.php';
    if (isset($_POST["submit"])) {
        if (tambahFile($_POST) > 0) {
            echo "<script>alert('picture has upload'); document.location.href='gallery.php'</script>";
        }
    }
?>

    <h1>+ Add Picture</h1>
    <form action="" method="POST">
        <label for="picture">Picture</label>
        <input file="text" name="picture" id="picture">
        <button type="submit" name="submit">Add</button>
    </form>

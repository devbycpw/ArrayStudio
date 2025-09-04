<?php require '../layouts/main.php';
    require '../database.php';
    if (isset($_POST["register"])) {
        if (register($_POST) > 0) {
            echo "<script>alert('user baru berhasil ditambahkan');
            window.location.href = 'login.php';
            </script>";
        }
    }
?>

    <h1>Form Register</h1>

    <form action="" method="post">
        <label for="username">Username : </label>
        <input type="text" name="username" id="username">
        <label for="email">Email : </label>
        <input type="email" name="email" id="email">
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
        <label for="konfirmasi">Konfirmasi Password : </label>
        <input type="password" name="konfirmasi" id="konfirmasi">
        <button name="register" id="register">registrasi</button>
    </form>

    <p>Sudah punya akun? <a href="login.php">Masuk sekarang</a></p>


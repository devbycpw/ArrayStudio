<?php 
    session_start();
    require '../layouts/main.php';
    require '../database.php';
?>

<h1>Halaman Login</h1>
    <form action="" method="post">
        
        <label for="role"></label>
            <select name="role" id="role">
                <option value="client">Client</option>
                <option value="admin">Admin</option>
            </select>
        <label for="username">Username : </label>
        <input type="text" name="username" id="username">
        <label for="email">Email : </label>
        <input type="text" name="email" id="email">
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
        <button type="login" name="login">Login</button>
    </form>
    <a href="register.php">belum punya akun?</a>

<?php 
    session_start();
    require '../layouts/main.php';
    require '../database.php';

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $result = mysqli_query($conn,"SELECT * FROM users WHERE name = '$username' AND email = '$email'");
        
        if (mysqli_num_rows($result)===1) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($password,$row["password"])) {
                $_SESSION['login'] = true;
                $_SESSION['id_user'] = $row['id_user'];
                $_SESSION['username'] = $row['name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                
                if ($row['role'] === 'client') {
                    header("location: ../client/home.php");
                }else {
                    header("location: ../admin/dashboard.php");
                    
                }
                exit;
            } else {
                echo "Password salah";
            }
        }else {
            echo "User tidak ditemukan!";
        }
    }
?>

<h1>Form Login</h1>
    <form action="" method="post">
        <label for="username">Username : </label>
        <input type="text" name="username" id="username">
        <label for="email">Email : </label>
        <input type="text" name="email" id="email">
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
        <button type="login" name="login">Login</button>
    </form>
    <p>Belum punya akun? Ayo <a href="register.php">daftar</a></p>

<?php 
    session_start();
    require '../layouts/main.php';
    require '../database.php';

    $error = "";

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $result = mysqli_query($conn,"SELECT * FROM users WHERE name = '$username' AND email = '$email'");
        
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($password, $row["password"])) {
                $_SESSION['login'] = true;
                $_SESSION['id_user'] = $row['id_user'];
                $_SESSION['username'] = $row['name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                
                if ($row['role'] === 'client') {
                    header("location: ../client/home.php");
                } else {
                    header("location: ../admin/dashboard.php");
                }
                exit;
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "User not found!";
        }
    }
?>

<div class="d-flex justify-content-center align-items-center vh-100" style="background-color: #0d0d0d;">
    <div class="card shadow-lg p-4" style="background-color: #1a1a1a; border: 1px solid #333; width: 100%; max-width: 400px; border-radius: 12px;">
        <h2 class="text-center mb-4" style="color: #ff9900; font-weight: 700;">Login</h2>

        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger text-center py-2" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label text-light">Username</label>
                <input type="text" class="form-control bg-dark text-light border-0" name="username" id="username" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label text-light">Email</label>
                <input type="email" class="form-control bg-dark text-light border-0" name="email" id="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-light">Password</label>
                <input type="password" class="form-control bg-dark text-light border-0" name="password" id="password" required>
            </div>

            <button type="submit" name="login" class="btn w-100" 
                style="background-color: #ff9900; color: #0d0d0d; font-weight: 600; border-radius: 8px;">
                Login
            </button>
        </form>

        <p class="text-center mt-3" style="color: #e0e0e0;">
            Don't have an account? <a href="register.php" style="color: #ffd580;">Register</a>
        </p>
    </div>
</div>

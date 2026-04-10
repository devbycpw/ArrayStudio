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

<div class="d-flex justify-content-center align-items-center vh-100" style="background-color: var(--main-bg);">
    <div class="card shadow-sm service-card border-0 p-4" style="width: 100%; max-width: 400px; border-radius: 12px;">
        <h2 class="text-center mb-4 text-dark fw-bold">Login</h2>

        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger text-center py-2" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label text-dark">Username</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label text-dark">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-dark">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>

            <button type="submit" name="login" class="btn btn-gradient w-100" style="border-radius: 8px;">
                Login
            </button>
        </form>

        <p class="text-center mt-3 text-muted">
            Don't have an account? <a href="register.php" class="text-dark fw-bold">Register</a>
        </p>
    </div>
</div>

<?php 
    require '../layouts/main.php';
    require '../database.php';

    $error = "";

    if (isset($_POST["register"])) {
        if (register($_POST) > 0) {
            echo "<script>alert('User successfully registered!');window.location.href = 'login.php';</script>";
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
?>

<div class="d-flex justify-content-center align-items-center vh-100" style="background-color: var(--main-bg);">
    <div class="card shadow-sm service-card border-0 p-4" style="width: 100%; max-width: 450px; border-radius: 12px;">
        <h2 class="text-center mb-4 fw-bold text-dark">Register</h2>

        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger text-center py-2"><?= $error ?></div>
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

            <div class="mb-3">
                <label for="konfirmasi" class="form-label text-dark">Confirm Password</label>
                <input type="password" class="form-control" name="konfirmasi" id="konfirmasi" required>
            </div>

            <button type="submit" name="register" class="btn btn-gradient w-100" style="border-radius: 8px;">
                Register
            </button>
        </form>

        <p class="text-center mt-3 text-muted">
            Already have an account? <a href="login.php" class="text-dark fw-bold">Login here</a>
        </p>
    </div>
</div>

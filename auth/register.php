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

<div class="d-flex justify-content-center align-items-center vh-100" style="background-color: #0d0d0d;">
    <div class="card shadow-lg p-4" style="background-color: #1a1a1a; border: 1px solid #333; width: 100%; max-width: 450px; border-radius: 12px;">
        <h2 class="text-center mb-4" style="color: #ff9900; font-weight: 700;">Register</h2>

        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger text-center py-2"><?= $error ?></div>
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

            <div class="mb-3">
                <label for="konfirmasi" class="form-label text-light">Confirm Password</label>
                <input type="password" class="form-control bg-dark text-light border-0" name="konfirmasi" id="konfirmasi" required>
            </div>

            <button type="submit" name="register" class="btn w-100"
                style="background-color: #ff9900; color: #0d0d0d; font-weight: 600; border-radius: 8px;">
                Register
            </button>
        </form>

        <p class="text-center mt-3" style="color: #e0e0e0;">
            Already have an account? <a href="login.php" style="color: #ffd580;">Login here</a>
        </p>
    </div>
</div>

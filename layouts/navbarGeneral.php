<nav class="navbar navbar-expand-lg">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand fw-bold" href="../general/home.php">
      <i class="bi bi-camera-reels-fill text-warning me-2"></i>
      Array Studio
    </a>
    
    <!-- Toggler -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" 
      data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- Nav Links -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="../general/home.php">
            <i class="bi bi-house-door me-1"></i>Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../general/services.php">
            <i class="bi bi-list-ul me-1"></i>Packages
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../general/gallery.php">
            <i class="bi bi-images me-1"></i>Portfolio
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../client/booking.php">
            <i class="bi bi-calendar-check me-1"></i>Book Now
          </a>
        </li>
      </ul>
      
      <!-- CTA Buttons -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="btn btn-outline-dark btn-sm px-3 me-2" href="../auth/login.php">
            <i class="bi bi-box-arrow-in-right"></i> Login
          </a>
        </li>
        <li class="nav-item">
          <a class="btn-gradient btn-sm px-4" href="../auth/register.php">
            <i class="bi bi-person-plus"></i> Sign Up
          </a>
        </li>
        <?php if (isset($_SESSION['login'])): ?>
        <li class="nav-item dropdown ms-2">
          <a class="nav-link dropdown-toggle text-dark fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
            <?= $_SESSION['username'] ?? 'User' ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
            <li><a class="dropdown-item" href="../client/home.php">Dashboard</a></li>
            <li><a class="dropdown-item" href="../auth/logout.php">Logout</a></li>
          </ul>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

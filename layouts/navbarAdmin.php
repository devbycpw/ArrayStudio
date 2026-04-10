<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="dashboard.php">
      <i class="bi bi-camera-reels-fill text-warning me-2"></i>Array Studio
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
      data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" 
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="dashboard.php">Home</a>
        <a class="nav-link" href="services.php">Services</a>
        <a class="nav-link" href="booking.php">Booking</a>
        <a class="nav-link" href="gallery.php">Gallery</a>
      </div>
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="../auth/logout.php">logout <i class="bi bi-box-arrow-right"></i></a>
      </div>
    </div>
  </div>
</nav>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    let navLinks = document.querySelectorAll(".navbar-nav .nav-link");
    let currentPath = window.location.pathname.split("/").pop(); 

    navLinks.forEach(link => {
      let linkPath = link.getAttribute("href").split("/").pop();
      if (linkPath === currentPath) {
        navLinks.forEach(l => l.classList.remove("active")); 
        link.classList.add("active");
      }
    });
  });
</script>

<nav class="navbar navbar-expand-lg navbar-dark bgnav">
  <div class="container">
    <a class="navbar-brand" href="index.html">Array Studio</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
      data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" 
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
        <a class="nav-link" href="../general/services.php">Services</a>
        <a class="nav-link" href="../general/gallery.php">Gallery</a>
      </div>
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="../auth/login.php">Login</a>
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

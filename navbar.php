<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="#">Array Studio</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        <a class="nav-link" href="services.php">services</a>
        <a class="nav-link" href="booking.php">booking</a>
        <a class="nav-link" href="gallery.php">gallery</a>
      </div>
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="#login">login</a>
      </div>
    </div>
  </div>
</nav>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    let navLinks = document.querySelectorAll(".navbar-nav .nav-link");
    let currentHash = window.location.hash;

    navLinks.forEach(link => {
      if (link.getAttribute("href") === currentHash) {
        navLinks.forEach(l => l.classList.remove("active")); 
        link.classList.add("active");
      }
    });
  });
</script>
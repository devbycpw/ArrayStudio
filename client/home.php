<?php 
  require '../layouts/main.php';
  require '../database.php'; 
  include '../layouts/navbarClient.php';
  session_start();
  if(!isset($_SESSION["login"])){
    header("Location: ../auth/login.php");
    exit;
  }
?>

<style>
  body {
    /* Uses global main-bg and text-primary */
  }
  .hero-section {
    position: relative;
    text-align: center;
    color: #fff;
  }
  .hero-section img {
    width: 100%;
    height: 60vh;
    object-fit: cover;
    opacity: 0.8;
  }
  .hero-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
  .btn-primary-custom {
    background: linear-gradient(45deg, var(--primary-gold), var(--primary-gold-dark));
    border: none;
    color: #fff !important;
    font-weight: bold;
    transition: all 0.3s ease;
  }
  .btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-glow);
  }
  .card-custom {
    background-color: var(--card-bg);
    border: 1px solid rgba(0,0,0,0.05);
    border-radius: 12px;
    transition: transform 0.2s ease-in-out;
  }
  .card-custom:hover {
    transform: translateY(-5px);
    border-color: var(--primary-gold);
  }
  .highlight {
    color: #66ccff;
  }
</style>

<!-- Hero Section -->
<div class="hero-section">
  <img src="../img/hero.jpg" alt="hero">
  <div class="hero-text">
    <h1 class="display-4 fw-bold">Welcome to Our Services</h1>
    <p class="lead">Empowering you with the best solutions worldwide</p>
    <a href="services.php" class="btn btn-primary-custom btn-lg">Explore Services</a>
  </div>
</div>

<!-- About Section -->
<div class="container py-5">
  <div class="row align-items-center">
    <div class="col-md-6 mb-4">
      <img src="../img/pertama.jpg" alt="about" class="img-fluid rounded-4 shadow">
    </div>
    <div class="col-md-6">
      <h2 class="fw-bold mb-3">About Us</h2>
      <p>
        We are committed to providing <span class="highlight">world-class services</span> 
        tailored to meet your needs. Our team of experts works with passion and precision 
        to ensure the best experience for every client.
      </p>
      <p>
        Whether you are looking for personal or professional solutions, we are here to 
        help you achieve success.
      </p>
      <a href="about.php" class="btn btn-primary-custom">Learn More</a>
    </div>
  </div>
</div>

<!-- Services Highlight -->
<div class="container pb-5">
  <h2 class="text-center fw-bold mb-4">Our Top Services</h2>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card card-custom p-3 h-100">
        <h5 class="fw-bold text-dark">Consultation</h5>
        <p>Get professional advice and tailored solutions from our experienced experts.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-custom p-3 h-100">
        <h5 class="fw-bold text-dark">Workshops</h5>
        <p>Join our workshops to upgrade your skills and stay ahead of the curve.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-custom p-3 h-100">
        <h5 class="fw-bold text-dark">Support</h5>
        <p>Our support team is available 24/7 to assist you with any concerns.</p>
      </div>
    </div>
  </div>
</div>

<!-- Call To Action -->
<div class="text-center py-5">
  <h2 class="fw-bold">Ready to Get Started?</h2>
  <p class="mb-4">Book your first service today and take the next step toward success.</p>
  <a href="services.php" class="btn btn-primary-custom btn-lg">Book Now</a>
</div>

<?php include '../layouts/footer.php'; ?>

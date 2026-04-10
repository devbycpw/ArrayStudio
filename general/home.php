<?php 
require '../layouts/main.php';
require '../database.php'; 
include '../layouts/navbarGeneral.php';

// Dynamic services for teaser
$topServices = query("SELECT * FROM services LIMIT 3");
?>

<!-- HERO SECTION - Emotional Photography Experience -->
<section class="hero-section">
  <img src="../img/hero.jpg" alt="Capture Your Moments" class="hero-bg">
  <div class="hero-overlay"></div>
  <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
    <h1 class="hero-title fade-in-up">Capture Your Most Precious Moments</h1>
    <p class="hero-subtitle fade-in-up" data-aos-delay="400">
      Every smile, every tear, every heartbeat. We immortalize your story 
      with passion, creativity, and professional perfection.
    </p>
    <a href="services.php" class="hero-cta fade-in-up" data-aos-delay="600">
      <i class="bi bi-camera2 me-2"></i> Book Your Dream Shoot Now
    </a>
  </div>
</section>

<!-- TRUST SIGNALS -->
<section class="section py-5">
  <div class="container">
    <div class="row text-center g-4">
      <div class="col-md-3 col-sm-6">
        <div class="h2 text-warning mb-2"><?= count(query("SELECT * FROM services")) ?></div>
        <div class="h6 text-muted">Premium Packages</div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="h2 text-warning mb-2"><?= count(query("SELECT * FROM gallery")) ?>+</div>
        <div class="h6 text-muted">Happy Memories Captured</div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="h2 text-warning mb-2">24/7</div>
        <div class="h6 text-muted">Support</div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="h2 text-warning mb-2">100%</div>
        <div class="h6 text-muted">Satisfaction</div>
      </div>
    </div>
  </div>
</section>

<!-- PORTFOLIO PREVIEW -->
<section class="section" style="background: var(--card-bg);">
  <div class="container">
    <h2 class="section-title" data-aos="fade-up">Our Magical Moments</h2>
    <div class="row g-4">
      <?php foreach (array_slice(query("SELECT * FROM gallery ORDER BY RAND() LIMIT 6"), 0, 6) as $gal): ?>
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="gallery-item">
          <img src="../img/<?= $gal['image_url'] ?>" alt="Portfolio" class="rounded-3 shadow">
          <div class="position-absolute bottom-0 start-0 end-0 p-3 bg-white bg-opacity-75 text-dark fw-bold">
            <small><?= $gal['category'] ?? 'Beautiful Moment' ?></small>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-5">
      <a href="gallery.php" class="btn-gradient btn-lg">View Full Gallery</a>
    </div>
  </div>
</section>

<!-- WHY CHOOSE US -->
<section class="section">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6" data-aos="fade-right">
        <img src="../img/pertama.jpg" alt="Why Us" class="img-fluid rounded-4 shadow-lg float-animation">
      </div>
      <div class="col-lg-6" data-aos="fade-left">
        <h2 class="section-title mb-4">Why Couples Choose Array Studio?</h2>
        <div class="row g-4">
          <div class="col-md-6">
            <div class="d-flex align-items-start mb-4">
              <i class="bi bi-heart-fill text-warning fs-3 me-3 mt-1"></i>
              <div>
                <h5 class="fw-bold">Emotional Storytelling</h5>
                <p class="text-muted">We don't just take photos, we capture emotions that last a lifetime.</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex align-items-start mb-4">
              <i class="bi bi-star-fill text-warning fs-3 me-3 mt-1"></i>
              <div>
                <h5 class="fw-bold">5-Star Experience</h5>
                <p class="text-muted">Every client receives VIP treatment from first contact to final delivery.</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex align-items-start">
              <i class="bi bi-lightning-charge text-accent-blue fs-3 me-3 mt-1"></i>
              <div>
                <h5 class="fw-bold">Fast Turnaround</h5>
                <p class="text-muted">Edited photos delivered in 7-14 days. Never keep you waiting!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SERVICES TEASER -->
<section class="section" style="background: var(--card-bg);">
  <div class="container">
    <h2 class="section-title" data-aos="fade-up">Perfect Package for You</h2>
    <div class="row g-4">
      <?php foreach ($topServices as $service): ?>
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="service-card h-100">
          <h3 class="service-title"><?= htmlspecialchars($service['name']) ?></h3>
          <p class="text-muted mb-3"><?= substr(htmlspecialchars($service['description'] ?? 'Professional photography service'), 0, 100) ?>...</p>
          <div class="price-tag">Rp <?= number_format($service['price'], 0, ',', '.') ?></div>
          <a href="services.php" class="btn-gradient btn-book mt-3">Choose Package</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-5">
      <a href="services.php" class="btn-gradient btn-lg">View All Packages</a>
    </div>
  </div>
</section>

<!-- INSTANT BOOKING CTA -->
<section class="booking-cta mx-auto" style="max-width: 800px;" data-aos="zoom-in">
  <h2 class="booking-title mb-3">Ready to Create Magic?</h2>
  <p class="h5 fw-light mb-4">Your dream photoshoot is just 2 minutes away</p>
  <div class="row g-3 justify-content-center">
    <div class="col-md-5">
      <a href="auth/register.php" class="btn btn-light w-100 py-3 fw-bold rounded-pill">
        <i class="bi bi-person-plus me-2"></i>Create Free Account
      </a>
    </div>
    <div class="col-md-5">
      <a href="services.php" class="btn-gradient w-100 py-3 fw-bold rounded-pill">
        <i class="bi bi-calendar-check me-2"></i>Book Now
      </a>
    </div>
  </div>
  <div class="mt-4">
    <small class="text-muted">Trusted by 500+ happy couples • Secure booking • Free consultation</small>
  </div>
</section>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 1200, once: true });
</script>

<?php include '../layouts/footer.php'; ?>

<style>
/* Quick fixes for new hero */
.hero-section { min-height: 100vh; }
.hero-bg { width: 100%; height: 100%; object-fit: cover; }
</style>

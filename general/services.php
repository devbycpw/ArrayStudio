<?php
session_start();
require '../layouts/main.php';
require '../database.php'; 
include '../layouts/navbarGeneral.php';

// Services data
$services = query("SELECT * FROM services ORDER BY id_service");

// Check login for booking
$loginRequired = !isset($_SESSION['login']);
?>

<section class="section py-5">
  <div class="container">
    <!-- Header -->
    <div class="text-center mb-5" data-aos="fade-up">
      <h1 class="section-title mb-4">Photography Packages</h1>
      <p class="lead text-muted" style="max-width: 600px; margin: 0 auto;">
        Choose your perfect package. Starting from <strong>Rp500K</strong>. 
        Professional editing included ✓ Unlimited revisions ✓
      </p>
    </div>

    <?php if (empty($services)): ?>
      <div class="text-center py-5">
        <i class="bi bi-camera display-1 text-muted"></i>
        <h3 class="mt-3">No Packages Available</h3>
        <p class="text-muted">Please check back later or contact us directly.</p>
        <a href="../client/booking.php" class="btn-gradient btn-lg">Custom Request</a>
      </div>
    <?php else: ?>
      <!-- Filter Tabs (future enhancement) -->
      <div class="text-center mb-5">
        <a href="#" class="btn btn-outline-light me-3 mb-2">All</a>
        <a href="#" class="btn btn-outline-light me-3 mb-2">Wedding</a>
        <a href="#" class="btn btn-outline-light me-3 mb-2">Portrait</a>
        <a href="#" class="btn btn-outline-light mb-2">Event</a>
      </div>

      <!-- Services Grid -->
      <div class="row g-4">
        <?php foreach ($services as $service): ?>
          <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <!-- Service Card -->
            <div class="service-card h-100 position-relative overflow-hidden">
              <!-- Top Badge -->
              <div class="position-absolute top-0 end-0 bg-success bg-opacity-90 text-white px-3 py-1 rounded-start-pill small fw-bold m-3">
                Most Popular
              </div>
              
              <!-- Content -->
              <div class="p-4 h-100 d-flex flex-column">
                <!-- Title & Rating -->
                <div class="mb-4">
                  <h3 class="service-title mb-2"><?= htmlspecialchars($service['name']) ?></h3>
                  <div class="d-flex align-items-center mb-3">
                    <div class="d-flex me-2">
                      <i class="bi bi-star-fill text-warning"></i>
                      <i class="bi bi-star-fill text-warning"></i>
                      <i class="bi bi-star-fill text-warning"></i>
                      <i class="bi bi-star-fill text-warning"></i>
                      <i class="bi bi-star-half text-warning"></i>
                    </div>
                    <small class="text-muted">(4.9/5 - 127 reviews)</small>
                  </div>
                </div>
                
                <!-- Description -->
                <div class="flex-grow-1 mb-4">
                  <p class="text-muted"><?= htmlspecialchars($service['description']) ?></p>
                </div>
                
                <!-- Price & Features -->
                <div class="mb-4">
                  <div class="price-tag mb-3">Rp <?= number_format($service['price'], 0, ',', '.') ?></div>
                  <ul class="list-unstyled small text-muted">
                    <li class="d-flex align-items-center mb-1">
                      <i class="bi bi-check-circle-fill text-success me-2"></i>
                      Professional editing included
                    </li>
                    <li class="d-flex align-items-center mb-1">
                      <i class="bi bi-check-circle-fill text-success me-2"></i>
                      <?= timeAgo($service['created_at'], true) ?>
                    </li>
                    <li class="d-flex align-items-center">
                      <i class="bi bi-check-circle-fill text-success me-2"></i>
                      Unlimited revisions
                    </li>
                  </ul>
                </div>
                
                <!-- CTA Buttons -->
                <div class="mt-auto">
                  <?php if ($loginRequired): ?>
                    <a href="../auth/login.php" class="btn btn-outline-dark w-100 mb-2">
                      <i class="bi bi-box-arrow-in-right me-2"></i>Login to Book
                    </a>
                    <a href="../auth/register.php" class="btn-gradient w-100">
                      <i class="bi bi-person-plus me-2"></i>Create Free Account
                    </a>
                  <?php else: ?>
                    <a href="../client/booking.php?id_service=<?= $service['id_service'] ?>" 
                       class="btn-gradient w-100 btn-lg shadow-lg">
                      <i class="bi bi-calendar-check me-2"></i>Book This Package
                    </a>
                  <?php endif; ?>
                </div>
              </div>
              
              <!-- Hover Effect Overlay -->
              <div class="position-absolute top-0 bottom-0 left-0 right-0 bg-primary bg-opacity-0 hover-show">
                <div class="h-100 d-flex align-items-center justify-content-center">
                  <i class="bi bi-heart-fill fs-1 text-white"></i>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- Comparison Table CTA -->
    <div class="text-center mt-5 p-5 rounded-4" style="background: var(--card-bg);">
      <h3 class="mb-3">Not sure which package?</h3>
      <p class="text-muted mb-4">Get free consultation to find your perfect match.</p>
      <a href="../client/booking.php" class="btn-gradient btn-lg px-5">Free Consultation</a>
    </div>
  </div>
</section>

<!-- Quick Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 1000 });
</script>

<?php include '../layouts/footer.php'; ?>

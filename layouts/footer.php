<footer class="footer mt-auto">
  <div class="container-fluid py-5">
    <div class="row g-4">
      <!-- Brand -->
      <div class="col-lg-3 col-md-6">
        <div>
          <a class="navbar-brand d-block mb-3" href="../general/home.php">
            <i class="bi bi-camera-reels-fill text-warning fs-2 me-2"></i>
            Array Studio
          </a>
          <p class="text-muted mb-4 pb-2">
            Professional photography that captures the emotion of your most important moments.
          </p>
          <!-- Social -->
          <div class="d-flex gap-3">
            <a href="#" class="text-muted hover-gold"><i class="bi bi-facebook fs-5"></i></a>
            <a href="#" class="text-muted hover-gold"><i class="bi bi-instagram fs-5"></i></a>
            <a href="#" class="text-muted hover-gold"><i class="bi bi-whatsapp fs-5"></i></a>
            <a href="#" class="text-muted hover-gold"><i class="bi bi-youtube fs-5"></i></a>
          </div>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="col-lg-2 col-md-6">
        <h6 class="fw-bold text-dark mb-3">Explore</h6>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="../general/home.php" class="text-muted small hover-gold">Home</a></li>
          <li class="mb-2"><a href="../general/services.php" class="text-muted small hover-gold">Packages</a></li>
          <li class="mb-2"><a href="../general/gallery.php" class="text-muted small hover-gold">Portfolio</a></li>
          <li class="mb-2"><a href="../client/booking.php" class="text-muted small hover-gold">Book Now</a></li>
        </ul>
      </div>

      <!-- Services -->
      <div class="col-lg-3 col-md-6">
        <h6 class="fw-bold text-dark mb-3">Popular Services</h6>
        <ul class="list-unstyled">
          <?php 
          $topServices = array_slice(query("SELECT name FROM services ORDER BY price DESC LIMIT 4"), 0, 4);
          foreach ($topServices as $svc): 
          ?>
            <li class="mb-2">
              <a href="../general/services.php" class="text-muted small hover-gold d-flex align-items-center">
                <i class="bi bi-circle-fill text-warning me-2" style="font-size: 0.4rem;"></i>
                <?= htmlspecialchars($svc['name']) ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Contact + Testimonials -->
      <div class="col-lg-4 col-md-6">
        <div class="mb-4">
          <h6 class="fw-bold text-dark mb-3">Get In Touch</h6>
          <div>
            <div class="d-flex align-items-center mb-3">
              <i class="bi bi-geo-alt-fill text-warning me-3 fs-5"></i>
              <div>
                <div class="fw-bold small">Jakarta, Indonesia</div>
                <small class="text-muted">Available Worldwide</small>
              </div>
            </div>
            <div class="d-flex align-items-center mb-3">
              <i class="bi bi-telephone-fill text-warning me-3 fs-5"></i>
              <a href="tel:+628123456789" class="fw-bold small text-dark hover-gold">+62 812-3456-7890</a>
            </div>
            <div class="d-flex align-items-start">
              <i class="bi bi-envelope-fill text-warning me-3 fs-5 mt-1"></i>
              <a href="mailto:hello@arraystudio.com" class="fw-bold small text-dark hover-gold">hello@arraystudio.com</a>
            </div>
          </div>
        </div>
        
        <!-- Mini Testimonial -->
        <div class="border-start border-warning border-3 ps-4">
          <div class="fw-bold text-warning small mb-1">"Best decision ever!"</div>
          <div class="small text-muted">Sarah & John - Wedding</div>
        </div>
      </div>
    </div>

    <!-- Bottom Bar -->
    <hr class="my-4 opacity-25">
    <div class="row align-items-center">
      <div class="col-md-6">
        <small class="text-muted">
          © 2025 Array Studio. All rights reserved. 
          <span class="text-warning fw-bold">Crafted with ❤️ for memorable moments</span>
        </small>
      </div>
      <div class="col-md-6 text-md-end mt-2 mt-md-0">
        <small class="text-muted">
          <a href="#" class="text-muted hover-gold me-3 small text-decoration-none">Privacy</a>
          <a href="#" class="text-muted hover-gold me-3 small text-decoration-none">Terms</a>
          <a href="#" class="text-muted hover-gold small text-decoration-none">Sitemap</a>
        </small>
      </div>
    </div>
  </div>
</footer>

<!-- Scripts (moved to main.php but kept for compatibility) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

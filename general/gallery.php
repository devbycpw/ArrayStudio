<?php
require '../layouts/main.php';
require '../database.php'; 
include '../layouts/navbarGeneral.php';

$gallery = query("SELECT * FROM gallery ORDER BY RAND()");
$currentIndex = 0;
?>

<section class="section py-5">
  <div class="container">
    <!-- Header -->
    <div class="text-center mb-5" data-aos="fade-up">
      <h1 class="section-title mb-4">Our Portfolio</h1>
      <p class="lead text-muted mb-0" style="max-width: 700px; margin: 0 auto;">
        Every moment tells a story. Browse thousands of beautiful memories we've captured for clients just like you.
      </p>
    </div>

    <!-- Filter Buttons -->
    <div class="text-center mb-5">
      <button class="btn btn-outline-light active me-3 mb-2 filter-btn" data-filter="all">All Categories</button>
      <button class="btn btn-outline-light me-3 mb-2 filter-btn" data-filter="wedding">Weddings</button>
      <button class="btn btn-outline-light me-3 mb-2 filter-btn" data-filter="portrait">Portraits</button>
      <button class="btn btn-outline-light mb-2 filter-btn" data-filter="event">Events</button>
    </div>

    <!-- Masonry Gallery -->
    <div class="gallery-masonry">
      <?php foreach ($gallery as $img): ?>
        <div class="gallery-item" data-category="<?= strtolower($img['category'] ?? 'portrait') ?>" data-index="<?= $currentIndex++ ?>">
          <img src="../img/<?= $img['image_url'] ?>" alt="<?= htmlspecialchars($img['category'] ?? 'Photography') ?>" loading="lazy">
          <div class="gallery-overlay">
            <div class="overlay-content">
              <div class="overlay-icon">
                <i class="bi bi-plus-circle"></i>
              </div>
              <h6><?= htmlspecialchars($img['category'] ?? 'Beautiful Moment') ?></h6>
            </div>
          </div>
          <span class="category-tag"><?= htmlspecialchars($img['category'] ?? 'Portrait') ?></span>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Load More CTA -->
    <div class="text-center mt-5">
      <button class="btn-gradient btn-lg px-5 load-more">
        <i class="bi bi-image me-2"></i>Load More Inspiration
      </button>
    </div>
  </div>
</section>

<!-- LIGHTBOX MODAL -->
<div id="lightbox" class="lightbox-modal">
  <div class="lightbox-container">
    <button class="lightbox-close" id="closeLightbox">
      <i class="bi bi-x-lg"></i>
    </button>
    <button class="lightbox-nav lightbox-prev" id="prevImg">
      <i class="bi bi-chevron-left"></i>
    </button>
    <img src="" alt="" class="lightbox-img" id="lightboxImg">
    <button class="lightbox-nav lightbox-next" id="nextImg">
      <i class="bi bi-chevron-right"></i>
    </button>
    <div class="lightbox-counter" id="counter">1 of <?= count($gallery) ?></div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<link rel="stylesheet" href="../static/lightbox.css">

<script>
// AOS
AOS.init({ duration: 800, once: true });

// Lightbox
const lightbox = document.getElementById('lightbox');
const lightboxImg = document.getElementById('lightboxImg');
const closeBtn = document.getElementById('closeLightbox');
const prevBtn = document.getElementById('prevImg');
const nextBtn = document.getElementById('nextImg');
const counter = document.getElementById('counter');

let currentImageIndex = 0;
const allImages = Array.from(document.querySelectorAll('.gallery-item img'));

function openLightbox(index) {
  currentImageIndex = index;
  updateLightbox();
  lightbox.classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closeLightbox() {
  lightbox.classList.remove('active');
  document.body.style.overflow = '';
}

function updateLightbox() {
  lightboxImg.src = allImages[currentImageIndex].src;
  lightboxImg.alt = allImages[currentImageIndex].alt;
  counter.textContent = `${currentImageIndex + 1} of ${allImages.length}`;
}

function nextImage() {
  currentImageIndex = (currentImageIndex + 1) % allImages.length;
  updateLightbox();
}

function prevImage() {
  currentImageIndex = (currentImageIndex - 1 + allImages.length) % allImages.length;
  updateLightbox();
}

// Event Listeners
document.querySelectorAll('.gallery-item').forEach((item, index) => {
  item.addEventListener('click', () => openLightbox(index));
});

closeBtn.addEventListener('click', closeLightbox);
prevBtn.addEventListener('click', prevImage);
nextBtn.addEventListener('click', nextImage);

lightbox.addEventListener('click', (e) => {
  if (e.target === lightbox) closeLightbox();
});

// Keyboard
document.addEventListener('keydown', (e) => {
  if (!lightbox.classList.contains('active')) return;
  if (e.key === 'Escape') closeLightbox();
  if (e.key === 'ArrowRight') nextImage();
  if (e.key === 'ArrowLeft') prevImage();
});

// Filter (basic)
document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', (e) => {
    e.preventDefault();
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    
    const filter = btn.dataset.filter;
    document.querySelectorAll('.gallery-item').forEach(item => {
      if (filter === 'all' || item.dataset.category === filter) {
        item.style.opacity = '1';
        item.style.transform = 'scale(1)';
      } else {
        item.style.opacity = '0.3';
        item.style.transform = 'scale(0.9)';
      }
    });
  });
});
</script>

<?php include '../layouts/footer.php'; ?>

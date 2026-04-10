<?php
session_start();
require '../layouts/main.php';
require '../database.php';
include '../layouts/navbarClient.php';

if (!isset($_SESSION["login"])) {
    header("Location: ../auth/login.php");
    exit;
}

$id_service = $_GET['id_service'] ?? null;
$id_user = $_SESSION['id_user'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];

// Get data
$services = query("SELECT * FROM services");
$selectedService = $id_service ? query("SELECT * FROM services WHERE id_service = $id_service")[0] ?? null : null;

// Check payment pending
$cekPay = query("SELECT * FROM bookings WHERE id_user = '$id_user' AND status = 'approved' LIMIT 1");
if (!empty($cekPay)) {
    header("Location: payment.php?id_booking=" . $cekPay[0]['id_booking']);
    exit;
}

// Active booking
$cekBooking = query("SELECT b.*, s.name AS service_name, s.price 
                     FROM bookings b JOIN services s ON b.id_service = s.id_service
                     WHERE b.id_user = '$id_user' AND b.status = 'pending' LIMIT 1");

// Booked slots
$jadwalTerbooking = query("
    SELECT booking_date, booking_time, status, s.name
    FROM bookings b JOIN services s ON b.id_service = s.id_service
    WHERE booking_date >= CURDATE() AND status IN ('pending','approved','confirmed')
    ORDER BY booking_date, booking_time
");

// Handle booking
if (isset($_POST['submit'])) {
    if (insbook($_POST)) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Booking Berhasil!',
                text: 'Menunggu konfirmasi admin (24 jam)',
                timer: 3000
            }).then(() => location.href='booking.php');
        </script>";
    } else {
        echo "<script>Swal.fire('Error', 'Booking gagal. Coba lagi.', 'error');</script>";
    }
}

// Cancel
if (isset($_POST['cancel_booking'])) {
    mysqli_query($conn, "UPDATE bookings SET status='cancelled', updated_at=NOW() WHERE id_user = '$id_user' AND status='pending'");
    header("Location: booking.php");
    exit;
}
?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>

<style>
.booking-hero {
  background: linear-gradient(135deg, rgba(244,196,48,0.1), rgba(74,144,226,0.1)), 
              var(--card-bg);
  border-radius: 24px;
  padding: 3rem;
  margin-bottom: 3rem;
  position: relative;
  overflow: hidden;
}

.booking-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--primary-gold), var(--accent-blue));
}

.booking-step {
  position: absolute;
  top: 20px;
  right: 20px;
  background: var(--primary-gold);
  color: #fff;
  padding: 0.5rem 1rem;
  border-radius: 50px;
  font-weight: 600;
  font-size: 0.85rem;
}

.available-slots {
  max-height: 300px;
  overflow-y: auto;
}

.schedule-conflict {
  background: rgba(220,53,69,0.1) !important;
  border-left: 4px solid #dc3545 !important;
}

.form-floating label {
  color: var(--text-muted);
}

.form-control:focus {
  border-color: var(--primary-gold);
  box-shadow: 0 0 0 0.2rem rgba(244,196,48,0.25);
}

.booking-success {
  animation: bounceIn 0.6s ease;
}

@keyframes bounceIn {
  0% { transform: scale(0.3); opacity: 0; }
  50% { transform: scale(1.05); }
  70% { transform: scale(0.9); }
  100% { transform: scale(1); opacity: 1; }
}
</style>

<div class="container py-5">
  <!-- HERO BANNER -->
  <div class="row justify-content-center">
    <div class="col-12 text-center mb-5">
      <h1 class="display-4 fw-bold mb-3" data-aos="fade-down">
        <i class="bi bi-calendar4-week text-warning"></i> 
        Book Your Photoshoot
      </h1>
      <p class="lead text-muted mb-4" data-aos="fade-up" data-aos-delay="200">
        Frictionless booking. Secure payments. Professional service guaranteed.
      </p>
      <?php if ($selectedService): ?>
        <div class="booking-hero p-4 shadow-lg" data-aos="zoom-in">
          <div class="booking-step">Selected: <?= htmlspecialchars($selectedService['name']) ?></div>
          <div class="row align-items-center">
            <div class="col-md-8">
              <h3 class="fw-bold mb-1"><?= htmlspecialchars($selectedService['name']) ?></h3>
              <div class="price-tag mb-2">Rp <?= number_format($selectedService['price'], 0, ',', '.') ?></div>
              <small class="text-success fw-bold">✅ Instant confirmation | Free revisions</small>
            </div>
            <div class="col-md-4 text-end">
              <a href="services.php" class="btn btn-outline-light">Change Package</a>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
      <?php if (!empty($cekBooking)): ?>
        <!-- ACTIVE BOOKING DASHBOARD -->
        <div class="card shadow-sm border-0 service-card" data-aos="fade-up">
          <div class="card-body p-5 text-center">
            <div class="mb-4">
              <i class="bi bi-check-circle-fill display-3 text-success"></i>
              <h2 class="mt-3 text-success fw-bold">Booking Confirmed!</h2>
            </div>
            <div class="row g-4 mb-4">
              <div class="col-md-6">
                <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                  <h6 class="fw-bold mb-2">📸 Service</h6>
                  <div class="h5 fw-bold"><?= htmlspecialchars($cekBooking[0]['service_name']) ?></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="bg-info bg-opacity-10 p-3 rounded-3">
                  <h6 class="fw-bold mb-2">📅 Schedule</h6>
                  <div class="h6"><?= date('d M Y', strtotime($cekBooking[0]['booking_date'])) ?> | <?= date('H:i', strtotime($cekBooking[0]['booking_time'])) ?></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                  <h6 class="fw-bold mb-2">💰 Price</h6>
                  <div class="h5 fw-bold text-primary">Rp <?= number_format($cekBooking[0]['price'], 0, ',', '.') ?></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="bg-success bg-opacity-10 p-3 rounded-3">
                  <h6 class="fw-bold mb-2">✅ Status</h6>
                  <span class="badge bg-success fs-6 px-3 py-2"><?= ucfirst($cekBooking[0]['status']) ?></span>
                </div>
              </div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
              <form method="post">
                <button name="cancel_booking" class="btn btn-outline-danger btn-lg px-4">
                  <i class="bi bi-x-circle me-2"></i>Cancel Booking
                </button>
              </form>
              <a href="payment.php?id_booking=<?= $cekBooking[0]['id_booking'] ?>" class="btn btn-gradient btn-lg px-4">
                <i class="bi bi-credit-card me-2"></i>Proceed to Payment
              </a>
            </div>
          </div>
        </div>

      <?php else: ?>
        <!-- NEW BOOKING FORM - Frictionless -->
        <form method="post" id="bookingForm" class="card shadow-sm border-0 service-card" data-aos="fade-up">
          <div class="card-body p-5">
            <!-- Progress Bar -->
            <div class="booking-progress mb-5">
              <div class="d-flex justify-content-between mb-3">
                <div class="step active">
                  <div class="step-circle">1</div>
                  <small>Details</small>
                </div>
                <div class="step">
                  <div class="step-circle">2</div>
                  <small>Review</small>
                </div>
                <div class="step">
                  <div class="step-circle">3</div>
                  <small>Confirm</small>
                </div>
              </div>
              <div class="progress" style="height: 4px;">
                <div class="progress-bar bg-gradient" style="width: 33%"></div>
              </div>
            </div>

            <!-- Client Info (readonly) -->
            <div class="row g-4 mb-5">
              <div class="col-md-6">
                <label class="form-label fw-bold">👤 Full Name</label>
                <input type="text" class="form-control bg-light text-dark border" value="<?= htmlspecialchars($username) ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">📧 Email</label>
                <input type="email" class="form-control bg-light text-dark border" value="<?= htmlspecialchars($email) ?>" readonly>
              </div>
            </div>

            <!-- Service Selection -->
            <div class="mb-5">
              <label class="form-label fs-5 fw-bold mb-3 d-block">📸 Select Package</label>
              <div class="row g-3">
                <?php foreach ($services as $service): ?>
                  <div class="col-md-6">
                    <div class="service-preview p-3 rounded-3 border hoverable" 
                         data-service-id="<?= $service['id_service'] ?>"
                         style="cursor: pointer; transition: all 0.3s ease; border: 2px solid transparent;">
                      <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-bold mb-0"><?= htmlspecialchars($service['name']) ?></h6>
                        <div class="price-small fw-bold text-warning">Rp <?= number_format($service['price'], 0, ',', '.') ?></div>
                      </div>
                      <p class="small text-muted mb-2"><?= substr(htmlspecialchars($service['description']), 0, 80) ?>...</p>
                      <small class="text-success fw-bold">✅ Instant booking</small>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
              <input type="hidden" name="service" id="selectedService" required>
            </div>

            <!-- Date & Time -->
            <div class="row g-4 mb-5">
              <div class="col-md-6">
                <label class="form-label fw-bold">📅 Date</label>
                <input type="date" id="schedule" name="schedule" class="form-control bg-light text-dark" min="<?= date('Y-m-d') ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">🕐 Time</label>
                <input type="time" id="time" name="time" class="form-control bg-light text-dark" required>
              </div>
            </div>

            <!-- Available Slots -->
            <?php if (!empty($jadwalTerbooking)): ?>
            <div class="available-slots mb-5 p-4 rounded-3" style="background: var(--card-hover-bg);">
              <h6 class="fw-bold mb-3">📋 Upcoming Bookings <span class="badge bg-info"><?= count($jadwalTerbooking) ?></span></h6>
              <div class="row g-2 small">
                <?php foreach (array_slice($jadwalTerbooking, 0, 6) as $slot): ?>
                  <div class="col-sm-6 col-lg-4">
                    <div class="p-2 rounded-2 schedule-conflict">
                      <small class="text-muted"><?= date('d M', strtotime($slot['booking_date'])) ?></small><br>
                      <span class="fw-bold"><?= date('H:i', strtotime($slot['booking_time'])) ?></span>
                      <span class="badge bg-warning ms-1"><?= $slot['status'] ?></span>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
              <?php if (count($jadwalTerbooking) > 6): ?>
                <small class="text-muted d-block mt-2">... and <?= count($jadwalTerbooking) - 6 ?> more</small>
              <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Summary & Submit -->
            <div class="border-top pt-4">
              <div class="row align-items-end g-3">
                <div class="col-md-7">
                  <div class="booking-summary p-3 rounded-3" style="background: rgba(244,196,48,0.05);">
                    <h6 class="fw-bold mb-3">📋 Booking Summary</h6>
                    <div id="summaryContent">
                      <em>Select service, date & time to see summary</em>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <button type="submit" name="submit" class="btn btn-gradient w-100 btn-lg shadow-lg" id="bookBtn" disabled>
                    <i class="bi bi-check-circle me-2"></i>
                    <span id="bookText">Complete Booking</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
// Flatpickr with availability check
flatpickr("#schedule", {
  minDate: "today",
  disable: [<?= json_encode(array_column($jadwalTerbooking, 'booking_date')) ?>],
  onChange: function(selectedDates, dateStr) {
    updateSummary();
  }
});

// Service selection
document.querySelectorAll('.service-preview').forEach(card => {
  card.addEventListener('click', function() {
    document.querySelectorAll('.service-preview').forEach(c => {
      c.style.borderColor = 'transparent';
      c.style.background = 'transparent';
    });
    this.style.borderColor = 'var(--primary-gold)';
    this.style.background = 'rgba(244,196,48,0.05)';
    
    document.getElementById('selectedService').value = this.dataset.serviceId;
    updateSummary();
  });
});

function updateSummary() {
  const serviceId = document.getElementById('selectedService').value;
  const date = document.getElementById('schedule').value;
  const time = document.getElementById('time').value;
  
  if (serviceId && date && time) {
    document.getElementById('bookBtn').disabled = false;
    document.getElementById('bookText').innerHTML = '<i class="bi bi-lightning-charge me-2"></i>Book Instantly';
    
    // Update summary
    const service = <?= json_encode($services) ?>.find(s => s.id_service == serviceId);
    document.getElementById('summaryContent').innerHTML = `
      <div class="mb-2">
        <strong>${service ? service.name : 'Service'}</strong><br>
        <small class="text-muted">Rp ${service ? service.price.toLocaleString() : '0'}</small>
      </div>
      <div>${date} | ${time}</div>
      <div class="text-success small fw-bold mt-2">✅ Available slot</div>
    `;
  } else {
    document.getElementById('bookBtn').disabled = true;
    document.getElementById('bookText').textContent = 'Complete Booking';
  }
}

// Real-time summary update
document.getElementById('time').addEventListener('change', updateSummary);
</script>

<!-- Quick Scripts for AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 1000, once: true });
</script>

<?php include '../layouts/footer.php'; ?>

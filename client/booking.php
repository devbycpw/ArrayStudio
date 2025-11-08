<?php 
session_start();
require '../database.php';
require '../layouts/main.php';
include '../layouts/navbarClient.php';

if(!isset($_SESSION["login"])){
    header("Location: ../auth/login.php");
    exit;
}

$id_service = isset($_GET['id_service']) ? $_GET['id_service'] : null;
$id_user = $_SESSION['id_user'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];

// Ambil data service
$services = query("SELECT * FROM services");


// ambil aprroved 
$cekPay = query("SELECT * FROM bookings WHERE id_user = '$id_user' AND status = 'approved' LIMIT 1");


if(!empty($cekPay)){
  header("Location: payment.php?id_booking=" . $cekPay[0]['id_booking']);
}

// Ambil booking aktif user
$cekBooking = query("SELECT b.*, s.name AS service_name, s.price 
                     FROM bookings b 
                     JOIN services s ON b.id_service = s.id_service
                     WHERE b.id_user = '$id_user' AND b.status = 'pending' 
                     LIMIT 1");


// Ambil semua jadwal yang sudah dibooking (pending/approved/confirmed)
$jadwalTerbooking = query("
    SELECT booking_date, booking_time, status
    FROM bookings 
    WHERE booking_date >= CURDATE() 
      AND status IN ('pending','approved','confirmed')
    ORDER BY booking_date, booking_time
");

// Handle submit booking
if (isset($_POST['submit'])) {
    if (insbook($_POST)) {
        echo "<script>alert('Booking berhasil, sedang menunggu konfirmasi admin.');document.location.href='booking.php'</script>";
    } else {
        echo "<script>alert('Booking gagal.');</script>";
    }
}

// Handle cancel booking
if (isset($_POST['cancel_booking'])) {
    mysqli_query($conn,"UPDATE bookings 
                        SET status='cancelled', updated_at=NOW() 
                        WHERE id_user = '$id_user' AND status='pending'");
    header("Location: booking.php");
    exit;
}


?>  

<style>
  body {
    background-color: #0d0d0d;
    color: #e0e0e0;
  }
  .card-custom {
    background-color: #1a1a1a;
    border: 1px solid #333;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
  }
  .btn-primary-custom {
    background-color: #ff9900;
    border: none;
    color: #0d0d0d;
    font-weight: bold;
  }
  .btn-primary-custom:hover {
    background-color: #ffd580;
    color: #0d0d0d;
  }
  .btn-danger {
    background-color: #cc3333;
    border: none;
  }
  .btn-danger:hover {
    background-color: #ff4d4d;
  }
  label {
    font-weight: 500;
    margin-top: 10px;
  }
</style>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card-custom">

        <?php if (!empty($cekBooking)) : ?>
            <!-- Jika user punya booking aktif -->
            <h3 class="text-warning mb-4 text-center">Your Current Booking</h3>
            <ul class="list-group list-group-flush mb-3">
              <li class="list-group-item bg-transparent text-light"><strong>Name:</strong> <?= htmlspecialchars($username) ?></li>
              <li class="list-group-item bg-transparent text-light"><strong>Service:</strong> <?= htmlspecialchars($cekBooking[0]['service_name']) ?></li>
              <li class="list-group-item bg-transparent text-light"><strong>Price:</strong> Rp <?= number_format($cekBooking[0]['price'], 0, ',', '.') ?></li>
              <li class="list-group-item bg-transparent text-light"><strong>Schedule:</strong> <?= date('d-m-Y', strtotime($cekBooking[0]['booking_date'])) ?> <?= $cekBooking[0]['booking_time'] ? ' | ' . date('H:i', strtotime($cekBooking[0]['booking_time'])) : '' ?></li>
              <li class="list-group-item bg-transparent text-light"><strong>Status:</strong> 
                <span class="badge bg-warning text-dark"><?= ucfirst($cekBooking[0]['status']) ?></span>
              </li>
              <li class="list-group-item bg-transparent text-light"><strong>Created At:</strong> <?= date('d-m-Y H:i', strtotime($cekBooking[0]['created_at'])) ?></li>
            </ul>

            <form method="post" class="text-center">
                <button type="submit" name="cancel_booking" class="btn btn-danger px-4">Cancel Booking</button>
            </form>

        <?php else : ?>
            <!-- Jika user belum booking -->
            <h3 class="text-warning mb-4 text-center">Book a Service</h3>

            <?php if (!empty($jadwalTerbooking)) : ?>
            <div class="mb-4">
                <h5 class="text-warning">📅 Jadwal yang Sudah Terbooking</h5>
                <ul class="list-group">
                    <?php foreach ($jadwalTerbooking as $j) : ?>
                        <li class="list-group-item bg-transparent text-light">
                            <?= date('d-m-Y', strtotime($j['booking_date'])) ?> 
                            <?= $j['booking_time'] ? ' | ' . date('H:i', strtotime($j['booking_time'])) : '' ?>
                            <span class="badge <?= $j['status'] === 'pending' ? 'bg-warning text-dark' : 'bg-success' ?>">
                                <?= ucfirst($j['status']) ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="mb-3">
                    <label for="username">Full Name</label>
                    <input type="text" id="username" name="username" value="<?= $username ?>" class="form-control bg-dark text-light" readonly>
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?= $email ?>" class="form-control bg-dark text-light" readonly>
                </div>

                <div class="mb-3">
                    <label for="service">Select Service</label>
                    <select name="service" id="service" class="form-select bg-dark text-light" required>
                        <option value="">-- choose service --</option>
                        <?php foreach ($services as $row) : ?>
                            <option value="<?= $row['id_service'] ?>" <?= ($id_service==$row['id_service']) ? 'selected' : '' ?>>
                                <?= $row['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="schedule">Schedule Date</label>
                    <input type="date" id="schedule" name="schedule" min="<?= date('Y-m-d') ?>" class="form-control bg-dark text-light" required>
                </div>

                <div class="mb-3">
                    <label for="time">Schedule Time</label>
                    <input type="time" id="time" name="time" class="form-control bg-dark text-light" required>
                </div>

                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-primary-custom px-5">Book Now</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="history.php" class="link-light">View Booking History</a>
            </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include '../layouts/footer.php'; ?>

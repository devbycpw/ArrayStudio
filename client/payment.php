<?php 
require '../layouts/main.php';
require '../database.php'; 
include '../layouts/navbarClient.php';
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$id_booking = $_GET["id_booking"] ?? '';

// Ambil detail booking
$bookingQuery = "SELECT b.*, s.name AS service_name, s.price 
                 FROM bookings b 
                 JOIN services s ON b.id_service = s.id_service 
                 WHERE b.id_booking = '$id_booking' AND b.id_user = '$id_user'";
$bookingData = query($bookingQuery);

if (empty($bookingData) || !in_array($bookingData[0]['status'], ['approved', 'confirmed', 'paid'])) {
    echo "<script>alert('Booking tidak ditemukan atau belum di-approve.'); window.location.href='booking.php';</script>";
    exit;
}

$booking = $bookingData[0];

// Proses Konfirmasi Pembayaran
if (isset($_POST['confirm_payment'])) {
    // Kita ubah status menjadi confirmed/paid
    $updateQuery = "UPDATE bookings SET status='confirmed', updated_at=NOW() WHERE id_booking='$id_booking'";
    mysqli_query($conn, $updateQuery);
    
    echo "<script>
        alert('Pembayaran berhasil dikonfirmasi! Tim kami akan segera menghubungi Anda.');
        window.location.href='booking.php';
    </script>";
    exit;
}
?>

<div class="container py-5" style="margin-top: 50px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-5">
                <h1 class="fw-bold text-dark mb-2">Penyelesaian Pembayaran</h1>
                <p class="text-muted">Silakan selesaikan pembayaran untuk mengkonfirmasi pesanan Anda.</p>
            </div>

            <div class="card shadow-sm border-0 mb-4" style="border-radius: 24px; position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--primary-gold), var(--accent-blue));"></div>
                <div class="card-body p-4 p-md-5">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-receipt me-2 text-warning"></i>Detail Booking
                    </h5>
                    <div class="row mb-2">
                        <div class="col-sm-4 text-muted">Layanan</div>
                        <div class="col-sm-8 fw-bold text-dark"><?= htmlspecialchars($booking['service_name']) ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 text-muted">Jadwal Foto</div>
                        <div class="col-sm-8 text-dark">
                            <?= date('d M Y', strtotime($booking['booking_date'])) ?> | <?= date('H:i', strtotime($booking['booking_time'])) ?>
                        </div>
                    </div>
                    <div class="row pt-3 mt-3 border-top">
                        <div class="col-sm-4 text-muted fs-5">Total Pembayaran</div>
                        <div class="col-sm-8 fw-bold fs-4" style="color: var(--primary-gold-dark);">
                            Rp <?= number_format($booking['price'], 0, ',', '.') ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($booking['status'] === 'approved'): ?>
            <div class="card shadow-sm border-0 mb-4" style="background-color: var(--main-bg); border-radius: 24px; position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--primary-gold), var(--accent-blue));"></div>
                <div class="card-body p-4 p-md-5 text-center">
                    <h6 class="fw-bold text-dark mb-4">Transfer Bank Manual</h6>
                    
                    <div class="d-flex justify-content-center gap-4 mb-4 flex-wrap">
                        <div class="p-3 bg-white rounded shadow-sm border" style="min-width: 200px;">
                            <h5 class="fw-bold text-primary mb-1">BCA</h5>
                            <div class="fs-5 text-dark fw-bold mb-1">8732 1122 33</div>
                            <small class="text-muted">a.n. PT Array Studio Photography</small>
                        </div>
                        <div class="p-3 bg-white rounded shadow-sm border" style="min-width: 200px;">
                            <h5 class="fw-bold text-warning mb-1">Mandiri</h5>
                            <div class="fs-5 text-dark fw-bold mb-1">137 000 999 888</div>
                            <small class="text-muted">a.n. PT Array Studio Photography</small>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning text-dark text-start lh-lg" style="background-color: #fff9e6; border-color: #ffe69c;">
                        <i class="bi bi-info-circle-fill text-warning me-2"></i>
                        Penting: Masukkan Nomor Booking <strong>#<?= $id_booking ?></strong> pada deskripsi transfer jika memungkinkan.
                    </div>
                </div>
            </div>

            <!-- Tombol Konfirmasi -->
            <div class="text-center">
                <form method="post" onsubmit="return confirm('Apakah Anda yakin sudah melakukan transfer dengan nominal yang sesuai?');">
                    <button type="submit" name="confirm_payment" class="btn btn-gradient btn-lg px-5 shadow">
                        <i class="bi bi-check2-circle me-2"></i>Saya Sudah Bayar
                    </button>
                </form>
                <div class="mt-3">
                    <a href="booking.php" class="text-muted text-decoration-none">Kembali ke Dashboard</a>
                </div>
            </div>
            <?php else: ?>
                <!-- Sudah dibayar  -->
                <div class="alert alert-success text-center p-4">
                    <i class="bi bi-check-circle-fill display-4 text-success d-block mb-3"></i>
                    <h4 class="fw-bold">Pembayaran Telah Selesai</h4>
                    <p class="mb-0">Terima kasih, pembayaran Anda sudah kami konfirmasi. Sampai jumpa di hari H!</p>
                </div>
                <div class="text-center mt-3">
                    <a href="booking.php" class="btn btn-outline-dark">Kembali ke Dashboard</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>

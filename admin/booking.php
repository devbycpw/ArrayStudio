<?php 
require '../layouts/main.php';
require '../database.php'; 
include '../layouts/navbarAdmin.php';
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../auth/login.php");
    exit;
}

// ---- HANDLE UPDATE STATUS ----
if (isset($_GET['action']) && isset($_GET['id'])) {
    $status = $_GET['action'] === 'approve' ? 'approved' : 'rejected';
    if (updateBookingStatus($_GET['id'], $status) > 0) {
        header("Location: booking.php");
        exit;
    }
}

// ---- GET DATA ----
$bookings = getAllBookings();
$pendingBookings = getPendingBookings();
$bentrok = getBentrokDates();

?>
<div class="container-fluid" style="background:var(--main-bg); min-height: 100vh; padding: 2rem;">
    <h2 class="text-dark fw-bold mb-4">Manajemen Booking</h2>

    <!-- Kalender -->
    <div id="calendar" class="mb-5 bg-white shadow-sm p-3 rounded" style="color:var(--text-primary);"></div>

    <!-- Peringatan jika ada bentrok -->
    <?php if (!empty($bentrok)) : ?>
        <div class="alert alert-danger">
            <strong>Peringatan!</strong> Ada jadwal bentrok pada:
            <?= implode(', ', $bentrok); ?>
        </div>
    <?php endif; ?>

    <!-- Data Booking -->
    <div class="card shadow-sm border-0 service-card">
        <div class="card-body">
            <h4 class="text-dark fw-bold">Daftar Booking</h4>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_reverse($bookings) as $b): ?>
                    <tr>
                        <td><?= htmlspecialchars($b['client_name']); ?></td>
                        <td><?= htmlspecialchars($b['service_name']); ?></td>
                        <td><?= $b['booking_date']; ?></td>
                        <td><?= $b['booking_time']; ?></td>
                        <td>
                            <?php if ($b['status'] === 'pending'): ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                            <?php elseif ($b['status'] === 'approved'): ?>
                                <span class="badge bg-success">Approved</span>
                            <?php elseif ($b['status'] === 'rejected'): ?>
                                <span class="badge bg-danger">Rejected</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?= ucfirst($b['status']); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($b['status'] === 'pending'): ?>
                                <a href="?action=approve&id=<?= $b['id_booking']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Terima booking ini?')">ACC</a>
                                <a href="?action=reject&id=<?= $b['id_booking']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tolak booking ini?')">Reject</a>
                            <?php else: ?>
                                <small class="text-muted">-</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- FullCalendar untuk Kalender -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        themeSystem: 'bootstrap5',
        events: [
            <?php foreach ($pendingBookings as $p): ?>
            {
                title: '<?= addslashes($p['client_name']); ?>',
                start: '<?= $p['date']; ?>',
                color: '#C5A880'
            },
            <?php endforeach; ?>
        ]
    });
    calendar.render();
});
</script>

<?php include '../layouts/footer.php'; ?>

<?php 
require '../layouts/main.php';
require '../database.php'; 
include '../layouts/navbarAdmin.php';
session_start();
if(!isset($_SESSION["login"])){
    header("Location: ../auth/login.php");
    exit;
}

$totalClients = query("SELECT COUNT(*) as total FROM users WHERE role='client'")[0]['total'];
$totalBookings = query("SELECT COUNT(*) as total FROM bookings")[0]['total'];
$totalRevenue = query("SELECT SUM(s.price) as total FROM bookings b 
                      JOIN services s ON b.id_service = s.id_service 
                      WHERE b.status='completed'")[0]['total'];
?>

<div class="container-fluid py-4" style="background-color: #0d0d0d; min-height: 100vh;">
    <h2 class="text-light mb-4">Admin Dashboard</h2>

    <div class="row g-4">
        <!-- Total Clients -->
        <div class="col-md-4">
            <div class="card text-center shadow-lg p-3" style="background:#1a1a1a; border:none;">
                <div class="card-body">
                    <i class="bi bi-people-fill text-warning fs-2"></i>
                    <h5 class="text-secondary mt-2">Total Clients</h5>
                    <h3 class="text-warning fw-bold"><?= $totalClients ?></h3>
                </div>
            </div>
        </div>
        <!-- Total Bookings -->
        <div class="col-md-4">
            <div class="card text-center shadow-lg p-3" style="background:#1a1a1a; border:none;">
                <div class="card-body">
                    <i class="bi bi-calendar-event-fill text-info fs-2"></i>
                    <h5 class="text-secondary mt-2">Total Bookings</h5>
                    <h3 class="text-warning fw-bold"><?= $totalBookings ?></h3>
                </div>
            </div>
        </div>
        <!-- Total Revenue -->
        <div class="col-md-4">
            <div class="card text-center shadow-lg p-3" style="background:#1a1a1a; border:none;">
                <div class="card-body">
                    <i class="bi bi-cash-coin text-success fs-2"></i>
                    <h5 class="text-secondary mt-2">Total Revenue</h5>
                    <h3 class="text-warning fw-bold">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow" style="background:#1a1a1a; border:none;">
                <div class="card-body">
                    <h5 class="text-light">Bookings Trend</h5>
                    <canvas id="bookingChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('bookingChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul'],
        datasets: [{
            label: 'Bookings per Month',
            data: [5, 10, 8, 15, 12, 20, 14],
            backgroundColor: '#ff9900'
        }]
    },
    options: {
        scales: {
            x: { ticks: { color: '#e0e0e0' } },
            y: { ticks: { color: '#e0e0e0' } }
        },
        plugins: {
            legend: { labels: { color: '#e0e0e0' } }
        }
    }
});
</script>

<?php include '../layouts/footer.php'; ?>

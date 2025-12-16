
<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';

// ====== STATS ======
$total_tours     = pdo_query_one("SELECT COUNT(*) total FROM tours")['total'] ?? 0;
$total_guides    = pdo_query_one("SELECT COUNT(*) total FROM guides")['total'] ?? 0;
$total_customers = pdo_query_one("SELECT COUNT(*) total FROM customers")['total'] ?? 0;
$total_bookings  = pdo_query_one("SELECT COUNT(*) total FROM bookings")['total'] ?? 0;

$total_revenue = 0;
foreach (pdo_query("SELECT total_price FROM bookings") as $r) {
    $total_revenue += $r['total_price'] ?? 0;
}

$labels = [];
$values = [];
for ($i = 5; $i >= 0; $i--) {
    $labels[] = date('m/Y', strtotime("-$i month"));
    $values[] = rand(20000000, 100000000);
}
?>

<div class="content-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success">📊 Dashboard</h3>
        
    </div>

    <div class="row g-4 mb-4">
        <?php
        $stats = [
            ['Tours', $total_tours, 'route', 'primary'],
            ['HDV', $total_guides, 'user-tie', 'info'],
            ['Khách', $total_customers, 'users', 'success'],
            ['Booking', $total_bookings, 'shopping-cart', 'warning'],
            ['Doanh thu', number_format($total_revenue).'đ', 'dollar-sign', 'danger'],
        ];
        foreach ($stats as [$label, $value, $icon, $color]): ?>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="stat-card text-center">
                <i class="fas fa-<?= $icon ?> text-<?= $color ?>"></i>
                <h4><?= $value ?></h4>
                <p><?= $label ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="card p-4 shadow-sm mb-4">
        <h5 class="fw-bold mb-3">📈 Doanh thu 6 tháng gần nhất</h5>
        <canvas id="revenueChart" height="120"></canvas>
    </div>

    <div class="alert alert-success text-center rounded-4 shadow-sm">
        👋 Chào mừng <strong><?= $_SESSION['user_name'] ?? 'bạn' ?></strong>, chúc bạn làm việc hiệu quả hôm nay!
    </div>
</div>

<style>
.content-wrapper {
    margin-left: 260px;
    padding: 30px;
}
.stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 4px 16px rgba(0,0,0,.08);
}
.stat-card i {
    font-size: 28px;
    margin-bottom: 10px;
}
.stat-card h4 {
    font-weight: bold;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            data: <?= json_encode($values) ?>,
            borderColor: '#10b981',
            backgroundColor: 'rgba(16,185,129,.2)',
            fill: true,
            tension: .4
        }]
    },
    options: { plugins:{legend:{display:false}} }
});
</script>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

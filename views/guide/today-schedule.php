<?php
// views/guide/today-schedule.php - Lịch làm việc hôm nay
$act = 'hdv-today';

ob_start();

$guide_id = $_SESSION['user_id'];
$today = date('Y-m-d'); // Ngày hôm nay (ví dụ: 2025-12-17)

$tours_today = pdo_query("
    SELECT d.*, t.name AS tour_name, t.price
    FROM departures d
    JOIN tours t ON d.tour_id = t.id
    WHERE d.guide_id = ? AND d.departure_date = ?
", $guide_id, $today);

$total_today = count($tours_today);
?>

<h4 class="mb-4 text-success fw-bold">
    <i class="fas fa-calendar-day"></i> Lịch làm việc hôm nay - <?= date('d/m/Y', strtotime($today)) ?>
</h4>

<?php if ($total_today > 0): ?>
<div class="row">
    <?php foreach ($tours_today as $tour): 
        $cust_count = pdo_query_value("
            SELECT COUNT(*) 
            FROM booking_customers bc
            JOIN bookings b ON bc.booking_id = b.id
            WHERE b.tour_id = ? AND b.start_date = ?
        ", $tour['tour_id'], $tour['departure_date']);
    ?>
    <div class="col-md-6 mb-4">
        <div class="table-card h-100">
            <h5 class="text-primary"><strong><?= htmlspecialchars($tour['tour_name']) ?></strong></h5>
            
            <!-- Bỏ phần mô tả vì table tours không có cột description -->
            <!-- Nếu sau này bạn thêm cột description thì bỏ comment dòng dưới -->
            <!-- <p><i class="fas fa-info-circle"></i> <strong>Mô tả:</strong> <?= htmlspecialchars($tour['description'] ?? 'Không có mô tả') ?></p> -->
            
            <p><i class="fas fa-users"></i> <strong>Số khách:</strong> 
                <span class="badge bg-primary fs-5"><?= $cust_count ?></span>
            </p>
            <p><i class="fas fa-money-bill"></i> <strong>Giá tour:</strong> 
                <?= number_format($tour['price'] ?? 0) ?>đ
            </p>
            
            <div class="mt-3">
                <a href="index.php?act=hdv-customers&departure_id=<?= $tour['id'] ?>" 
                   class="btn btn-success">
                    <i class="fas fa-users"></i> Xem danh sách & điểm danh khách
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="alert alert-warning text-center p-5 rounded-4 shadow">
    <i class="fas fa-calendar-times fa-3x mb-4"></i>
    <h4>Hôm nay bạn không có lịch dẫn tour</h4>
    <p class="lead">Hãy nghỉ ngơi hoặc chuẩn bị cho các tour sắp tới nhé!</p>
</div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require "views/guide/layout.php";
?>
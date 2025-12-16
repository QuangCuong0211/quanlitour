<?php
// views/guide/month-schedule.php - Lịch làm việc trong tháng
$act = 'hdv-month';

ob_start();

$guide_id = $_SESSION['user_id'];
$current_month = date('Y-m'); // Tháng hiện tại, ví dụ 2025-12

$tours_month = pdo_query("
    SELECT d.*, t.name AS tour_name, t.price
    FROM departures d
    JOIN tours t ON d.tour_id = t.id
    WHERE d.guide_id = ? 
      AND DATE_FORMAT(d.departure_date, '%Y-%m') = ?
    ORDER BY d.departure_date ASC
", $guide_id, $current_month);
?>

<h4 class="mb-4 text-success fw-bold"><i class="fas fa-calendar-alt"></i> Lịch làm việc tháng <?= date('m/Y') ?></h4>

<?php if (count($tours_month) > 0): ?>
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Ngày</th>
                    <th>Tên tour</th>
                    <th>Số khách</th>
                    <th>Giá tour</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tours_month as $tour): 
                    $cust = pdo_query_value("SELECT COUNT(*) FROM booking_customers bc JOIN bookings b ON bc.booking_id = b.id WHERE b.tour_id = ? AND b.start_date = ?", $tour['tour_id'], $tour['departure_date']);
                ?>
                <tr>
                    <td><strong><?= date('d/m/Y (l)', strtotime($tour['departure_date'])) ?></strong></td>
                    <td><?= htmlspecialchars($tour['tour_name']) ?></td>
                    <td><span class="badge bg-primary"><?= $cust ?></span></td>
                    <td><?= number_format($tour['price']) ?>đ</td>
                    <td>
                        <a href="index.php?act=hdv-customers&departure_id=<?= $tour['id'] ?>" class="btn btn-sm btn-outline-success">
                            <i class="fas fa-users"></i> Xem khách
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
<div class="alert alert-info text-center p-5 rounded-4 shadow">
    <i class="fas fa-calendar fa-3x mb-4"></i>
    <h4>Tháng này bạn chưa có lịch dẫn tour</h4>
    <p>Hệ thống sẽ cập nhật khi admin phân công lịch mới.</p>
</div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require "views/guide/layout.php";
?>
<?php
function flash($key) {
    if (!empty($_SESSION[$key])) {
        $color = $key === 'success' ? '#d4edda' : '#f8d7da';
        $border = $key === 'success' ? '#c3e6cb' : '#f5c6cb';
        $text = $key === 'success' ? '#155724' : '#721c24';

        echo "<div style='margin:0 auto 20px;padding:12px;border-radius:8px;border:1px solid $border;background:$color;color:$text;max-width:1200px;'>" . htmlspecialchars($_SESSION[$key]) . '</div>';
        unset($_SESSION[$key]);
    }
}

$statusLabels = [
    'pending' => 'Chờ điểm danh',
    'enroute' => 'Đang di chuyển',
    'present' => 'Có mặt',
    'absent' => 'Vắng mặt',
];

$summaryCounts = [];
foreach ($statusLabels as $key => $_) {
    $summaryCounts[$key] = isset($summary[$key]) ? (int)$summary[$key]['qty'] : 0;
}
$who = $_SESSION['user_name'] ?? 'Hệ thống';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Điểm danh Booking <?= htmlspecialchars($booking['booking_code']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f0f2f5; margin:0; font-family: Arial, sans-serif; }
        .sidebar {
            width: 220px;
            height: 100vh;
            background: #0f172a;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 10px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            box-shadow: 4px 0 12px rgba(15,23,42,0.45);
            z-index: 10;
        }
        .sidebar h2 {
            color: #fff;
            font-size: 18px;
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar a {
            color: #cbd5f5;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
        }
        .sidebar a:hover {
            background: #1d4ed8;
            color: #fff;
        }
        .sidebar a.active {
            background: #2563eb;
            color: #fff;
        }
        .content { margin-left: 220px; padding: 24px 32px 32px; }
        .page { max-width:1200px; margin:0 auto; padding:0; }
        .summary-grid { display:grid; gap:16px; grid-template-columns:repeat(auto-fit, minmax(170px, 1fr)); }
        .summary-card { border-radius:12px; background:#fff; padding:18px; box-shadow:0 30px 60px rgba(15,23,42,.08); }
        .summary-card strong { font-size:32px; }
        .summary-card span { font-size:14px; }
        .badge-status { font-size:0.85rem; }
    </style>
</head>
<body>
<div class="sidebar">
    <h2>Quản trị</h2>
    <a href="?act=admin">Dashboard</a>
    <a href="?act=tour-list">Quản lý Tour</a>
    <a href="?act=guide-list">Quản lý HDV</a>
    <a href="?act=category-list">Quản lý Danh mục</a>
    <a href="?act=customer-list">Khách hàng</a>
    <a href="?act=booking-list" class="active">Booking</a>
</div>
<div class="content">
    <div class="page">
    <?php flash('success'); flash('error'); ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4">Điểm danh Booking <?= htmlspecialchars($booking['booking_code']); ?></h1>
            <p class="text-muted">Khách hàng: <?= htmlspecialchars($booking['customer_name']); ?> • Ngày đi <?= htmlspecialchars($booking['start_date']); ?></p>
        </div>
        <div>
            <a href="?act=booking-list" class="btn btn-outline-secondary">Quay về Booking</a>
        </div>
    </div>

    <section class="summary-grid mb-4">
        <?php foreach ($statusLabels as $status => $label): ?>
            <div class="summary-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted"><?= $label; ?></span>
                    <span class="badge bg-primary text-white badge-status"><?= htmlspecialchars($summaryCounts[$status]); ?></span>
                </div>
                <strong><?= htmlspecialchars($summaryCounts[$status]); ?></strong>
                <p class="text-muted mb-0">ghi nhận</p>
            </div>
        <?php endforeach; ?>
    </section>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <strong>Danh sách điểm danh</strong>
                </div>
                <div class="card-body p-0">
                    <form method="POST" action="?act=checkin-bulk-save">
                        <input type="hidden" name="booking_id" value="<?= (int)$booking['id']; ?>">
                        <input type="hidden" name="checked_by" value="<?= htmlspecialchars($who); ?>">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Hành khách</th>
                                        <th>Phone</th>
                                        <th class="text-center">Có mặt</th>
                                        <th>Trạng thái</th>
                                        <th>Người thực hiện</th>
                                        <th>Thời gian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($checkins)): ?>
                                        <?php foreach ($checkins as $idx => $item): ?>
                                            <tr>
                                                <td><?= $idx + 1; ?></td>
                                                <td><?= htmlspecialchars($item['customer_name']); ?></td>
                                                <td><?= htmlspecialchars($item['customer_phone']); ?></td>
                                                <td class="text-center">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               name="present[]" value="<?= (int)$item['id']; ?>"
                                                               id="present-<?= (int)$item['id']; ?>"
                                                               <?= $item['status'] === 'present' ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="present-<?= (int)$item['id']; ?>"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info text-dark badge-status">
                                                        <?= htmlspecialchars($statusLabels[$item['status']] ?? $item['status']); ?>
                                                    </span>
                                                </td>
                                                <td><?= htmlspecialchars($item['checked_by']); ?></td>
                                                <td><?= htmlspecialchars($item['checkin_at']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Chưa có điểm danh nào</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if (!empty($checkins)): ?>
                            <div class="d-flex justify-content-end p-3">
                                <button type="submit" class="btn btn-success">Cập nhật tickbox</button>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <strong>Ghi điểm danh mới</strong>
                </div>
                <div class="card-body">
                    <form method="POST" action="?act=checkin-save">
                        <input type="hidden" name="booking_id" value="<?= (int)$booking['id']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Tên hành khách</label>
                            <input name="customer_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input name="customer_phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <?php foreach ($statusLabels as $status => $label): ?>
                                    <option value="<?= $status; ?>"><?= $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Người thực hiện</label>
                            <input name="checked_by" class="form-control" value="<?= htmlspecialchars($who); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ghi chú</label>
                            <textarea name="note" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Lưu điểm danh</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</body>
</html>

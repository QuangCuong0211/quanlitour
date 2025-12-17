<?php
function flash($key)
{
    if (!empty($_SESSION[$key])) {
        $color  = $key === 'success' ? '#d4edda' : '#f8d7da';
        $border = $key === 'success' ? '#c3e6cb' : '#f5c6cb';
        $text   = $key === 'success' ? '#155724' : '#721c24';

        echo "<div style='background:$color;color:$text;padding:15px;margin-bottom:20px;
                border-radius:8px;border:1px solid $border;max-width:1400px;margin:0 auto 20px;'>"
            . htmlspecialchars($_SESSION[$key]) .
            "</div>";
        unset($_SESSION[$key]);
    }
}
?>

<?php include_once __DIR__ . '/../layout/header.php'; ?>
<?php include_once __DIR__ . '/../layout/sidebar.php'; ?>

<div class="main-wrapper">
    <?php flash('success'); ?>
    <?php flash('error'); ?>

    <div class="page-card">
        <h2 class="mb-4">Danh sách Khách hàng</h2>

        <?php if (empty($customers)): ?>
            <div class="text-center text-muted py-5">
                Chưa có khách hàng nào từ booking
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tên khách</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th>Loại</th>
                            <th>Tour</th>
                            <th>Mã booking</th>
                            <th>Ngày đi</th>
                            <th>Ngày về</th>
                            <th>Điểm danh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $i => $c): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($c['name']) ?></td>
                                <td><?= htmlspecialchars($c['email']) ?></td>
                                <td><?= htmlspecialchars($c['phone']) ?></td>

                                <td>
                                    <span class="badge <?= $c['type'] === 'adult' ? 'bg-success' : 'bg-warning' ?>">
                                        <?= $c['type'] === 'adult' ? 'Người lớn' : 'Trẻ em' ?>
                                    </span>
                                </td>

                                <td><?= htmlspecialchars($c['tour_name'] ?? 'N/A') ?></td>

                                <td>
                                    <span class="badge bg-primary">
                                        <?= htmlspecialchars($c['booking_code']) ?>
                                    </span>
                                </td>

                                <td><?= htmlspecialchars($c['start_date']) ?></td>
                                <td><?= htmlspecialchars($c['end_date']) ?></td>

                                <td class="text-center">
                                    <?php if ($c['attended']): ?>
                                        <span class="badge bg-success">Đã điểm danh</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Chưa điểm danh</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

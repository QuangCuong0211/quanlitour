<?php
function flash($key)
{
    if (!empty($_SESSION[$key])) {
        $color = $key === 'success' ? '#d4edda' : '#f8d7da';
        $border = $key === 'success' ? '#c3e6cb' : '#f5c6cb';
        $text = $key === 'success' ? '#155724' : '#721c24';

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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Danh sách Khách hàng</h2>
        </div>

        <?php if (empty($customers)): ?>
            <div class="text-center text-muted py-5">Chưa có khách hàng nào từ booking.</div>
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
                            <th>Trạng thái</th>
                            <th class="text-center" style="width:180px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $index => $cust): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($cust['name']) ?></td>
                                <td><?= htmlspecialchars($cust['email']) ?></td>
                                <td><?= htmlspecialchars($cust['phone']) ?></td>
                                <td>
                                    <span class="badge <?= $cust['type'] === 'adult' ? 'bg-success' : 'bg-info' ?>">
                                        <?= $cust['type'] === 'adult' ? 'Người lớn' : 'Trẻ em' ?>
                                    </span>
                                </td>
                                <td>
                                    <?= htmlspecialchars($cust['tour_name'] ?? 'Chưa rõ') ?><br>
                                </td>
                                <td>
                                    <span class="badge bg-primary"><?= htmlspecialchars($cust['booking_code']) ?></span>
                                </td>
                                <td><?= htmlspecialchars($cust['start_date']) ?></td>
                                <td><?= htmlspecialchars($cust['end_date']) ?></td>
                                <td class="text-center">
                                    <?php if (!empty($cust['attended'])): ?>
                                        <span class="badge bg-success">Đã điểm danh</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Chưa điểm danh</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <a href="?act=customer-detail&id=<?= $cust['id'] ?>" class="btn btn-info btn-sm">Chi tiết</a>
                                    <a href="?act=customer-edit&id=<?= $cust['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                    <a href="?act=customer-delete&id=<?= $cust['id'] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Xóa khách hàng này khỏi booking?');">Xóa</a>
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
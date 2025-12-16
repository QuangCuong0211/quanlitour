<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1">Danh sách Booking</h3>
                    <div class="text-muted">Quản lý booking tour</div>
                </div>
                <a href="?act=booking-add" class="btn btn-success">
                    + Thêm Booking
                </a>
            </div>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>STT</th>
                            <th>Mã</th>
                            <th>Số khách</th>
                            <th>Tổng tiền</th>
                            <th>Ngày đi</th>
                            <th>Ngày về</th>
                            <th>Trạng thái</th>
                            <th width="160">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bookings)): ?>
                            <?php $i = 1; foreach ($bookings as $b): ?>
                                <tr>
                                    <td class="text-center"><?= $i++ ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">
                                            <?= htmlspecialchars($b['booking_code']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?= $b['adult'] + $b['child'] ?> khách
                                    </td>
                                    <td class="text-end text-danger fw-bold">
                                        <?= number_format($b['total_price']) ?> đ
                                    </td>
                                    <td class="text-center"><?= $b['start_date'] ?></td>
                                    <td class="text-center"><?= $b['end_date'] ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">
                                            <?= strtoupper($b['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="?act=booking-edit&id=<?= $b['id'] ?>"
                                           class="btn btn-warning btn-sm">Sửa</a>
                                        <a href="?act=booking-delete&id=<?= $b['id'] ?>"
                                           onclick="return confirm('Xóa booking này?')"
                                           class="btn btn-danger btn-sm">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Chưa có booking nào
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

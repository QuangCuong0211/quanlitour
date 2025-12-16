<?php
$errorMessage = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<?php include_once __DIR__ . '/../layout/header.php'; ?>
<?php include_once __DIR__ . '/../layout/sidebar.php'; ?>

<div class="main-wrapper">
    <?php if ($errorMessage): ?>
        <div style="background:#f8d7da;color:#721c24;padding:15px;margin-bottom:20px;
                    border-radius:8px;border:1px solid #f5c6cb;max-width:1200px;">
            <?= htmlspecialchars($errorMessage) ?>
        </div>
    <?php endif; ?>
    <div class="page-card">
        <h2 class="mb-4">Chỉnh sửa khách hàng</h2>

        <form method="POST" action="?act=customer-update" class="row g-3">
            <input type="hidden" name="id" value="<?= htmlspecialchars($customer['id']) ?>">

            <div class="col-md-6">
                <label class="form-label fw-semibold" for="name">Họ tên *</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($customer['name']) ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold" for="email">Email *</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold" for="phone">Số điện thoại *</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($customer['phone']) ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold" for="type">Loại khách *</label>
                <select class="form-select" id="type" name="type">
                    <option value="adult" <?= $customer['type'] === 'adult' ? 'selected' : '' ?>>Người lớn</option>
                    <option value="child" <?= $customer['type'] === 'child' ? 'selected' : '' ?>>Trẻ em</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Booking</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($customer['booking_code']) ?>" readonly>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Tour</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($customer['tour_name'] ?? 'Chưa rõ') ?>" readonly>
            </div>

            <div class="col-12 d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-success px-4">Lưu thay đổi</button>
                <a href="?act=customer-list" class="btn btn-secondary px-4">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

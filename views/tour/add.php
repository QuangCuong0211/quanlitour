<?php
// views/tour/add.php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1">Thêm tour mới</h3>
                    <div class="text-muted">Nhập thông tin tour du lịch</div>
                </div>
                <a href="?act=tour-list" class="btn btn-outline-secondary">
                    ← Danh sách tour
                </a>
            </div>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form action="?act=tour-save" method="post" class="row g-3">

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Mã tour</label>
                    <input type="text" name="tour_code" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Ngày đi</label>
                    <input type="date" name="departure_date" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Giá (VND)</label>
                    <input type="number" name="price" class="form-control" min="0" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1">Đang mở</option>
                        <option value="0">Tạm ngưng</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Tên tour</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Khách hàng</label>
                    <input type="text" name="customer" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Hướng dẫn viên</label>
                    <input type="text" name="guide" class="form-control">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Ghi chú</label>
                    <textarea name="note" class="form-control" rows="3"></textarea>
                </div>

                <div class="col-12 text-end mt-3">
                    <a href="?act=tour-list" class="btn btn-secondary me-2">Hủy</a>
                    <button class="btn btn-primary">Lưu tour</button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

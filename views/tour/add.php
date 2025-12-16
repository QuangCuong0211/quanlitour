<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1">Thêm tour mới</h3>
                    <div class="text-muted">Nhập thông tin tour</div>
                </div>
                <a href="?act=tour-list" class="btn btn-outline-secondary">
                    ← Danh sách tour
                </a>
            </div>

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
                    <label class="form-label fw-semibold">Giá</label>
                    <input type="number" name="price" class="form-control" required>
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
                    <label class="form-label fw-semibold">Hướng dẫn viên</label>
                    <select name="guide_id" class="form-select" required>
                        <option value="">-- Chọn HDV --</option>
                        <?php foreach ($guides as $g): ?>
                            <option value="<?= $g['id'] ?>">
                                <?= htmlspecialchars($g['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 text-end mt-3">
                    <button class="btn btn-primary">Lưu tour</button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

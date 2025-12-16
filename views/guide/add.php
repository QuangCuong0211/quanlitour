<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">

            <h3 class="mb-4">Thêm Hướng Dẫn Viên</h3>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="?act=guide-save" method="POST">

                <div class="mb-3">
                    <label class="form-label">Tên HDV <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                    <input type="text" name="sdt" class="form-control" placeholder="03xxxxxxxx" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ảnh (URL hoặc path)</label>
                    <input type="text" name="img" class="form-control" placeholder="uploads/hdv.jpg">
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1">Hoạt động</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Lưu</button>
                    <a href="?act=guide-list" class="btn btn-secondary">Quay lại</a>
                </div>

            </form>

        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

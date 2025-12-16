<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">

            <h3 class="mb-4">Thêm danh mục</h3>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="?act=category-save" method="POST">

                <div class="mb-3">
                    <label class="form-label">Tên danh mục *</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug *</label>
                    <input type="text" name="slug" class="form-control" required>
                    <small class="text-muted">VD: tour-mien-bac</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1">Hoạt động</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>

                <button class="btn btn-primary">Lưu</button>
                <a href="?act=category-list" class="btn btn-secondary">Quay lại</a>

            </form>

        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

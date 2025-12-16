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

<!-- 🔴 BẮT BUỘC enctype -->
<form action="?act=guide-save" method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label class="form-label">Tên HDV *</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email *</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">SĐT *</label>
        <input type="text" name="sdt" class="form-control" required>
    </div>

    <!-- 🔴 INPUT FILE -->
    <div class="mb-3">
        <label class="form-label">Ảnh</label>
        <input type="file" name="img" class="form-control" accept="image/*">
    </div>

    <div class="mb-3">
        <label class="form-label">Tour đang quản lý</label>
        <select name="tour_id" class="form-select">
            <option value="">-- Chưa phân tour --</option>
            <?php foreach ($tours as $t): ?>
                <option value="<?= $t['id'] ?>">
                    <?= htmlspecialchars($t['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Trạng thái</label>
        <select name="status" class="form-select">
            <option value="1">Hoạt động</option>
            <option value="0">Ẩn</option>
        </select>
    </div>

    <button class="btn btn-primary">Lưu</button>
    <a href="?act=guide-list" class="btn btn-secondary">Quay lại</a>

</form>

</div>
</div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

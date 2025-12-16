<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
<div class="container-fluid">
<div class="page-card">

<h3 class="mb-4">Thêm tour</h3>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<form action="?act=tour-save" method="POST">

    <div class="mb-3">
        <label class="form-label">Tên tour *</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Danh mục</label>
        <select name="category_id" class="form-select">
            <option value="">-- Chọn danh mục --</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>">
                    <?= htmlspecialchars($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Giá</label>
        <input type="number" name="price" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Trạng thái</label>
        <select name="status" class="form-select">
            <option value="1">Đang mở</option>
            <option value="0">Tạm ngưng</option>
        </select>
    </div>

    <button class="btn btn-primary">Lưu</button>
    <a href="?act=tour-list" class="btn btn-secondary">Quay lại</a>

</form>

</div>
</div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

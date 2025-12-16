<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
<div class="container-fluid">
<div class="page-card">

<h3 class="mb-4">Cập nhật tour</h3>

<form action="?act=tour-update" method="POST">
    <input type="hidden" name="id" value="<?= $tour['id'] ?>">

    <div class="mb-3">
        <label class="form-label">Tên tour *</label>
        <input type="text" name="name" class="form-control"
               value="<?= htmlspecialchars($tour['name']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Danh mục</label>
        <select name="category_id" class="form-select">
            <option value="">-- Chọn danh mục --</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>"
                    <?= $tour['category_id'] == $c['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Giá</label>
        <input type="number" name="price" class="form-control"
               value="<?= $tour['price'] ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Trạng thái</label>
        <select name="status" class="form-select">
            <option value="1" <?= $tour['status'] == 1 ? 'selected' : '' ?>>Đang mở</option>
            <option value="0" <?= $tour['status'] == 0 ? 'selected' : '' ?>>Tạm ngưng</option>
        </select>
    </div>

    <button class="btn btn-primary">Cập nhật</button>
    <a href="?act=tour-list" class="btn btn-secondary">Quay lại</a>
</form>

</div>
</div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">

            <h3 class="mb-4">Cập nhật danh mục</h3>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="?act=category-update" method="POST">
                <input type="hidden" name="id" value="<?= $category['id'] ?>">

                <div class="mb-3">
                    <label class="form-label">Tên danh mục *</label>
                    <input type="text" name="name" class="form-control"
                           value="<?= htmlspecialchars($category['name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($category['description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug *</label>
                    <input type="text" name="slug" class="form-control"
                           value="<?= htmlspecialchars($category['slug']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1" <?= $category['status'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="0" <?= $category['status'] == 0 ? 'selected' : '' ?>>Ẩn</option>
                    </select>
                </div>

                <button class="btn btn-primary">Cập nhật</button>
                <a href="?act=category-list" class="btn btn-secondary">Quay lại</a>
            </form>

        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

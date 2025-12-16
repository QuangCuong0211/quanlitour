<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">

            <h3 class="mb-4">Cập nhật Hướng Dẫn Viên</h3>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="?act=guide-update" method="POST">

                <input type="hidden" name="id" value="<?= $guide['id'] ?>">

                <div class="mb-3">
                    <label class="form-label">Tên HDV <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control"
                           value="<?= htmlspecialchars($guide['name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control"
                           value="<?= htmlspecialchars($guide['email']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                    <input type="text" name="sdt" class="form-control"
                           value="<?= htmlspecialchars($guide['sdt']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ảnh (URL hoặc path)</label>
                    <input type="text" name="img" class="form-control"
                           value="<?= htmlspecialchars($guide['img']) ?>">
                    <?php if (!empty($guide['img'])): ?>
                        <img src="<?= $guide['img'] ?>" width="80" class="mt-2">
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1" <?= $guide['status'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="0" <?= $guide['status'] == 0 ? 'selected' : '' ?>>Ẩn</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Cập nhật</button>
                    <a href="?act=guide-list" class="btn btn-secondary">Quay lại</a>
                </div>

            </form>

        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

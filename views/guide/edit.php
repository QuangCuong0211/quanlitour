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

<form action="?act=guide-update" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $guide['id'] ?>">

    <div class="mb-3">
        <label class="form-label">Tên HDV *</label>
        <input type="text" name="name" class="form-control"
               value="<?= htmlspecialchars($guide['name']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email *</label>
        <input type="email" name="email" class="form-control"
               value="<?= htmlspecialchars($guide['email']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">SĐT *</label>
        <input type="text" name="sdt" class="form-control"
               value="<?= htmlspecialchars($guide['sdt']) ?>" required>
    </div>

    <!-- ẢNH HIỆN TẠI -->
    <div class="mb-3">
        <label class="form-label">Ảnh hiện tại</label><br>
        <?php if (!empty($guide['img'])): ?>
            <img src="uploads/guides/<?= $guide['img'] ?>" 
                 style="max-width:120px; border-radius:6px;">
        <?php else: ?>
            <span class="text-muted">Chưa có ảnh</span>
        <?php endif; ?>
    </div>

    <!-- UPLOAD ẢNH MỚI -->
    <div class="mb-3">
        <label class="form-label">Đổi ảnh (nếu có)</label>
        <input type="file" name="img" class="form-control" accept="image/*"
               onchange="previewImage(this)">
        <img id="preview" style="display:none; margin-top:10px; max-width:120px;">
    </div>

    <div class="mb-3">
        <label class="form-label">Tour đang quản lý</label>
        <select name="tour_id" class="form-select">
            <option value="">-- Chưa phân tour --</option>
            <?php foreach ($tours as $t): ?>
                <option value="<?= $t['id'] ?>"
                    <?= ($guide['tour_id'] == $t['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Trạng thái</label>
        <select name="status" class="form-select">
            <option value="1" <?= $guide['status']==1 ? 'selected' : '' ?>>Hoạt động</option>
            <option value="0" <?= $guide['status']==0 ? 'selected' : '' ?>>Ẩn</option>
        </select>
    </div>

    <button class="btn btn-primary">Cập nhật</button>
    <a href="?act=guide-list" class="btn btn-secondary">Quay lại</a>

</form>

</div>
</div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('preview');
            img.src = e.target.result;
            img.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

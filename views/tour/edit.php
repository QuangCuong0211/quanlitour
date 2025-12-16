<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Cập nhật tour</h3>
                <a href="?act=tour-list" class="btn btn-outline-secondary">
                    ← Quay lại
                </a>
            </div>

            <form action="?act=tour-update" method="post" class="row g-3">
                <input type="hidden" name="id" value="<?= $tour['id'] ?>">

                <div class="col-md-3">
                    <label class="form-label">Mã tour</label>
                    <input type="text" name="tour_code" class="form-control"
                           value="<?= htmlspecialchars($tour['tour_code']) ?>" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Ngày đi</label>
                    <input type="date" name="departure_date" class="form-control"
                           value="<?= $tour['departure_date'] ?>" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Giá</label>
                    <input type="number" name="price" class="form-control"
                           value="<?= $tour['price'] ?>" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1" <?= $tour['status'] == 1 ? 'selected' : '' ?>>Đang mở</option>
                        <option value="0" <?= $tour['status'] == 0 ? 'selected' : '' ?>>Tạm ngưng</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Tên tour</label>
                    <input type="text" name="name" class="form-control"
                           value="<?= htmlspecialchars($tour['name']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Hướng dẫn viên</label>
                    <select name="guide_id" class="form-select" required>
                        <?php foreach ($guides as $g): ?>
                            <option value="<?= $g['id'] ?>"
                                <?= $tour['guide_id'] == $g['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($g['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 text-end mt-3">
                    <button class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

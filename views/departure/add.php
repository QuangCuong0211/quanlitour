<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">
        <h2>Thêm Lịch Khởi Hành Mới</h2>

        <form method="POST" action="?act=departure-save">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="tour_id">Tour *</label>
                    <select id="tour_id" name="tour_id" required>
                        <option value="">-- Chọn Tour --</option>
                        <?php foreach ($tours as $tour): ?>
                        <option value="<?php echo $tour['id']; ?>"><?php echo htmlspecialchars($tour['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="guide_id">Hướng Dẫn Viên *</label>
                    <select id="guide_id" name="guide_id" required>
                        <option value="">-- Chọn HDV --</option>
                        <?php foreach ($guides as $guide): ?>
                        <option value="<?php echo $guide['id']; ?>"><?php echo htmlspecialchars($guide['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="departure_date">Ngày Khởi Hành *</label>
                    <input type="date" id="departure_date" name="departure_date" required>
                </div>

                <div class="form-group">
                    <label for="return_date">Ngày Kết Thúc *</label>
                    <input type="date" id="return_date" name="return_date" required>
                </div>

                <div class="form-group">
                    <label for="seats_available">Số Ghế Có Sẵn *</label>
                    <input type="number" id="seats_available" name="seats_available" required min="1" value="30">
                </div>

                <div class="form-group">
                    <label for="status">Trạng Thái</label>
                    <select id="status" name="status">
                        <option value="active" selected>Hoạt động</option>
                        <option value="inactive">Không hoạt động</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Lưu Lịch Khởi Hành</button>
                <a href="?act=departure-list" class="btn btn-secondary" style="text-decoration: none; display: inline-block;">Hủy</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>

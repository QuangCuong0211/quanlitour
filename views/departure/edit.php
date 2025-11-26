<?php
if (isset($_SESSION['error'])) {
    echo '<div style="background: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #f5c6cb;">' . htmlspecialchars($_SESSION['error']) . '</div>';
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Lịch Khởi Hành</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        .sidebar {
            width: 220px;
            height: 100vh;
            background: #1E293B;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            overflow-y: auto;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            margin-top: 0;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #fff;
            text-decoration: none;
            border-left: 3px solid transparent;
        }
        .sidebar a:hover {
            background: #334155;
            border-left-color: #10b981;
        }
        .sidebar a.active {
            background: #334155;
            border-left-color: #10b981;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .card h2 {
            margin-top: 0;
            color: #1e293b;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #1e293b;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 5px rgba(16, 185, 129, 0.3);
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-primary {
            background: #10b981;
            color: #fff;
        }

        .btn-primary:hover {
            background: #059669;
        }

        .btn-secondary {
            background: #6b7280;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin</h2>
    <a href="?act=admin">Dashboard</a>
    <a href="?act=tour-list">Quản lý Tour</a>
    <a href="?act=category-list">Quản lý Danh Mục</a>
    <a href="?act=departure-list" class="active">Lịch Khởi Hành</a>
    <a href="?act=customer-list">Khách Hàng</a>
    <a href="?act=booking-list">Quản lý Booking</a>
    <a href="#">Báo cáo</a>
</div>

<div class="content">
    <div class="card">
        <h2>Chỉnh Sửa Lịch Khởi Hành</h2>

        <form method="POST" action="?act=departure-update">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($departure['id']); ?>">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="tour_id">Tour *</label>
                    <select id="tour_id" name="tour_id" required>
                        <option value="">-- Chọn Tour --</option>
                        <?php foreach ($tours as $tour): ?>
                        <option value="<?php echo $tour['id']; ?>" <?php echo $tour['id'] == $departure['tour_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($tour['name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="guide_id">Hướng Dẫn Viên *</label>
                    <select id="guide_id" name="guide_id" required>
                        <option value="">-- Chọn HDV --</option>
                        <?php foreach ($guides as $guide): ?>
                        <option value="<?php echo $guide['id']; ?>" <?php echo $guide['id'] == $departure['guide_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($guide['name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="departure_date">Ngày Khởi Hành *</label>
                    <input type="date" id="departure_date" name="departure_date" required value="<?php echo $departure['departure_date']; ?>">
                </div>

                <div class="form-group">
                    <label for="return_date">Ngày Kết Thúc *</label>
                    <input type="date" id="return_date" name="return_date" required value="<?php echo $departure['return_date']; ?>">
                </div>

                <div class="form-group">
                    <label for="seats_available">Số Ghế Có Sẵn *</label>
                    <input type="number" id="seats_available" name="seats_available" required min="1" value="<?php echo $departure['seats_available']; ?>">
                </div>

                <div class="form-group">
                    <label for="status">Trạng Thái</label>
                    <select id="status" name="status">
                        <option value="active" <?php echo $departure['status'] == 'active' ? 'selected' : ''; ?>>Hoạt động</option>
                        <option value="inactive" <?php echo $departure['status'] == 'inactive' ? 'selected' : ''; ?>>Không hoạt động</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Cập Nhật Lịch Khởi Hành</button>
                <a href="?act=departure-list" class="btn btn-secondary" style="text-decoration: none; display: inline-block;">Hủy</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>

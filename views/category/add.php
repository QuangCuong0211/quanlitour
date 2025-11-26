<?php
// Hiển thị thông báo flash message
if (isset($_SESSION['success'])) {
    echo '<div style="background: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #c3e6cb;">' . htmlspecialchars($_SESSION['success']) . '</div>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo '<div style="background: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #f5c6cb;">' . htmlspecialchars($_SESSION['error']) . '</div>';
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Danh Mục</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        /* SIDEBAR */
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

        /* MAIN CONTENT */
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

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
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

        .form-hint {
            font-size: 12px;
            color: #6b7280;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin</h2>
    <a href="?act=admin">Dashboard</a>
    <a href="?act=tour-list">Quản lý Tour</a>
    <a href="?act=category-list" class="active">Quản lý Danh Mục</a>
    <a href="#">Quản lý Khách hàng</a>
    <a href="?act=booking-list">Quản lý Booking</a>
    <a href="#">Báo cáo</a>
</div>

<!-- MAIN CONTENT -->
<div class="content">
    <div class="card">
        <h2>Thêm Danh Mục Mới</h2>

        <form method="POST" action="?act=category-save">
            <div class="form-group">
                <label for="name">Tên Danh Mục *</label>
                <input type="text" id="name" name="name" required placeholder="VD: Tour Miền Bắc">
            </div>

            <div class="form-group">
                <label for="description">Mô Tả</label>
                <textarea id="description" name="description" placeholder="Nhập mô tả chi tiết về danh mục..."></textarea>
            </div>

            <div class="form-group">
                <label for="slug">Slug (URL-friendly) *</label>
                <input type="text" id="slug" name="slug" required placeholder="VD: tour-mien-bac">
                <div class="form-hint">Sử dụng chữ thường, dấu gạch nối, không dấu</div>
            </div>

            <div class="form-group">
                <label for="status">Trạng Thái</label>
                <select id="status" name="status">
                    <option value="1" selected>Hoạt động</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Lưu Danh Mục</button>
                <a href="?act=category-list" class="btn btn-secondary" style="text-decoration: none; display: inline-block;">Hủy</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>

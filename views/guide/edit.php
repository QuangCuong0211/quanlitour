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
    <title>Edit Guide</title>
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
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
            min-height: 80px;
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
        <a href="?act=guide-list">Quản lý HDV</a>
        <a href="?act=category-list">Quản lý Danh Mục</a>
        <a href="?act=customer-list" class="active">Khách Hàng</a>
        <a href="?act=booking-list">Quản lý Booking</a>
    </div>

    <div class="content">
        <div class="card">
            <h2>Chỉnh Sửa HDV</h2>

            <form method="POST" action="?act=guide-update">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($guide['id']); ?>">

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="name">Tên hdv *</label>
                        <input type="text" id="name" name="name" 
                            value="<?php echo htmlspecialchars($guide['name']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" 
                            value="<?php echo htmlspecialchars($guide['email']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="sdt">Số Điện Thoại *</label>
                        <input type="text" id="sdt" name="sdt" 
                            value="<?php echo htmlspecialchars($guide['sdt']); ?>">
                    </div>
                   
                    <div class="form-group">
                        <label for="img">Ảnh *</label>

                        <!-- Hiển thị ảnh hiện tại -->
                        <?php if (!empty($gui['img'])): ?>
                            <br>
                            <img src="/uploads/<?php echo htmlspecialchars($gui['img']); ?>" width="120"
                                style="border-radius:8px; object-fit: cover;">
                            <br><br>
                        <?php endif; ?>

                        <!-- Input để chọn ảnh mới -->
                        <input type="file" id="img" name="img">
                    </div>
                    <div class="form-group">
                        <label for="exp">Kinh Nghiệm *</label>
                        <input type="text" id="exp" name="exp" 
                            value="<?php echo htmlspecialchars($guide['exp']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="language">Ngôn Ngữ *</label>
                        <textarea id="language" name="language"
                            ><?php echo htmlspecialchars($guide['language']); ?></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Cập Nhật HDV</button>
                        <a href="?act=guide-list" class="btn btn-secondary"
                            style="text-decoration: none; display: inline-block;">Hủy</a>
                    </div>
            </form>
        </div>
    </div>

</body>

</html>
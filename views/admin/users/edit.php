<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Tài Khoản</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
        }
        
        .header h2 {
            color: #333;
        }
        
        .form-section {
            margin-bottom: 30px;
        }
        
        .form-section h3 {
            color: #555;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            font-size: 16px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        
        .form-group input[readonly] {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }
        
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-submit {
            background-color: #28a745;
            color: white;
            width: 100%;
        }
        
        .btn-submit:hover {
            background-color: #218838;
        }
        
        .btn-change-pass {
            background-color: #17a2b8;
            color: white;
            width: 100%;
        }
        
        .btn-change-pass:hover {
            background-color: #138496;
        }
        
        .btn-back {
            background-color: #6c757d;
            color: white;
            margin-right: 10px;
        }
        
        .btn-back:hover {
            background-color: #5a6268;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert ul {
            margin-left: 20px;
            margin-top: 5px;
        }
        
        .alert li {
            margin-bottom: 5px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }
        
        .modal.show {
            display: block;
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 400px;
            border-radius: 10px;
        }
        
        .modal-close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .modal-close:hover {
            color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Chỉnh Sửa Tài Khoản</h2>
        </div>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        
        <!-- Form Chỉnh Sửa Thông Tin Cơ Bản -->
        <div class="form-section">
            <h3>Thông Tin Cơ Bản</h3>
            <form method="POST" action="?act=user-update">
                <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                
                <div class="form-group">
                    <label for="name">Tên <span style="color: red;">*</span></label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email <span style="color: red;">*</span></label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Số Điện Thoại <span style="color: red;">*</span></label>
                    <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="role">Vai Trò <span style="color: red;">*</span></label>
                        <select id="role" name="role" required>
                            <option value="hdv" <?= $user['role'] === 'hdv' ? 'selected' : '' ?>>Hướng Dẫn Viên (HDV)</option>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Trạng Thái <span style="color: red;">*</span></label>
                        <select id="status" name="status" required>
                            <option value="1" <?= $user['status'] == 1 ? 'selected' : '' ?>>Hoạt Động</option>
                            <option value="0" <?= $user['status'] == 0 ? 'selected' : '' ?>>Khóa</option>
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-submit">Cập Nhật Thông Tin</button>
            </form>
        </div>
        
        <!-- Form Đổi Mật Khẩu -->
        <div class="form-section">
            <h3>Đổi Mật Khẩu</h3>
            <form method="POST" action="?act=user-change-password">
                <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                
                <div class="form-group">
                    <label for="current_password">Mật Khẩu Hiện Tại <span style="color: red;">*</span></label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                
                <div class="form-group">
                    <label for="new_password">Mật Khẩu Mới <span style="color: red;">*</span></label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Xác Nhận Mật Khẩu Mới <span style="color: red;">*</span></label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" class="btn btn-change-pass">Cập Nhật Mật Khẩu</button>
            </form>
        </div>
        
        <div class="button-group">
            <a href="?act=user-list" class="btn btn-back">← Quay Lại</a>
        </div>
    </div>
</body>
</html>

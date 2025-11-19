<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Khách Hàng</title>
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
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
            font-family: inherit;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Thêm Khách Hàng Mới</h2>
        </div>
        
        <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
            <div class="alert">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        
        <form method="POST" action="?act=customer-save">
            <div class="form-group">
                <label for="name">Tên Khách Hàng <span style="color: red;">*</span></label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email <span style="color: red;">*</span></label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Số Điện Thoại <span style="color: red;">*</span></label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="address">Địa Chỉ <span style="color: red;">*</span></label>
                <textarea id="address" name="address" required></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="city">Thành Phố <span style="color: red;">*</span></label>
                    <input type="text" id="city" name="city" required>
                </div>
                
                <div class="form-group">
                    <label for="identity_number">CMND/CCCD</label>
                    <input type="text" id="identity_number" name="identity_number">
                </div>
            </div>
            
            <div class="form-group">
                <label for="status">Trạng Thái <span style="color: red;">*</span></label>
                <select id="status" name="status" required>
                    <option value="1">Hoạt Động</option>
                    <option value="0">Khóa</option>
                </select>
            </div>
            
            <div class="button-group">
                <a href="?act=customer-list" class="btn btn-back">← Quay Lại</a>
                <button type="submit" class="btn btn-submit">Thêm Khách Hàng</button>
            </div>
        </form>
    </div>
</body>
</html>

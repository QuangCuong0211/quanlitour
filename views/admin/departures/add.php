<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Lịch Khởi Hành</title>
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
            <h2>Thêm Lịch Khởi Hành Mới</h2>
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
        
        <form method="POST" action="?act=departure-save">
            <div class="form-group">
                <label for="tour_id">Tour <span style="color: red;">*</span></label>
                <select id="tour_id" name="tour_id" required>
                    <option value="">-- Chọn Tour --</option>
                    <?php foreach ($tours as $tour): ?>
                        <option value="<?= htmlspecialchars($tour['id']) ?>">
                            <?= htmlspecialchars($tour['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="departure_date">Ngày Khởi Hành <span style="color: red;">*</span></label>
                    <input type="date" id="departure_date" name="departure_date" required>
                </div>
                
                <div class="form-group">
                    <label for="return_date">Ngày Kết Thúc <span style="color: red;">*</span></label>
                    <input type="date" id="return_date" name="return_date" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="guide_id">Hướng Dẫn Viên <span style="color: red;">*</span></label>
                <select id="guide_id" name="guide_id" required>
                    <option value="">-- Chọn Hướng Dẫn Viên --</option>
                    <?php foreach ($guides as $guide): ?>
                        <option value="<?= htmlspecialchars($guide['id']) ?>">
                            <?= htmlspecialchars($guide['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="seats_available">Số Ghế <span style="color: red;">*</span></label>
                    <input type="number" id="seats_available" name="seats_available" min="1" required>
                </div>
                
                <div class="form-group">
                    <label for="status">Trạng Thái <span style="color: red;">*</span></label>
                    <select id="status" name="status" required>
                        <option value="active">Hoạt Động</option>
                        <option value="inactive">Khóa</option>
                    </select>
                </div>
            </div>
            
            <div class="button-group">
                <a href="?act=departure-list" class="btn btn-back">← Quay Lại</a>
                <button type="submit" class="btn btn-submit">Thêm Lịch Khởi Hành</button>
            </div>
        </form>
    </div>
</body>
</html>

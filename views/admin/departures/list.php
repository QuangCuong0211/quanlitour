<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Lịch Khởi Hành</title>
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
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
        }
        
        .header h2 {
            color: #333;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-add {
            background-color: #28a745;
            color: white;
        }
        
        .btn-add:hover {
            background-color: #218838;
        }
        
        .btn-edit {
            background-color: #007bff;
            color: white;
            padding: 8px 15px;
            font-size: 13px;
        }
        
        .btn-edit:hover {
            background-color: #0056b3;
        }
        
        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 8px 15px;
            font-size: 13px;
        }
        
        .btn-delete:hover {
            background-color: #c82333;
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
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table th {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
        }
        
        table td {
            padding: 12px 15px;
            border-bottom: 1px solid #dee2e6;
        }
        
        table tr:hover {
            background-color: #f9f9f9;
        }
        
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-active {
            background-color: #28a745;
            color: white;
        }
        
        .badge-inactive {
            background-color: #dc3545;
            color: white;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Quản Lý Lịch Khởi Hành</h2>
            <a href="?act=departure-add" class="btn btn-add">+ Thêm Lịch Khởi Hành</a>
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
        
        <?php if (!empty($departures)): ?>
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 15%;">Tour</th>
                        <th style="width: 12%;">Ngày Khởi Hành</th>
                        <th style="width: 12%;">Ngày Kết Thúc</th>
                        <th style="width: 12%;">Hướng Dẫn Viên</th>
                        <th style="width: 10%;">Ghế</th>
                        <th style="width: 10%;">Trạng Thái</th>
                        <th style="width: 14%;">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($departures as $departure): ?>
                        <tr>
                            <td><?= htmlspecialchars($departure['id']) ?></td>
                            <td><?= htmlspecialchars($departure['tour_name'] ?? 'N/A') ?></td>
                            <td><?= date('d/m/Y', strtotime($departure['departure_date'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($departure['return_date'])) ?></td>
                            <td><?= htmlspecialchars($departure['guide_id']) ?></td>
                            <td><?= htmlspecialchars($departure['seats_available']) ?></td>
                            <td>
                                <?php if ($departure['status'] === 'active'): ?>
                                    <span class="badge badge-active">Hoạt động</span>
                                <?php else: ?>
                                    <span class="badge badge-inactive">Khóa</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="?act=departure-edit&id=<?= htmlspecialchars($departure['id']) ?>" class="btn btn-edit">Sửa</a>
                                    <a href="?act=departure-delete&id=<?= htmlspecialchars($departure['id']) ?>" class="btn btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">Không có lịch khởi hành nào</div>
        <?php endif; ?>
    </div>
</body>
</html>

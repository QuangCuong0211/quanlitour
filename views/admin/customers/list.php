<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Khách Hàng</title>
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
        
        .header-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .search-box {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 250px;
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
        
        .btn-search {
            background-color: #007bff;
            color: white;
        }
        
        .btn-search:hover {
            background-color: #0056b3;
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
            <h2>Quản Lý Khách Hàng</h2>
            <div class="header-actions">
                <form method="GET" style="display: flex; gap: 10px;">
                    <input type="hidden" name="act" value="customer-list">
                    <input type="text" name="search" class="search-box" placeholder="Tìm kiếm theo tên, email, số điện thoại..." value="<?= htmlspecialchars($search ?? '') ?>">
                    <button type="submit" class="btn btn-search">Tìm Kiếm</button>
                </form>
                <a href="?act=customer-add" class="btn btn-add">+ Thêm Khách Hàng</a>
            </div>
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
        
        <?php if (!empty($customers)): ?>
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 15%;">Tên</th>
                        <th style="width: 15%;">Email</th>
                        <th style="width: 12%;">Số Điện Thoại</th>
                        <th style="width: 15%;">Thành Phố</th>
                        <th style="width: 10%;">CMND</th>
                        <th style="width: 10%;">Trạng Thái</th>
                        <th style="width: 12%;">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?= htmlspecialchars($customer['id']) ?></td>
                            <td><?= htmlspecialchars($customer['name']) ?></td>
                            <td><?= htmlspecialchars($customer['email']) ?></td>
                            <td><?= htmlspecialchars($customer['phone']) ?></td>
                            <td><?= htmlspecialchars($customer['city']) ?></td>
                            <td><?= htmlspecialchars($customer['identity_number'] ?? 'N/A') ?></td>
                            <td>
                                <?php if ($customer['status'] == 1): ?>
                                    <span class="badge badge-active">Hoạt động</span>
                                <?php else: ?>
                                    <span class="badge badge-inactive">Khóa</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="?act=customer-edit&id=<?= htmlspecialchars($customer['id']) ?>" class="btn btn-edit">Sửa</a>
                                    <a href="?act=customer-delete&id=<?= htmlspecialchars($customer['id']) ?>" class="btn btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa khách hàng này?')">Xóa</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">Không có khách hàng nào</div>
        <?php endif; ?>
    </div>
</body>
</html>

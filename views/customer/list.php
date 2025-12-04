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
    <title>Quản lý Khách Hàng</title>
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

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #10b981;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn:hover {
            background: #059669;
        }

        .btn-danger {
            background: #ef4444;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-edit {
            background: #f59e0b;
        }

        .btn-edit:hover {
            background: #d97706;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        table th {
            background: #1e293b;
            color: #fff;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        table tr:hover {
            background: #f9fafb;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .actions a {
            display: inline-block;
            padding: 8px 15px;
            font-size: 13px;
        }

        .status {
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 13px;
            font-weight: bold;
        }

        .status.active {
            background: #d1fae5;
            color: #065f46;
        }

        .status.inactive {
            background: #fee2e2;
            color: #7f1d1d;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #6b7280;
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
        <a href="?act=departure-list">Lịch Khởi Hành</a>
        <a href="?act=customer-list" class="active">Khách Hàng</a>
        <a href="?act=booking-list">Quản lý Booking</a>
        <a href="#">Báo cáo</a>
    </div>

    <div class="content">
        <div class="card">
            <h2>Danh Sách Khách Hàng</h2>

            <a href="?act=customer-add" class="btn">+ Thêm Khách Hàng</a>

            <br><br>

            <?php if (empty($customers)): ?>
                <div class="empty">
                    <p>Chưa có khách hàng nào. <a href="?act=customer-add">Thêm khách hàng mới</a></p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 8%;">ID</th>
                            <th style="width: 15%;">Tên</th>
                            <th style="width: 18%;">Email</th>
                            <th style="width: 12%;">Điện Thoại</th>
                            <th style="width: 15%;">Thành Phố</th>
                            <th style="width: 10%;">Trạng Thái</th>
                            <th style="width: 18%;">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $cust): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cust['id']); ?></td>
                                <td><?php echo htmlspecialchars($cust['name']); ?></td>
                                <td><?php echo htmlspecialchars($cust['email']); ?></td>
                                <td><?php echo htmlspecialchars($cust['phone']); ?></td>
                                <td><?php echo htmlspecialchars($cust['city']); ?></td>
                                <td>
                                    <span class="status <?php echo $cust['status'] == 1 ? 'active' : 'inactive'; ?>">
                                        <?php echo $cust['status'] == 1 ? 'Hoạt động' : 'Khóa'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="?act=customer-edit&id=<?php echo $cust['id']; ?>" class="btn btn-edit">Sửa</a>
                                        <a href="?act=customer-delete&id=<?php echo $cust['id']; ?>" class="btn btn-danger"
                                            onclick="return confirm('Bạn chắc chắn muốn xóa?');">Xóa</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>
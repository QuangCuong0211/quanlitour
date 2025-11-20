<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
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
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #fff;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #334155;
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

        .card h3 {
            margin-top: 0;
            color: #1e293b;
        }

        .stats {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .stat-box {
            flex: 1;
            min-width: 200px;
            background: #10b981;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .stat-box h2 {
            margin: 0;
            font-size: 28px;
        }

        .stat-box p {
            margin: 5px 0 0 0;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin</h2>
    <a href="?act=admin">Dashboard</a>
    <a href="?act=tour-list">Quản lý Tour</a>

    <a href="#">Quản lý Khách hàng</a>
    <a href="?act=booking-list">Quản lý Booking</a>
    <a href="#">Báo cáo</a>
</div>

<!-- MAIN CONTENT -->
<div class="content">
    <h1>Dashboard</h1>

    <!-- STATISTICS -->
    <div class="stats">
        <div class="stat-box">
            <h2>15</h2>
            <p>Tours</p>
        </div>
        <div class="stat-box">
            <h2>120</h2>
            <p>Khách hàng</p>
        </div>
        <div class="stat-box">
            <h2>45</h2>
            <p>Đơn đặt tour</p>
        </div>
        <div class="stat-box">
            <h2>5</h2>
            <p>Báo cáo mới</p>
        </div>
    </div>

    <!-- WELCOME CARD -->
    <div class="card">
        <h3>Chào mừng đến trang quản trị!</h3>
        <p>Tại đây bạn có thể quản lý tour, khách hàng, đơn đặt tour và xem báo cáo thống kê.</p>
    </div>
</div>

</body>
</html>

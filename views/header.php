<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? $title : 'Quản trị' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8fafc; margin:0; font-family: Arial, sans-serif; }
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
            z-index: 1020;
        }
        .sidebar h2 { text-align: center; margin-bottom: 30px; }
        .sidebar a { display:block; padding:12px 20px; color:#fff; text-decoration:none; }
        .sidebar a:hover { background:#334155; }

        /* MAIN CONTENT */
        .content { margin-left: 220px; padding: 20px; }
        .main-container { margin-top: 20px; }
    </style>
</head>
<body>
<div class="sidebar">
    <h2>Admin</h2>
    <a href="?act=admin">Dashboard</a>
    <a href="?act=tour-list">Quản lý Tour</a>
    <a href="?act=user-list">Quản lý Tài khoản</a>
    <a href="#">Quản lý Khách hàng</a>
    <a href="#">Quản lý Booking</a>
    <a href="#">Báo cáo</a>
</div>

<div class="content">
    <div class="container main-container">

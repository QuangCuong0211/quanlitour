<?php
// File: views/users/admin.php (hoặc tên file dashboard của bạn)
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Quản lý Tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f6f9; }
        .sidebar {
            width: 240px;
            background: #1e293b;
            color: #fff;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            padding-top: 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar h3 { text-align: center; margin-bottom: 40px; color: #fff; }
        .sidebar a {
            color: #cbd5e1;
            padding: 14px 25px;
            display: block;
            text-decoration: none;
            border-left: 4px solid transparent;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #334155;
            color: white;
            border-left-color: #10b981;
        }
        .main-content { margin-left: 240px; padding: 20px; }
        .top-bar {
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(16,185,129,0.3);
        }
        .stat-card h2 { margin: 0; font-size: 2.5rem; font-weight: bold; }
        .welcome-card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h3>Admin</h3>
    <a href="?act=admin" class="active"><i class="fas fa-home me-2"></i>Dashboard</a>
    <a href="?act=tour-list"><i class="fas fa-map-marked-alt me-2"></i>Quản lý Tour</a>
    <a href="?act=guide-list"><i class="fas fa-user-tie me-2"></i>Quản lý HDV</a>
    <a href="?act=booking-list"><i class="fas fa-calendar-check me-2"></i>Quản lý Booking</a>
    <a href="?act=category-list"><i class="fas fa-tags me-2"></i>Danh mục</a>
    <a href="?act=customer-list"><i class="fas fa-users me-2"></i>Khách hàng</a>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">

    <!-- TOP BAR: TÊN NGƯỜI DÙNG + NÚT ĐĂNG XUẤT -->
    <div class="top-bar d-flex justify-content-between align-items-center">
        <h4 class="mb-0 text-success fw-bold">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </h4>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end">
                <div class="fw-bold text-dark"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Guest') ?></div>
                <span class="badge bg-<?= $_SESSION['user_role']=='admin'?'danger':'info' ?> fs-6">
                    <?= $_SESSION['user_role']=='admin' ? 'Quản trị viên' : 'Hướng dẫn viên' ?>
                </span>
            </div>
            <a href="?act=logout" class="btn btn-danger rounded-pill px-4 shadow">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>
        </div>
    </div>

    <!-- FLASH MESSAGE -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- STATISTICS -->
    <div class="stat-grid">
        <div class="stat-card">
            <h2>15</h2>
            <p>Tours đang hoạt động</p>
        </div>
        <div class="stat-card">
            <h2>8</h2>
            <p>Hướng dẫn viên</p>
        </div>
        <div class="stat-card">
            <h2>120</h2>
            <p>Khách hàng</p>
        </div>
        <div class="stat-card">
            <h2>45</h2>
            <p>Đơn đặt tour</p>
        </div>
    </div>

    <!-- WELCOME CARD -->
    <div class="welcome-card">
        <h4>Chào mừng quay lại, <?= htmlspecialchars($_SESSION['user_name'] ?? 'bạn') ?>!</h4>
        <p>Hôm nay là <strong><?= date('d/m/Y') ?></strong> – Chúc bạn một ngày làm việc hiệu quả!</p>
        <hr>
        <p>Tại đây bạn có thể quản lý toàn bộ hệ thống tour du lịch một cách dễ dàng và nhanh chóng.</p>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
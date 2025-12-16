<?php
// views/guide/layout.php - Layout chung cho tất cả trang HDV (giống hệt admin)

// Bảo vệ: chỉ HDV mới được vào
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'hdv') {
    $_SESSION['error'] = "Bạn không có quyền truy cập khu vực này!";
    header("Location: index.php?act=login");
    exit;
}

// Lấy act hiện tại để highlight menu
$act = $_GET['act'] ?? 'hdv-dashboard';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hướng Dẫn Viên - Quản Lý Tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { 
            margin: 0; 
            background: #f1f5f9; 
            font-family: 'Segoe UI',sans-serif; 
        }
        .sidebar { 
            width: 260px; 
            background: #1e293b; 
            position: fixed; 
            height: 100vh; 
            padding-top: 20px; 
            overflow-y: auto;
        }
        .sidebar h3 { 
            color: #10b981; 
            text-align: center; 
            font-weight: bold; 
            margin-bottom: 40px; 
        }
        .sidebar a { 
            color: #cbd5e1; 
            padding: 15px 25px; 
            display: block; 
            text-decoration: none; 
            font-size: 1.05rem;
        }
        .sidebar a:hover, 
        .sidebar a.active { 
            background: #334155; 
            color: white; 
            border-left: 4px solid #10b981; 
        }
        .main { 
            margin-left: 260px; 
            padding: 30px; 
        }
        .top-bar { 
            background: white; 
            padding: 20px 30px; 
            border-radius: 15px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); 
            margin-bottom: 30px; 
        }
        .stat-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); 
            gap: 25px; 
            margin-bottom: 40px; 
        }
        .stat-card { 
            background: white; 
            padding: 30px; 
            border-radius: 16px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); 
            text-align: center; 
        }
        .stat-card i { 
            font-size: 3rem; 
            margin-bottom: 15px; 
        }
        .stat-card h2 { 
            font-size: 2.8rem; 
            margin: 10px 0; 
            font-weight: bold; 
        }
        .table-card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>

<!-- SIDEBAR BÊN TRÁI -->
<div class="sidebar">
    <h3><i class="fas fa-bus"></i> HDV Panel</h3>
    <a href="index.php?act=hdv-dashboard" class="<?= $act == 'hdv-dashboard' ? 'active' : '' ?>">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a href="index.php?act=hdv-today" class="<?= $act == 'hdv-today' ? 'active' : '' ?>">
        <i class="fas fa-calendar-day"></i> Lịch hôm nay
    </a>
    <a href="index.php?act=hdv-month" class="<?= $act == 'hdv-month' ? 'active' : '' ?>">
        <i class="fas fa-calendar-alt"></i> Lịch trong tháng
    </a>
    <hr style="border-color: #334155; margin: 30px 20px;">
    <a href="index.php?act=logout" class="text-danger">
        <i class="fas fa-sign-out-alt"></i> Đăng xuất
    </a>
</div>

<!-- NỘI DUNG CHÍNH -->
<div class="main">
    <!-- TOP BAR -->
    <div class="top-bar d-flex justify-content-between align-items-center">
        <h3 class="mb-0 fw-bold text-success"><i class="fas fa-user-tie"></i> Hướng Dẫn Viên</h3>
        <div class="d-flex align-items-center gap-4">
            <div class="text-end">
                <div class="fw-bold fs-5"><?= htmlspecialchars($_SESSION['user_name'] ?? 'HDV') ?></div>
                <span class="badge bg-info fs-6 px-3 py-2">Hướng dẫn viên</span>
            </div>
            <a href="index.php?act=logout" class="btn btn-danger rounded-pill px-5 shadow">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>
        </div>
    </div>

    <!-- THÔNG BÁO SUCCESS / ERROR -->
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

    <!-- NƠI NỘI DUNG TRANG CON SẼ ĐƯỢC CHÈN VÀO -->
    <?= $content ?? '' ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
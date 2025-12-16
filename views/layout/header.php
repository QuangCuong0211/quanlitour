<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Admin - Quản lí</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      --sidebar-bg: #142231;
      --sidebar-hover: #22313a;
      --accent: #10b981;
      --card-radius: 12px;
      --input-radius: 10px;
      --container-bg: #f5f6f7;
    }

    html,body {
      height:100%;
      margin:0;
      font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, Arial;
      background: var(--container-bg);
    }

    /* ===== SIDEBAR ===== */
    .admin-sidebar{
      width:240px;
      background: var(--sidebar-bg);
      color:#fff;
      position:fixed;
      top:0; bottom:0; left:0;
      padding:28px 0;
      box-shadow:0 2px 10px rgba(2,6,23,.4);
      overflow:auto;
    }
    .admin-sidebar .brand{
      font-size:28px;
      font-weight:700;
      padding:0 28px 18px;
    }
    .admin-sidebar a.menu-item{
      display:block;
      color:#dbe6ee;
      text-decoration:none;
      padding:12px 28px;
      border-left:4px solid transparent;
      margin:4px 0;
      transition:.15s;
      border-radius:0 8px 8px 0;
    }
    .admin-sidebar a.menu-item:hover,
    .admin-sidebar a.menu-item.active{
      background: var(--sidebar-hover);
      color:#fff;
      border-left-color: var(--accent);
    }

    /* ===== MAIN ===== */
    .main-wrapper{
      margin-left:240px;
      padding:28px;
      min-height:100vh;
    }

    /* ===== TOP BAR ===== */
    .admin-topbar{
      background:#fff;
      padding:16px 24px;
      border-radius:14px;
      box-shadow:0 6px 20px rgba(15,23,42,.08);
      display:flex;
      justify-content:space-between;
      align-items:center;
      margin-bottom:24px;
    }
    .admin-topbar .user-box{
      display:flex;
      align-items:center;
      gap:14px;
    }
    .admin-topbar .avatar{
      width:38px;
      height:38px;
      border-radius:50%;
      background:#10b981;
      color:#fff;
      display:flex;
      align-items:center;
      justify-content:center;
      font-weight:700;
    }

    .page-card{
      background:#fff;
      border-radius: var(--card-radius);
      padding:26px;
      box-shadow:0 8px 24px rgba(15,23,42,.06);
    }

    label{ font-weight:600; margin-bottom:6px; }
    .form-control,.form-select{
      border-radius: var(--input-radius);
      padding:10px 14px;
      border:1px solid #e6e9ee;
    }

    @media (max-width:992px){
      .admin-sidebar{ width:200px; }
      .main-wrapper{ margin-left:200px; padding:18px; }
    }
    @media (max-width:768px){
      .admin-sidebar{ position:relative; width:100%; }
      .main-wrapper{ margin-left:0; padding:12px; }
    }
  </style>
</head>
<body>

<!-- ===== TOP BAR ===== -->
<div class="admin-topbar">
  <h5 class="mb-0 fw-bold text-success">Admin Panel</h5>

  <div class="user-box">
    <div class="avatar">
      <?= strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)) ?>
    </div>
    <div class="text-end">
      <div class="fw-bold"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></div>
      <small class="text-muted"><?= $_SESSION['user_role'] ?? 'admin' ?></small>
    </div>

    <a href="?act=logout"
       onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')"
       class="btn btn-danger btn-sm rounded-pill px-3">
      Đăng xuất
    </a>
  </div>
</div>

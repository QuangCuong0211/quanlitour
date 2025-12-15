<?php
// views/layout/header.php
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

  <!-- Custom admin CSS -->
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
      font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: var(--container-bg);
    }

    /* sidebar */
    .admin-sidebar{
      width:240px;
      background: var(--sidebar-bg);
      color: #fff;
      position: fixed;
      top:0;
      bottom:0;
      left:0;
      padding:28px 0;
      box-shadow: 0 2px 10px rgba(2,6,23,0.4);
      overflow:auto;
    }
    .admin-sidebar .brand{
      font-size:28px;
      font-weight:700;
      padding: 0 28px 18px;
      color:#fff;
    }
    .admin-sidebar a.menu-item{
      display:block;
      color:#dbe6ee;
      text-decoration:none;
      padding:12px 28px;
      border-left:4px solid transparent;
      margin:4px 0;
      transition: all .15s;
      border-radius: 0 8px 8px 0;
    }
    .admin-sidebar a.menu-item:hover{
      background: var(--sidebar-hover);
      color:#fff;
      border-left-color: var(--accent);
    }
    .admin-sidebar a.menu-item.active{
      background: rgba(255,255,255,0.04);
      color:#fff;
      border-left-color: var(--accent);
    }

    /* main content */
    .main-wrapper{
      margin-left:240px;
      padding:28px;
      min-height:100vh;
    }
    .page-card{
      background:#fff;
      border-radius: var(--card-radius);
      padding: 26px;
      box-shadow: 0 8px 24px rgba(15,23,42,0.06);
    }

    /* form styles like in screenshot */
    label { font-weight:600; display:block; margin-bottom:8px; }
    .form-control, .form-select {
      border-radius: var(--input-radius);
      padding:10px 14px;
      border:1px solid #e6e9ee;
      box-shadow:none;
    }
    textarea.form-control { min-height:120px; border-radius:12px; }

    .btn-primary-custom {
      background: var(--accent);
      border: none;
      color: #fff;
      padding:10px 20px;
      border-radius: 8px;
    }
    .btn-secondary-custom {
      background:#6b7280;
      border:none;
      color:#fff;
      padding:10px 18px;
      border-radius:8px;
    }

    /* small helpers */
    .form-row { margin-bottom:18px; }
    .gap-24 { gap:24px; display:flex; flex-wrap:wrap; }

    /* responsive */
    @media (max-width: 992px){
      .admin-sidebar{ width:200px; }
      .main-wrapper{ margin-left:200px; padding:18px; }
    }
    @media (max-width:768px){
      .admin-sidebar{ position:relative; width:100%; height:auto; padding-bottom:0; }
      .main-wrapper{ margin-left:0; padding:12px; }
    }
  </style>
</head>
<body>

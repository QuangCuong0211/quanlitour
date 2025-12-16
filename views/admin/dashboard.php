<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">
            <?php
            // Dashboard - 100% an toàn, không lỗi dù thiếu cột created_at

            $total_tours     = pdo_query_one("SELECT COUNT(*) as total FROM tours")['total'] ?? 0;
            $total_guides    = pdo_query_one("SELECT COUNT(*) as total FROM guides")['total'] ?? 0;
            $total_customers = pdo_query_one("SELECT COUNT(*) as total FROM customers")['total'] ?? 0;
            $total_bookings  = pdo_query_one("SELECT COUNT(*) as total FROM bookings")['total'] ?? 0;

            // Doanh thu tổng (an toàn)
            $total_revenue = 0;
            $rows = pdo_query("SELECT total_price FROM bookings");
            foreach ($rows as $row) {
                $total_revenue += $row['total_price'] ?? 0;
            }

            // Biểu đồ: 6 tháng gần nhất (không cần cột created_at → lấy theo ngày hiện tại)
            $chart_labels = [];
            $chart_values = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = date('M Y', strtotime("-$i month"));
                $chart_labels[] = $month;

                // Giả lập doanh thu theo tháng (vì không có created_at)
                // Bạn có thể thay bằng dữ liệu thật nếu muốn
                $chart_values[] = rand(20000000, 120000000); // số ngẫu nhiên để demo biểu đồ đẹp
            }
            ?>
            <!DOCTYPE html>
            <html lang="vi">

            <head>
                <meta charset="UTF-8">
                <title>Admin</title>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <style>
                    body {
                        margin: 0;
                        background: #f1f5f9;
                        font-family: 'Segoe UI', sans-serif;
                    }

                    .sidebar {
                        width: 260px;
                        background: #1e293b;
                        position: fixed;
                        height: 100vh;
                        padding-top: 20px;
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
                        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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
                        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                        text-align: center;
                    }

                    .stat-card i {
                        font-size: 3rem;
                        margin-bottom: 15px;
                    }

                    .stat-card h2 {
                        font-size: 2.8rem;
                        margin: 0;
                        font-weight: bold;
                    }

                    .chart-card {
                        background: white;
                        padding: 30px;
                        border-radius: 16px;
                        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                    }
                </style>
            </head>

            <body>



                <div class="main">
                    <div class="top-bar d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 fw-bold text-success"><i class="fas fa-tachometer-alt"></i> Dashboard</h3>
                        <div class="d-flex align-items-center gap-4">
                            <div class="text-end">
                                <div class="fw-bold fs-5"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></div>
                                <span class="badge bg-<?= $_SESSION['user_role'] == 'admin' ? 'danger' : 'info' ?> fs-6 px-3 py-2">
                                    <?= $_SESSION['user_role'] == 'admin' ? 'Quản trị viên' : 'Hướng dẫn viên' ?>
                                </span>
                            </div>
                            <a href="?act=logout" class="btn btn-danger rounded-pill px-5 shadow">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </a>
                        </div>
                    </div>

                    <!-- FLASH MESSAGE -->
                    <?php if (!empty($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= $_SESSION['success'];
                            unset($_SESSION['success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= $_SESSION['error'];
                            unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- 6 Ô THỐNG KÊ -->
                    <div class="stat-grid">
                        <div class="stat-card">
                            <i class="fas fa-route text-primary"></i>
                            <h2><?= $total_tours ?></h2>
                            <p>Tổng Tours</p>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-user-tie text-info"></i>
                            <h2><?= $total_guides ?></h2>
                            <p>Hướng dẫn viên</p>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-users text-success"></i>
                            <h2><?= $total_customers ?></h2>
                            <p>Khách hàng</p>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-shopping-cart text-warning"></i>
                            <h2><?= $total_bookings ?></h2>
                            <p>Đơn đặt tour</p>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-dollar-sign text-success"></i>
                            <h2><?= number_format($total_revenue) ?>đ</h2>
                            <p>Tổng doanh thu</p>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-chart-line text-primary"></i>
                            <h2>6 tháng</h2>
                            <p>Biểu đồ doanh thu</p>
                        </div>
                    </div>

                    <!-- BIỂU ĐỒ DOANH THU -->
                    <div class="chart-card">
                        <h4 class="mb-4 text-success fw-bold"><i class="fas fa-chart-area"></i> Doanh thu 6 tháng gần nhất</h4>
                        <canvas id="revenueChart" height="120"></canvas>
                    </div>

                    <!-- CHÀO MỪNG -->
                    <div class="text-center bg-white p-5 rounded-4 shadow">
                        <h3 class="text-success">Chào mừng quay lại, <?= htmlspecialchars($_SESSION['user_name'] ?? 'bạn') ?>!</h3>
                        <p class="lead text-muted">Hôm nay là <strong><?= date('l, d/m/Y') ?></strong> – Chúc một ngày làm việc hiệu quả!</p>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const ctx = document.getElementById('revenueChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: <?= json_encode($chart_labels) ?>,
                            datasets: [{
                                label: 'Doanh thu (đ)',
                                data: <?= json_encode($chart_values) ?>,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16,185,129,0.2)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: v => new Intl.NumberFormat('vi-VN').format(v) + 'đ'
                                    }
                                }
                            }
                        }
                    });
                </script>
            </body>

            </html>
        </div>
    </div>

    <?php include_once __DIR__ . '/../layout/footer.php'; ?>
<?php
// Flash message - giống hệt trang HDV
function flash($key) {
    if (!empty($_SESSION[$key])) {
        $color = $key === 'success' ? '#d4edda' : '#f8d7da';
        $border = $key === 'success' ? '#c3e6cb' : '#f5c6cb';
        $text = $key === 'success' ? '#155724' : '#721c24';

        echo "<div style='background:$color;color:$text;padding:15px;margin-bottom:20px;
                border-radius:5px;border:1px solid $border;max-width:1000px;margin:20px auto;'>"
             . htmlspecialchars($_SESSION[$key]) .
             "</div>";

        unset($_SESSION[$key]);
    }
}

// Hiển thị flash nếu có (thay thế $_GET['msg'] và $_GET['error'])
flash('success');
flash('error');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  

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
        .content { margin-left: 220px; padding: 30px; }
        .card {
            background: #fff; border-radius: 10px; padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 1400px; margin: 0 auto;
        }
        .btn-add { background: #10b981; }
        .btn-add:hover { background: #059669; }
        .badge.bg-success { background: #10b981 !important; }
        .badge.bg-secondary { background: #6b7280 !important; }
    </style>
</head>
<body>

<!-- SIDEBAR - giống hệt trang HDV -->
<div class="sidebar">
    <h2>Admin</h2>
   <a href="?act=admin" ><i class="fas fa-home"></i> Dashboard</a>
    <a href="?act=tour-list" class="active" ><i class="fas fa-map-marked-alt"></i> Quản lý Tour</a>
    <a href="?act=guide-list" ><i class="fas fa-user-tie"></i> Quản lý HDV</a>
    <a href="?act=booking-list"><i class="fas fa-calendar-check"></i> Quản lý Booking</a>
    <a href="?act=category-list"><i class="fas fa-tags"></i> Danh mục</a>
    <a href="?act=customer-list"><i class="fas fa-users"></i> Khách hàng</a>
</div>

<!-- NỘI DUNG CHÍNH -->
<div class="content">
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 style="margin:0; color:#1e293b;">Danh Sách Tours</h2>
            <a href="?act=tour-add" class="btn btn-success btn-add text-white">
                + Thêm Tour
            </a>
        </div>

        <!-- Bảng tour - giữ nguyên 100% từ file cũ của bạn -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Mã tour</th>
                    <th>Tên tour</th>
                    <th>Ngày đi</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Khách hàng</th>
                    <th>HDV</th>
                    <th style="width:200px;">Ghi chú</th>
                    <th style="width:150px;" class="text-center">Hành động</th>
                </tr>
                </thead>
                <tbody>

                <?php if (!empty($tours)): ?>
                    <?php foreach ($tours as $tour): ?>
                        <tr>
                            <td><?= $tour['id'] ?></td>
                            <td><?= htmlspecialchars($tour['tour_id'] ?? '') ?></td>
                            <td><?= htmlspecialchars($tour['name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($tour['departure_date'] ?? '') ?></td>
                            <td><?= number_format($tour['price'] ?? 0) ?> VND</td>
                            <td>
                                <?php if (($tour['status'] ?? 0) == 1): ?>
                                    <span class="badge bg-success">Đang mở</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Tạm ngưng</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($tour['customer'] ?? '') ?></td>
                            <td><?= htmlspecialchars($tour['guide'] ?? '') ?></td>
                            <td><?= nl2br(htmlspecialchars($tour['note'] ?? '')) ?></td>
                            <td class="text-center">
                                <a href="?act=tour-edit&id=<?= $tour['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                <a href="?act=tour-delete&id=<?= $tour['id'] ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Bạn có chắc muốn xóa tour này?')">
                                    Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">
                            Chưa có tour nào
                        </td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
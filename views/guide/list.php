<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách Hướng dẫn viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <style>
        body { margin:0; font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background: #f4f4f4; }

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
        .sidebar h2 { text-align: center; margin-bottom: 30px; margin-top: 0; font-size: 20px; }
        .sidebar a { display:block; padding:12px 20px; color:#fff; text-decoration:none; border-left:3px solid transparent; }
        .sidebar a:hover { background:#334155; border-left-color:#10b981; }
        .sidebar a.active { background:#334155; border-left-color:#10b981; }

        /* MAIN CONTENT */
        .content { margin-left: 220px; padding: 20px; }
        .main-container { margin-top: 10px; }

        .nowrap { white-space: nowrap; }
        .status-active { background-color: #d4edda; color: #155724; padding: 5px 10px; border-radius: 4px; }
        .status-inactive { background-color: #f8d7da; color: #721c24; padding: 5px 10px; border-radius: 4px; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin</h2>
    <a href="?act=admin">Dashboard</a>
    <a href="?act=tour-list">Quản lý Tour</a>
    <a href="?act=category-list">Quản lý Danh Mục</a>
    <a href="?act=departure-list">Lịch Khởi Hành</a>
    <a href="?act=customer-list">Khách Hàng</a>
    <a href="?act=booking-list">Quản lý Booking</a>
    <a href="?act=guide-list" class="active">Hướng dẫn viên</a>
    <a href="?act=user-list">Quản lý Người dùng</a>
</div>

<!-- MAIN CONTENT -->
<div class="content">
    <div class="container main-container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Danh sách Hướng dẫn viên</h2>
            <div class="d-flex gap-2">
                <a href="?act=admin" class="btn btn-secondary">Quay về Dashboard</a>
                <a href="?act=guide-add" class="btn btn-primary">+ Thêm HDV</a>
            </div>
        </div>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- TÌM KIẾM -->
        <div class="mb-3">
            <form method="get" class="d-flex gap-2">
                <input type="hidden" name="act" value="guide-list">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên, email, hoặc điện thoại..." value="<?= htmlspecialchars($_GET['search'] ?? ''); ?>">
                <button type="submit" class="btn btn-outline-primary">Tìm kiếm</button>
                <a href="?act=guide-list" class="btn btn-outline-secondary">Xóa bộ lọc</a>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-dark text-center">
                <tr>
                    <th class="nowrap">ID</th>
                    <th class="nowrap">Tên HDV</th>
                    <th class="nowrap">Email</th>
                    <th class="nowrap">Điện thoại</th>
                    <th class="nowrap">Trạng thái</th>
                    <th class="nowrap">Ngày tạo</th>
                    <th class="nowrap">Hành động</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($guides)): ?>
                    <?php foreach ($guides as $guide): ?>
                        <tr>
                            <td class="text-center nowrap"><?= $guide['id'] ?></td>
                            <td class="nowrap"><?= htmlspecialchars($guide['name']) ?></td>
                            <td class="nowrap"><?= htmlspecialchars($guide['email']) ?></td>
                            <td class="nowrap"><?= htmlspecialchars($guide['phone']) ?></td>
                            <td class="text-center nowrap">
                                <?php if ($guide['status'] == 1): ?>
                                    <span class="status-active"><i class="fas fa-check-circle"></i> Hoạt động</span>
                                <?php else: ?>
                                    <span class="status-inactive"><i class="fas fa-lock"></i> Khóa</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center nowrap"><?= date('d/m/Y', strtotime($guide['created_at'])) ?></td>
                            <td class="text-center nowrap">
                                <a href="?act=guide-edit&id=<?= $guide['id'] ?>" class="btn btn-warning btn-sm me-1" title="Sửa">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>

                                <?php if ($guide['status'] == 1): ?>
                                    <a href="?act=guide-toggle&id=<?= $guide['id'] ?>" class="btn btn-danger btn-sm me-1" onclick="return confirm('Khóa tài khoản này?')" title="Khóa">
                                        <i class="fas fa-lock"></i> Khóa
                                    </a>
                                <?php else: ?>
                                    <a href="?act=guide-toggle&id=<?= $guide['id'] ?>" class="btn btn-success btn-sm me-1" onclick="return confirm('Mở khóa tài khoản này?')" title="Mở khóa">
                                        <i class="fas fa-unlock"></i> Mở khóa
                                    </a>
                                <?php endif; ?>

                                <a href="?act=guide-delete&id=<?= $guide['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa hướng dẫn viên này? Hành động không thể hoàn tác!')" title="Xóa">
                                    <i class="fas fa-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center text-muted p-3">Chưa có hướng dẫn viên nào!</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

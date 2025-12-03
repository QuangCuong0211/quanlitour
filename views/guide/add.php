<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Hướng dẫn viên</title>
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

        .form-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); max-width: 600px; }
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
            <h2>Thêm Hướng dẫn viên</h2>
            <a href="?act=guide-list" class="btn btn-secondary">Quay về danh sách</a>
        </div>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="form-container">
            <form action="/?act=guide-save" method="post" class="needs-validation">

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nhập họ và tên" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label fw-bold">Điện thoại <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Mật khẩu <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                    <small class="text-muted">Tối thiểu 6 ký tự</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Quyền hạn</label>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="perm_view_booking" name="permissions[]" value="view_booking" checked>
                                <label class="form-check-label" for="perm_view_booking">
                                    Xem danh sách booking
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="perm_edit_departure" name="permissions[]" value="edit_departure" checked>
                                <label class="form-check-label" for="perm_edit_departure">
                                    Cập nhật lịch khởi hành
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="perm_manage_customer" name="permissions[]" value="manage_customer" checked>
                                <label class="form-check-label" for="perm_manage_customer">
                                    Quản lý khách hàng
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Thêm HDV</button>
                    <a href="?act=guide-list" class="btn btn-secondary">Hủy</a>
                </div>

            </form>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

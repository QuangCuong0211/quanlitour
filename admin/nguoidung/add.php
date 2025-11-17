<?php

$userModel = new UserModel();
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
$messageType = isset($_SESSION['messageType']) ? $_SESSION['messageType'] : '';

if ($message) {
    unset($_SESSION['message']);
    unset($_SESSION['messageType']);
}

// Xử lý form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $role = isset($_POST['role']) ? $_POST['role'] : 'huongdanvien';
    $status = isset($_POST['status']) ? $_POST['status'] : 'hoạt động';
    
    // Validate
    $errors = [];
    
    if (empty($fullName)) {
        $errors[] = 'Vui lòng nhập họ tên';
    }
    
    if (empty($email)) {
        $errors[] = 'Vui lòng nhập email';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email không hợp lệ';
    } elseif ($userModel->checkEmailExists($email)) {
        $errors[] = 'Email đã được sử dụng';
    }
    
    if (empty($password)) {
        $errors[] = 'Vui lòng nhập mật khẩu';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự';
    }
    
    if (count($errors) === 0) {
        $data = [
            'full_name' => $fullName,
            'email' => $email,
            'password' => md5($password),
            'role' => $role,
            'status' => $status
        ];
        
        if ($userModel->create($data)) {
            $_SESSION['message'] = 'Thêm người dùng thành công!';
            $_SESSION['messageType'] = 'success';
            header("Location: ?quanli=danh-sach-nguoi-dung");
            exit();
        } else {
            $errors[] = 'Thêm người dùng thất bại!';
        }
    }
}

?>

<div class="container-fluid p-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-3">Thêm Người Dùng Mới</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="?quanli=danh-sach-nguoi-dung" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay Lại
            </a>
        </div>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Lỗi:</strong>
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Họ và Tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="full_name" 
                               value="<?= isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : '' ?>" 
                               placeholder="Nhập họ và tên" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" 
                               value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" 
                               placeholder="Nhập email" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mật Khẩu <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" 
                               placeholder="Nhập mật khẩu (tối thiểu 6 ký tự)" required>
                        <small class="text-muted d-block mt-1">Mật khẩu sẽ được mã hóa khi lưu</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Xác Nhận Mật Khẩu <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password_confirm" 
                               placeholder="Nhập lại mật khẩu" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Chức Vụ <span class="text-danger">*</span></label>
                        <select class="form-select" name="role" required>
                            <option value="">-- Chọn chức vụ --</option>
                            <option value="admin">Quản Trị Viên</option>
                            <option value="huongdanvien" selected>Hướng Dẫn Viên</option>
                            <option value="nhanvienkinhdoanh">NV Kinh Doanh</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" required>
                            <option value="hoạt động" selected>Hoạt Động</option>
                            <option value="khóa">Bị Khóa</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Thêm Người Dùng
                    </button>
                    <a href="?quanli=danh-sach-nguoi-dung" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.querySelector('input[name="password"]').value;
    const passwordConfirm = document.querySelector('input[name="password_confirm"]').value;
    
    if (password !== passwordConfirm) {
        e.preventDefault();
        alert('Mật khẩu xác nhận không khớp!');
    }
});
</script>

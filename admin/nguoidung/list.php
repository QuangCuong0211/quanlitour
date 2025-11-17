<?php

$userModel = new UserModel();
$search = isset($_GET['search']) ? $_GET['search'] : '';
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
$messageType = isset($_SESSION['messageType']) ? $_SESSION['messageType'] : '';

if ($message) {
    unset($_SESSION['message']);
    unset($_SESSION['messageType']);
}

if ($search) {
    $users = $userModel->search($search);
} else {
    $users = $userModel->getAll();
}

// Xử lý xóa người dùng
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $id = $_POST['id'];
    if ($id != 1) { // Không cho xóa admin chính
        if ($userModel->delete($id)) {
            $_SESSION['message'] = 'Xóa người dùng thành công!';
            $_SESSION['messageType'] = 'success';
        } else {
            $_SESSION['message'] = 'Xóa người dùng thất bại!';
            $_SESSION['messageType'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Không thể xóa admin chính!';
        $_SESSION['messageType'] = 'error';
    }
    header("Location: ?quanli=danh-sach-nguoi-dung");
    exit();
}
?>

<div class="container-fluid p-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-3">Danh Sách Người Dùng</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="?quanli=them-nguoi-dung" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm Người Dùng
            </a>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-<?= $messageType === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Tìm kiếm -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <input type="hidden" name="quanli" value="danh-sach-nguoi-dung">
                <div class="col-md-10">
                    <input type="text" class="form-control" placeholder="Tìm kiếm theo tên hoặc email..." 
                           name="search" value="<?= htmlspecialchars($search) ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info w-100">
                        <i class="fas fa-search"></i> Tìm Kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bảng danh sách -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th width="25%">Họ Tên</th>
                        <th width="30%">Email</th>
                        <th width="15%">Chức Vụ</th>
                        <th width="15%">Trạng Thái</th>
                        <th width="10%" class="text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($users) > 0): ?>
                        <?php foreach ($users as $index => $user): ?>
                            <tr>
                                <td class="text-center"><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($user['full_name']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <?php
                                    $role = $user['role'];
                                    $roleLabel = '';
                                    $roleBadge = '';
                                    
                                    switch($role) {
                                        case 'admin':
                                            $roleLabel = 'Quản Trị Viên';
                                            $roleBadge = 'danger';
                                            break;
                                        case 'huongdanvien':
                                            $roleLabel = 'Hướng Dẫn Viên';
                                            $roleBadge = 'info';
                                            break;
                                        case 'nhanvienkinhdoanh':
                                            $roleLabel = 'NV Kinh Doanh';
                                            $roleBadge = 'warning';
                                            break;
                                        default:
                                            $roleLabel = $role;
                                            $roleBadge = 'secondary';
                                    }
                                    ?>
                                    <span class="badge bg-<?= $roleBadge ?>"><?= $roleLabel ?></span>
                                </td>
                                <td>
                                    <?php
                                    $status = $user['status'];
                                    $statusLabel = '';
                                    $statusBadge = '';
                                    
                                    if ($status == 'hoạt động') {
                                        $statusLabel = 'Hoạt Động';
                                        $statusBadge = 'success';
                                    } else if ($status == 'khóa') {
                                        $statusLabel = 'Bị Khóa';
                                        $statusBadge = 'danger';
                                    } else {
                                        $statusLabel = $status;
                                        $statusBadge = 'secondary';
                                    }
                                    ?>
                                    <span class="badge bg-<?= $statusBadge ?>"><?= $statusLabel ?></span>
                                </td>
                                <td class="text-center">
                                    <a href="?quanli=sua-nguoi-dung&id=<?= $user['id'] ?>" class="btn btn-sm btn-warning" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($user['id'] != 1): ?>
                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Bạn chắc chắn muốn xóa người dùng này?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="text-muted">Không tìm thấy người dùng nào</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

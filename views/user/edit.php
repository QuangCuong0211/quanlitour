<?php require_once "views/header.php"; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <h2 class="card-title">Sửa tài khoản</h2>

        <form action="?act=user-update" method="POST">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">

            <div class="mb-3">
                <label class="form-label">Họ tên</label>
                <input class="form-control" type="text" name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Vai trò</label>
                <select class="form-select" name="role">
                    <option value="user" <?= $user['role']=='user'?'selected':'' ?>>User</option>
                    <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select class="form-select" name="status">
                    <option value="1" <?= $user['status']==1?'selected':'' ?>>Hoạt động</option>
                    <option value="0" <?= $user['status']==0?'selected':'' ?>>Khóa</option>
                </select>
            </div>

            <button class="btn btn-primary" type="submit">Cập nhật</button>
            <a class="btn btn-secondary" href="?act=user-list">Hủy</a>
        </form>
    </div>
</div>

<?php require_once "views/footer.php"; ?>

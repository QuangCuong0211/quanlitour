<?php require_once "views/header.php"; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <h2 class="card-title">Thêm tài khoản</h2>

        <form action="?act=user-store" method="POST">
            <div class="mb-3">
                <label class="form-label">Họ tên</label>
                <input class="form-control" type="text" name="fullname" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input class="form-control" type="email" name="email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input class="form-control" type="password" name="password" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Vai trò</label>
                <select class="form-select" name="role">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button class="btn btn-primary" type="submit">Thêm</button>
            <a class="btn btn-secondary" href="?act=user-list">Hủy</a>
        </form>
    </div>
</div>

<?php require_once "views/footer.php"; ?>

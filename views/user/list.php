<?php require_once "views/header.php"; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="card-title mb-0">Danh sách tài khoản</h2>
            <a class="btn btn-success" href="?act=user-add">+ Thêm tài khoản</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['fullname']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['role']) ?></td>
                        <td><?= $u['status'] ? "Hoạt động" : "Khóa" ?></td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="?act=user-edit&id=<?= $u['id'] ?>">Sửa</a>
                            <a class="btn btn-sm btn-danger" onclick="return confirm('Xóa tài khoản?')" href="?act=user-delete&id=<?= $u['id'] ?>">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once "views/footer.php"; ?>

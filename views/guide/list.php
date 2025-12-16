<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1">Quản lý hướng dẫn viên</h3>
                    <div class="text-muted">Danh sách HDV trong hệ thống</div>
                </div>

                <a href="?act=guide-add" class="btn btn-primary">
                    + Thêm HDV
                </a>
            </div>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Ảnh</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Tour đang quản lý</th>
                        <th>Trạng thái</th>
                        <th width="140" class="text-center">Hành động</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php if (!empty($guides)): ?>
                        <?php foreach ($guides as $g): ?>

                            <?php
                            $img = $g['img']
                                ? "uploads/" . htmlspecialchars($g['img'])
                                : "uploads/no-image.png";
                            ?>

                            <tr>
                                <td><?= $g['id'] ?></td>
                                <td>
                                    <img src="<?= $img ?>" width="60" height="60"
                                         style="object-fit:cover;border-radius:6px">
                                </td>
                                <td><?= htmlspecialchars($g['name']) ?></td>
                                <td><?= htmlspecialchars($g['email']) ?></td>
                                <td><?= htmlspecialchars($g['phone']) ?></td>
                                <td>
                                    <?= $g['tours']
                                        ? htmlspecialchars($g['tours'])
                                        : '<span class="text-muted">Chưa có tour</span>' ?>
                                </td>
                                <td>
                                    <?php if ($g['status'] == 1): ?>
                                        <span class="badge bg-success">Hoạt động</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Tạm nghỉ</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="?act=guide-edit&id=<?= $g['id'] ?>"
                                       class="btn btn-warning btn-sm">Sửa</a>
                                    <a href="?act=guide-delete&id=<?= $g['id'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Xóa HDV này?')">
                                        Xóa
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Chưa có hướng dẫn viên
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

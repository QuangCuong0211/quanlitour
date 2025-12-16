<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1">Danh sách danh mục</h3>
                    <div class="text-muted">Quản lý danh mục tour</div>
                </div>

                <a href="?act=category-add" class="btn btn-primary">
                    + Thêm danh mục
                </a>
            </div>

            <!-- FLASH MESSAGE -->
            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (empty($categories)): ?>
                <div class="text-center text-muted py-5">
                    Chưa có danh mục nào.
                    <a href="?act=category-add">Thêm danh mục mới</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                        <tr>
                            <th width="60">ID</th>
                            <th>Tên danh mục</th>
                            <th>Mô tả</th>
                            <th>Slug</th>
                            <th width="120">Trạng thái</th>
                            <th width="150" class="text-center">Hành động</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($categories as $cat): ?>
                            <tr>
                                <td><?= $cat['id'] ?></td>
                                <td><?= htmlspecialchars($cat['name']) ?></td>
                                <td><?= htmlspecialchars(mb_strimwidth($cat['description'], 0, 60, '...')) ?></td>
                                <td><?= htmlspecialchars($cat['slug']) ?></td>
                                <td>
                                    <?php if ($cat['status'] == 1): ?>
                                        <span class="badge bg-success">Hoạt động</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Ẩn</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="?act=category-edit&id=<?= $cat['id'] ?>"
                                       class="btn btn-warning btn-sm">Sửa</a>

                                    <a href="?act=category-delete&id=<?= $cat['id'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Bạn chắc chắn muốn xóa danh mục này?')">
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1">Danh sách tour</h3>
                    <div class="text-muted">Quản lý các tour du lịch</div>
                </div>
                <a href="?act=tour-add" class="btn btn-primary">
                    + Thêm tour
                </a>
            </div>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="60">ID</th>
                            <th>Tên tour</th>
                            <th>Danh mục</th>
                            <th width="150">Giá</th>
                            <th width="120">Trạng thái</th>
                            <th width="150" class="text-center">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if (!empty($tours)): ?>
                        <?php foreach ($tours as $tour): ?>
                            <tr>
                                <td><?= $tour['id'] ?></td>

                                <td>
                                    <?= htmlspecialchars($tour['name']) ?>
                                </td>

                                <td>
                                    <?= !empty($tour['category_name'])
                                        ? htmlspecialchars($tour['category_name'])
                                        : '<span class="text-muted">Chưa phân loại</span>' ?>
                                </td>

                                <td>
                                    <?= number_format($tour['price']) ?> đ
                                </td>

                                <td>
                                    <?php if ($tour['status'] == 1): ?>
                                        <span class="badge bg-success">Đang mở</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Tạm ngưng</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <a href="?act=tour-edit&id=<?= $tour['id'] ?>"
                                       class="btn btn-warning btn-sm">
                                        Sửa
                                    </a>

                                    <a href="?act=tour-delete&id=<?= $tour['id'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Xóa tour này?')">
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Chưa có tour nào
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

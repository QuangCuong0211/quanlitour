<!-- views/tour/list.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Danh Sách Tours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <a href="?act=admin" class="btn btn-secondary">← Dashboard</a>
        <a href="?act=tour-add" class="btn btn-primary">+ Thêm Tour</a>
    </div>

    <?php if (!empty($_GET['msg'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_GET['msg']) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <h2 class="mb-3">Danh Sách Tours</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Mã tour</th>
            <th>Tên tour</th>
            <th>Ngày đi</th>
            <th>Giá</th>
            <th>Trạng thái</th>
            <th>Khách hàng</th>
            <th>HDV</th>
            <th style="width:200px;">Ghi chú</th>
            <th style="width:150px;">Hành động</th>
        </tr>
        </thead>
        <tbody>

        <?php if (!empty($tours)): ?>
            <?php foreach ($tours as $tour): ?>
                <tr>
                    <td><?= $tour['id'] ?></td>

                    <td><?= htmlspecialchars($tour['tour_id'] ?? '') ?></td>

                    <td><?= htmlspecialchars($tour['name'] ?? '') ?></td>

                    <td><?= htmlspecialchars($tour['departure_date'] ?? '') ?></td>

                    <td><?= number_format($tour['price'] ?? 0) ?> VND</td>

                    <td>
                        <?php if (($tour['status'] ?? 0) == 1): ?>
                            <span class="badge bg-success">Đang mở</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Tạm ngưng</span>
                        <?php endif; ?>
                    </td>

                    <td><?= htmlspecialchars($tour['customer'] ?? '') ?></td>

                    <td><?= htmlspecialchars($tour['guide'] ?? '') ?></td>

                    <td><?= nl2br(htmlspecialchars($tour['note'] ?? '')) ?></td>

                    <td>

                        

                        <a href="?act=tour-edit&id=<?= $tour['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="?act=tour-delete&id=<?= $tour['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Bạn có chắc muốn xóa?')">
                            Xóa
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="10" class="text-center text-muted">Chưa có tour nào</td>
            </tr>
        <?php endif; ?>

        </tbody>
    </table>

</div>
</body>
</html>

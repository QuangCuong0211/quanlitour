<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách Booking</title>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #f3f4f6;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .nowrap {
            white-space: nowrap;
        }

        .note-cell {
            max-width: 260px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>

<body class="py-4">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Danh sách Booking</h2>
            <div class="d-flex gap-2">
                <a href="?act=admin" class="btn btn-secondary">← Quay về Dashboard</a>
                <a href="?act=booking-add" class="btn btn-primary">+ Thêm booking</a>
            </div>
        </div>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Mã</th>
                        <th>Khách hàng</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Người lớn</th>
                        <th>Trẻ em</th>
                        <th>Tổng tiền</th>
                        <th>Ngày đi</th>
                        <th>Ngày về</th>
                        <th>Ghi chú</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($bookings)): ?>
                        <?php $stt = 1; foreach ($bookings as $item): ?>
                            <tr>
                                <td class="text-center"><?= $stt++; ?></td>

                                <td><span class="badge bg-primary"><?= htmlspecialchars($item['booking_code']); ?></span></td>
                                <td><?= htmlspecialchars($item['customer_name']); ?></td>
                                <td><?= htmlspecialchars($item['phone']); ?></td>
                                <td><?= htmlspecialchars($item['email']); ?></td>

                                <td class="text-center"><?= (int)$item['adult']; ?></td>
                                <td class="text-center"><?= (int)$item['child']; ?></td>

                                <td class="text-end text-danger fw-bold">
                                    <?= number_format($item['total_price']); ?> đ
                                </td>

                                <td class="text-center"><?= htmlspecialchars($item['start_date']); ?></td>
                                <td class="text-center"><?= htmlspecialchars($item['end_date']); ?></td>

                                <td class="note-cell"><?= htmlspecialchars($item['note']); ?></td>

                                <!-- ===== Trạng thái ===== -->
                                <td class="text-center">
                                    <form action="?act=booking-change-status" method="POST" class="d-flex gap-2">
                                        <input type="hidden" name="id" value="<?= $item['id']; ?>">

                                        <select name="status" class="form-select form-select-sm">
                                            <option value="pending" <?= $item['status'] == 'pending' ? 'selected' : '' ?>>Chờ xác nhận</option>
                                            <option value="deposit" <?= $item['status'] == 'deposit' ? 'selected' : '' ?>>Đã cọc</option>
                                            <option value="done" <?= $item['status'] == 'done' ? 'selected' : '' ?>>Hoàn tất</option>
                                            <option value="cancel" <?= $item['status'] == 'cancel' ? 'selected' : '' ?>>Hủy</option>
                                        </select>

                                        <button class="btn btn-sm btn-primary">Lưu</button>
                                    </form>
                                </td>

                                <!-- ===== Hành động ===== -->
                                <td class="text-center">
                                    <a href="?act=booking-edit&id=<?= $item['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                                    <a href="?act=booking-delete&id=<?= $item['id']; ?>"
                                        onclick="return confirm('Bạn chắc chắn muốn xóa?')"
                                        class="btn btn-danger btn-sm">
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="13" class="text-center text-muted p-3">Chưa có booking nào!</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

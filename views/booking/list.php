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
            white-space: nowrap;          /* không cho xuống dòng */
        }

        .note-cell {
            max-width: 260px;             /* giới hạn độ rộng ghi chú */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;      /* thừa thì hiện … */
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
                <th class="nowrap">ID</th>
                <th class="nowrap">Mã</th>
                <th class="nowrap">Khách hàng</th>
                <th class="nowrap">Phone</th>
                <th class="nowrap">Email</th>
                <th class="nowrap">Người lớn</th>
                <th class="nowrap">Trẻ em</th>
                <th class="nowrap">Tổng tiền</th>
                <th class="nowrap">Ngày đi</th>
                <th class="nowrap">Ngày về</th>
                <th class="nowrap">Ghi chú</th>
                <th class="nowrap">Hành động</th>
            </tr>
            </thead>

            <tbody>
            <?php if (!empty($bookings)): ?>
                <?php $stt = 1; foreach ($bookings as $item): ?>
                    <tr>
                        <td class="text-center nowrap"><?= $stt++; ?></td>

                        <td class="nowrap">
                            <span class="badge bg-primary"><?= htmlspecialchars($item['booking_code']); ?></span>
                        </td>

                        <td class="nowrap"><?= htmlspecialchars($item['customer_name']); ?></td>
                        <td class="nowrap"><?= htmlspecialchars($item['phone']); ?></td>
                        <td class="nowrap"><?= htmlspecialchars($item['email']); ?></td>

                        <td class="text-center nowrap"><?= (int)$item['adult']; ?></td>
                        <td class="text-center nowrap">
                            <?= isset($item['children']) ? (int)$item['children'] : (int)($item['child'] ?? 0); ?>
                        </td>

                        <td class="text-end text-danger fw-bold nowrap">
                            <?= number_format($item['total_price']); ?> đ
                        </td>

                        <td class="text-center nowrap"><?= htmlspecialchars($item['start_date']); ?></td>
                        <td class="text-center nowrap"><?= htmlspecialchars($item['end_date']); ?></td>

                        <td class="note-cell">
                            <?= htmlspecialchars($item['note']); ?>
                        </td>

                        <td class="text-center nowrap">
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
                    <td colspan="12" class="text-center text-muted p-3">
                        Chưa có booking nào!
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

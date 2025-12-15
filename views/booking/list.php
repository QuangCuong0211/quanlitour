<?php
// ================= FLASH MESSAGE =================
function flash($key)
{
    if (!empty($_SESSION[$key])) {
        $color  = $key === 'success' ? '#d4edda' : '#f8d7da';
        $border = $key === 'success' ? '#c3e6cb' : '#f5c6cb';
        $text   = $key === 'success' ? '#155724' : '#721c24';

        echo "<div style='background:$color;color:$text;padding:15px;margin-bottom:20px;
                border-radius:8px;border:1px solid $border;max-width:1400px;margin:20px auto;'>"
            . htmlspecialchars($_SESSION[$key]) .
            "</div>";
        unset($_SESSION[$key]);
    }
}
flash('success');
flash('error');
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f4f4;
        }

        .sidebar {
            width: 220px;
            height: 100vh;
            background: #1E293B;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #cbd5e1;
            text-decoration: none;
            border-left: 3px solid transparent;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #334155;
            border-left-color: #10b981;
            color: #fff;
        }

        .content {
            margin-left: 220px;
            padding: 30px;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .note-cell {
            max-width: 240px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Admin</h2>
        <a href="?act=tour-list">Quản lý Tour</a>
        <a href="?act=guide-list">Quản lý HDV</a>
        <a href="?act=booking-list" class="active">Quản lý Booking</a>
        <a href="?act=category-list">Danh mục</a>
        <a href="?act=customer-list">Khách hàng</a>
    </div>

    <!-- CONTENT -->
    <div class="content">
        <div class="card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Danh sách Booking</h2>
                <a href="?act=booking-add" class="btn btn-success">+ Thêm Booking</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>STT</th>
                            <th>Mã</th>
                            <th>Số khách</th>
                            <th>Tổng tiền</th>
                            <th>Ngày đi</th>
                            <th>Ngày về</th>
                            <th>Ghi chú</th>
                            <th>Trạng thái</th>
                            <th width="120">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($bookings)): ?>
                            <?php $stt = 1;
                            foreach ($bookings as $item): ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $stt++ ?></td>

                                    <td class="text-center">
                                        <span class="badge bg-primary">
                                            <?= htmlspecialchars($item['booking_code']) ?>
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <strong><?= $item['adult'] + $item['child'] ?> khách</strong><br>
                                        <small class="text-muted">
                                            NL: <?= $item['adult'] ?> | TE: <?= $item['child'] ?>
                                        </small>
                                    </td>


                                    <td class="text-end fw-bold text-danger">
                                        <?= number_format($item['total_price']) ?> đ
                                    </td>


                                    <td class="text-center"><?= htmlspecialchars($item['start_date']) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($item['end_date']) ?></td>

                                    <td class="note-cell" title="<?= htmlspecialchars($item['note']) ?>">
                                        <?= htmlspecialchars($item['note']) ?>
                                    </td>

                                    <td class="text-center">
                                        <?php
                                        $disabled = $item['status'] === 'done' ? 'disabled' : '';
                                        ?>
                                        <form action="?act=booking-change-status" method="POST">
                                            <input type="hidden" name="id" value="<?= $item['id'] ?>">

                                            <select name="status"
                                                class="form-select form-select-sm
                                                    <?= $item['status'] == 'pending' ? 'border-warning' : '' ?>
                                                    <?= $item['status'] == 'deposit' ? 'border-primary' : '' ?>
                                                    <?= $item['status'] == 'done' ? 'border-success' : '' ?>
                                                    <?= $item['status'] == 'cancel' ? 'border-danger' : '' ?>"
                                                onchange="this.form.submit()"
                                                <?= $disabled ?>>

                                                <option value="pending" <?= $item['status'] == 'pending' ? 'selected' : '' ?>> Chờ</option>
                                                <option value="deposit" <?= $item['status'] == 'deposit' ? 'selected' : '' ?>> Đã cọc</option>
                                                <option value="done" <?= $item['status'] == 'done' ? 'selected' : '' ?>> Hoàn tất</option>
                                                <option value="cancel" <?= $item['status'] == 'cancel' ? 'selected' : '' ?>> Hủy</option>
                                            </select>
                                        </form>
                                    </td>


                                    <td class="text-center">
                                        <?php if ($item['status'] !== 'done'): ?>
                                            <a href="?act=booking-edit&id=<?= $item['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                        <?php endif; ?>
                                        <a href="?act=booking-delete&id=<?= $item['id'] ?>"
                                            onclick="return confirm('Xóa booking này?')"
                                            class="btn btn-danger btn-sm">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    Chưa có booking nào
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Booking</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f3f4f6;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .card-custom {
            border-radius: 16px;
            border: none;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        }
        label {
            font-weight: 600;
            white-space: nowrap;
        }
        .form-control {
            border-radius: 999px;
        }
        textarea.form-control {
            border-radius: 12px;
        }
    </style>
</head>

<body class="py-4">
<div class="container" style="max-width: 900px;">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-0">Sửa booking #<?= htmlspecialchars($booking['booking_code']); ?></h2>
            <small class="text-muted">Cập nhật thông tin khách hàng và tour</small>
        </div>
        <a href="?act=booking-list" class="btn btn-outline-secondary">← Danh sách booking</a>
    </div>

    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $e): ?>
                <div>- <?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <div class="card card-custom">
        <div class="card-body p-4">

            <form action="?act=booking-update" method="POST" class="row g-3">
                <input type="hidden" name="id" value="<?= $booking['id'] ?>">

                <div class="col-md-6">
                    <label class="form-label">Tên khách hàng</label>
                    <input name="customer_name" class="form-control"
                           value="<?= htmlspecialchars($booking['customer_name']) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Số điện thoại</label>
                    <input name="phone" class="form-control"
                           value="<?= htmlspecialchars($booking['phone']) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" class="form-control"
                           value="<?= htmlspecialchars($booking['email']) ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Người lớn</label>
                    <input type="number" name="adult" id="adult" class="form-control" min="1"
                           value="<?= (int)$booking['adult'] ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Trẻ em</label>
                    <!-- dùng đúng cột child trong DB -->
                    <input type="number" name="child" id="child" class="form-control" min="0"
                           value="<?= (int)$booking['child'] ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Giá tour (1 người lớn)</label>
                    <!-- chỉ dùng để tính lại total nếu muốn, không lưu DB -->
                    <input type="number" id="price" class="form-control" min="0" value="0">
                </div>

                <div class="col-md-8">
                    <label class="form-label">Tổng tiền</label>
                    <input type="number" readonly name="total_price" id="total_price"
                           class="form-control"
                           value="<?= (float)$booking['total_price'] ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Ngày bắt đầu</label>
                    <input type="date" name="start_date" class="form-control"
                           value="<?= htmlspecialchars($booking['start_date']) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Ngày kết thúc</label>
                    <input type="date" name="end_date" class="form-control"
                           value="<?= htmlspecialchars($booking['end_date']) ?>">
                </div>

                <div class="col-12">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="note" class="form-control" rows="3"><?= htmlspecialchars($booking['note']) ?></textarea>
                </div>

                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                    <a href="?act=booking-list" class="btn btn-outline-secondary">Hủy</a>
                    <button class="btn btn-primary">Cập nhật</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    function calcTotal() {
        const adult = +document.getElementById('adult').value || 0;
        const child = +document.getElementById('child').value || 0;
        const price = +document.getElementById('price').value || 0;

        const total = adult * price + child * (price * 0.7);
        if (price > 0) {
            document.getElementById('total_price').value = Math.round(total);
        }
    }

    ['adult', 'child', 'price'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', calcTotal);
    });
</script>

</body>
</html>

<?php
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Thêm Booking</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
<div class="container" style="max-width:900px">

    <div class="d-flex justify-content-between mb-3">
        <h2>Thêm booking mới</h2>
        <a class="btn btn-outline-secondary" href="?act=booking-list">← Danh sách</a>
    </div>

    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach($_SESSION['errors'] as $e): ?>
                <div>- <?= htmlspecialchars($e) ?></div>
            <?php endforeach; unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="?act=booking-save" class="row g-3 card p-3">

        <div class="col-md-6">
            <label>Tên khách</label>
            <input name="customer_name" class="form-control" value="<?= htmlspecialchars($old['customer_name'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label>Tour</label>
            <select name="tour_id" id="tour_select" class="form-control">
                <option value="">-- Chọn tour --</option>
                <?php foreach($tours as $t): ?>
                    <option 
                        value="<?= $t['id'] ?>"
                        data-price="<?= $t['price'] ?>"
                        data-price-child="<?= $t['price_child'] ?? 0 ?>"
                    >
                        <?= htmlspecialchars($t['name']) ?> - <?= number_format($t['price']) ?> đ
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label>Phone</label>
            <input name="phone" class="form-control" value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label>Email</label>
            <input name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
        </div>

        <div class="col-md-3">
            <label>Người lớn</label>
            <input type="number" name="adult" id="adult" class="form-control" value="<?= $old['adult'] ?? 1 ?>" min="1">
        </div>

        <div class="col-md-3">
            <label>Trẻ em</label>
            <input type="number" name="child" id="child" class="form-control" value="<?= $old['child'] ?? 0 ?>" min="0">
        </div>

        <div class="col-md-4">
            <label>Giá tour (1 khách)</label>
            <input type="number" id="price" name="price" class="form-control" value="<?= $old['price'] ?? 0 ?>">
        </div>

        <div class="col-md-8">
            <label>Tổng tiền</label>
            <input readonly name="total_price" id="total_price" class="form-control" value="<?= $old['total_price'] ?? 0 ?>">
        </div>

        <div class="col-md-6">
            <label>Ngày bắt đầu</label>
            <input type="date" name="start_date" class="form-control" value="<?= $old['start_date'] ?? '' ?>">
        </div>

        <div class="col-md-6">
            <label>Ngày kết thúc</label>
            <input type="date" name="end_date" class="form-control" value="<?= $old['end_date'] ?? '' ?>">
        </div>

        <div class="col-12">
            <label>Ghi chú</label>
            <textarea name="note" class="form-control"><?= htmlspecialchars($old['note'] ?? '') ?></textarea>
        </div>

        <div class="col-12 text-end">
            <a class="btn btn-secondary" href="?act=booking-list">Hủy</a>
            <button class="btn btn-primary">Lưu booking</button>
        </div>

    </form>
</div>

<script>
function calcTotal() {
    const adult = +document.getElementById('adult').value || 0;
    const child = +document.getElementById('child').value || 0;
    const price = +document.getElementById('price').value || 0;

    const total = adult * price + child * (price * 0.7); // trẻ em 70%
    document.getElementById('total_price').value = Math.round(total);
}

// khi chọn tour → cập nhật giá tour
document.getElementById('tour_select').addEventListener('change', function() {
    const p = this.options[this.selectedIndex].dataset.price || 0;
    document.getElementById('price').value = p;
    calcTotal();
});

// khi thay đổi số lượng
['adult','child','price'].forEach(id =>
    document.getElementById(id).addEventListener('input', calcTotal)
);

calcTotal();
</script>

</body>
</html>

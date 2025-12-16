<?php
// views/booking/edit.php
// Biến có sẵn:
// $booking   (bookings)
// $customers (booking_customers)
// $tours     (tours)

include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>
<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">
<div class="container-fluid px-4">
    <h3 class="mt-4 mb-4">Sửa Booking</h3>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if ($booking['status'] === 'done'): ?>
        <div class="alert alert-info">
            Booking đã <strong>HOÀN TẤT</strong> – không thể chỉnh sửa
        </div>
    <?php endif; ?>

    <div class="card shadow-sm p-4">

        <form action="?act=booking-update" method="POST" id="bookingForm">
            <input type="hidden" name="id" value="<?= $booking['id'] ?>">

            <!-- ================= DANH SÁCH KHÁCH ================= -->
            <div class="mb-4">
                <label class="form-label fw-bold">
                    Danh sách khách hàng <span class="text-danger">(tối thiểu 5)</span>
                </label>

                <div id="customer-list">

                    <?php foreach ($customers as $index => $c): ?>
                    <div class="row g-2 mb-2 customer-item">
                        <div class="col-md-3">
                            <input type="text" name="customer_name[]"
                                   class="form-control"
                                   value="<?= htmlspecialchars($c['name']) ?>" required>
                        </div>
                        <div class="col-md-3">
                            <input type="email" name="email[]"
                                   class="form-control"
                                   value="<?= htmlspecialchars($c['email']) ?>" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="phone[]"
                                   class="form-control"
                                   value="<?= htmlspecialchars($c['phone']) ?>" required>
                        </div>
                        <div class="col-md-2">
                            <select name="type[]" class="form-select customer-type">
                                <option value="adult" <?= $c['type']=='adult'?'selected':'' ?>>Người lớn</option>
                                <option value="child" <?= $c['type']=='child'?'selected':'' ?>>Trẻ em</option>
                            </select>
                        </div>
                        <div class="col-md-1 d-flex align-items-center">
                            <?php if ($index === 0): ?>
                                <button type="button" class="btn btn-success btn-add">+</button>
                            <?php else: ?>
                                <button type="button" class="btn btn-danger btn-remove">×</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- ================= TOUR ================= -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tour *</label>
                    <select name="tour_id" id="tour_select" class="form-select" required>
                        <?php foreach ($tours as $tour): ?>
                            <option value="<?= $tour['id'] ?>"
                                    data-price="<?= $tour['price'] ?>"
                                    <?= $tour['id']==$booking['tour_id']?'selected':'' ?>>
                                <?= $tour['name'] ?> - <?= number_format($tour['price']) ?>đ
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Ngày khởi hành *</label>
                    <input type="date" name="start_date"
                           class="form-control"
                           value="<?= $booking['start_date'] ?>" required>
                </div>
            </div>

            <!-- ================= THỐNG KÊ ================= -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Người lớn</label>
                    <input type="number" id="adult" name="adult"
                           class="form-control" readonly
                           value="<?= $booking['adult'] ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Trẻ em</label>
                    <input type="number" id="child" name="child"
                           class="form-control" readonly
                           value="<?= $booking['child'] ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Tổng tiền</label>
                    <input type="number" id="total_price" name="total_price"
                           class="form-control" readonly
                           value="<?= $booking['total_price'] ?>">
                </div>
            </div>

            <!-- ================= NGÀY KẾT THÚC ================= -->
            <div class="mb-3">
                <label class="form-label fw-bold">Ngày kết thúc *</label>
                <input type="date" name="end_date"
                       class="form-control"
                       value="<?= $booking['end_date'] ?>" required>
            </div>

            <!-- ================= GHI CHÚ ================= -->
            <div class="mb-3">
                <label class="form-label fw-bold">Ghi chú</label>
                <textarea name="note" class="form-control"
                          rows="3"><?= htmlspecialchars($booking['note']) ?></textarea>
            </div>

            <!-- ================= ACTION ================= -->
            <div>
                <button type="submit" class="btn btn-success px-4">
                    Cập nhật Booking
                </button>
                <a href="?act=booking-list" class="btn btn-secondary px-4">
                    Quay lại
                </a>
            </div>

        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

<script>
/* ---------- ĐẾM KHÁCH & TÍNH TIỀN ---------- */
function recalc() {
    const types = document.querySelectorAll('.customer-type');
    let adult = 0, child = 0;

    types.forEach(t => {
        if (t.value === 'adult') adult++;
        else child++;
    });

    document.getElementById('adult').value = adult;
    document.getElementById('child').value = child;

    const selected = document.querySelector('#tour_select option:checked');
    const price = selected ? +selected.dataset.price : 0;

    document.getElementById('total_price').value =
        adult * price + child * (price * 0.7);
}

document.getElementById('tour_select').addEventListener('change', recalc);

/* ---------- THÊM / XOÁ KHÁCH ---------- */
document.addEventListener('click', function (e) {

    if (e.target.classList.contains('btn-add')) {
        const div = document.createElement('div');
        div.className = 'row g-2 mb-2 customer-item';

        div.innerHTML = `
            <div class="col-md-3">
                <input type="text" name="customer_name[]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <input type="email" name="email[]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="phone[]" class="form-control" required>
            </div>
            <div class="col-md-2">
                <select name="type[]" class="form-select customer-type">
                    <option value="adult">Người lớn</option>
                    <option value="child">Trẻ em</option>
                </select>
            </div>
            <div class="col-md-1 d-flex align-items-center">
                <button type="button" class="btn btn-danger btn-remove">×</button>
            </div>
        `;

        document.getElementById('customer-list').appendChild(div);
        recalc();
    }

    if (e.target.classList.contains('btn-remove')) {
        const total = document.querySelectorAll('.customer-item').length;
        if (total <= 1) return alert('Booking phải có ít nhất 1 khách');

        e.target.closest('.customer-item').remove();
        recalc();
    }
});

document.addEventListener('change', function (e) {
    if (e.target.classList.contains('customer-type')) {
        recalc();
    }
});

/* ---------- KHOÁ FORM KHI DONE ---------- */
<?php if ($booking['status'] === 'done'): ?>
document.querySelectorAll('input, select, textarea, button')
    .forEach(el => el.disabled = true);
<?php endif; ?>
</script>

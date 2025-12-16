<?php 
include_once __DIR__ . '/../layout/header.php'; 
 include_once __DIR__ . '/../layout/sidebar.php'; 
?>
<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">
<div class="container-fluid px-4">
    <h3 class="mt-4 mb-4">Thêm Booking</h3>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm p-4">

        <!-- ⚠️ SỬA ACTION -->
        <form action="?act=booking-save" method="POST" id="bookingForm">

            <!-- ================= DANH SÁCH KHÁCH ================= -->
            <div class="mb-4">
                <label class="form-label fw-bold">
                    Danh sách khách hàng <span class="text-danger">(tối thiểu 5)</span>
                </label>

                <div id="customer-list">

                    <!-- KHÁCH 1 -->
                    <div class="row g-2 mb-2 customer-item">
                        <div class="col-md-3">
                            <input type="text" name="customer_name[]" class="form-control"
                                   placeholder="Tên khách hàng" required>
                        </div>
                        <div class="col-md-3">
                            <input type="email" name="email[]" class="form-control"
                                   placeholder="Email" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="phone[]" class="form-control"
                                   placeholder="Số điện thoại" required>
                        </div>
                        <div class="col-md-2">
                            <select name="type[]" class="form-select customer-type">
                                <option value="adult">Người lớn</option>
                                <option value="child">Trẻ em</option>
                            </select>
                        </div>
                        <div class="col-md-1 d-flex align-items-center">
                            <button type="button" class="btn btn-success btn-add">+</button>
                        </div>
                    </div>

                </div>

                <small class="text-muted">
                    * Bấm dấu <strong>+</strong> để thêm khách hàng
                </small>
            </div>

            <!-- ================= TOUR ================= -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tour *</label>
                    <select name="tour_id" id="tour_select" class="form-select" required>
                        <option value="">-- Chọn Tour --</option>
                        <?php foreach ($tours as $tour): ?>
                            <option value="<?= $tour['id'] ?>"
                                    data-price="<?= $tour['price'] ?>">
                                <?= $tour['name'] ?> - <?= number_format($tour['price']) ?>đ
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Ngày khởi hành *</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
            </div>

            <!-- ================= THỐNG KÊ ================= -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Người lớn</label>
                    <input type="number" id="adult" name="adult"
                           class="form-control" readonly value="1">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Trẻ em</label>
                    <input type="number" id="child" name="child"
                           class="form-control" readonly value="0">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Tổng tiền</label>
                    <input type="number" id="total_price" name="total_price"
                           class="form-control" readonly value="0">
                </div>
            </div>

            <!-- ================= NGÀY KẾT THÚC ================= -->
            <div class="mb-3">
                <label class="form-label fw-bold">Ngày kết thúc *</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>

            <!-- ================= GHI CHÚ ================= -->
            <div class="mb-3">
                <label class="form-label fw-bold">Ghi chú</label>
                <textarea name="note" class="form-control" rows="3"></textarea>
            </div>

            <!-- ================= ACTION ================= -->
            <div>
                <button type="submit" class="btn btn-success px-4">
                    Lưu Booking
                </button>
                <a href="?act=booking-list" class="btn btn-secondary px-4">
                    Hủy
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

/* ---------- VALIDATE ≥ 5 KHÁCH ---------- */
document.getElementById('bookingForm').addEventListener('submit', function (e) {
    const totalCustomer = document.querySelectorAll('.customer-item').length;
    if (totalCustomer < 5) {
        alert('Booking phải có tối thiểu 5 khách hàng');
        e.preventDefault();
    }
});
</script>

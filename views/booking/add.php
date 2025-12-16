<?php 
include_once __DIR__ . '/../layout/header.php'; 
include_once __DIR__ . '/../layout/sidebar.php'; 
?>

<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1">Thêm Booking</h3>
                    <div class="text-muted">Tạo booking tour mới</div>
                </div>
                <a href="?act=booking-list" class="btn btn-secondary">
                    ← Quay lại
                </a>
            </div>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="?act=booking-save" method="POST" id="bookingForm">
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <!-- ================= KHÁCH HÀNG ================= -->
                        <h5 class="mb-3">Danh sách khách hàng <span class="text-danger">(tối thiểu 5)</span></h5>

                        <div id="customer-list">
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

                        <small class="text-muted d-block mb-4">
                            * Nhấn <strong>+</strong> để thêm khách
                        </small>

                        <!-- ================= TOUR ================= -->
                        <h5 class="mb-3">Thông tin tour</h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tour *</label>
                                <select name="tour_id" id="tour_select" class="form-select" required>
                                    <option value="">-- Chọn tour --</option>
                                    <?php foreach ($tours as $tour): ?>
                                        <option value="<?= $tour['id'] ?>"
                                                data-price="<?= $tour['price'] ?>">
                                            <?= $tour['name'] ?> (<?= number_format($tour['price']) ?>đ)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Ngày khởi hành *</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                        </div>

                        <!-- ================= THỐNG KÊ ================= -->
                        <h5 class="mb-3">Thống kê</h5>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Người lớn</label>
                                <input type="number" id="adult" name="adult" class="form-control" readonly value="1">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Trẻ em</label>
                                <input type="number" id="child" name="child" class="form-control" readonly value="0">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tổng tiền</label>
                                <input type="number" id="total_price" name="total_price" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- ================= THỜI GIAN ================= -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Ngày kết thúc *</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                        </div>

                        <!-- ================= GHI CHÚ ================= -->
                        <div class="mb-4">
                            <label class="form-label">Ghi chú</label>
                            <textarea name="note" class="form-control" rows="3"></textarea>
                        </div>

                        <!-- ================= ACTION ================= -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                Lưu booking
                            </button>
                            <a href="?act=booking-list" class="btn btn-outline-secondary px-4">
                                Hủy
                            </a>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

<?php include_once __DIR__ . '/../layout/header.php'; ?>
<?php include_once __DIR__ . '/../layout/sidebar.php'; ?>

<div class="main-wrapper">
  <div class="page-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="mb-1">Chi tiết khách hàng</h2>
        <p class="text-muted mb-0">Thông tin được đồng bộ từ booking</p>
      </div>
      <a href="?act=customer-list" class="btn btn-secondary">Quay lại danh sách</a>
    </div>

    <div class="row g-4">
      <div class="col-lg-6">
        <div class="border rounded-3 p-4 h-100">
          <h5 class="fw-semibold mb-3">Thông tin liên hệ</h5>
          <p class="mb-2"><strong>Họ tên:</strong> <?= htmlspecialchars($customer['name']) ?></p>
          <p class="mb-2"><strong>Email:</strong> <?= htmlspecialchars($customer['email']) ?></p>
          <p class="mb-2"><strong>Số điện thoại:</strong> <?= htmlspecialchars($customer['phone']) ?></p>
          <p class="mb-0"><strong>Loại khách:</strong>
            <span class="badge <?= $customer['type'] === 'adult' ? 'bg-success' : 'bg-info' ?>">
              <?= $customer['type'] === 'adult' ? 'Người lớn' : 'Trẻ em' ?>
            </span>
          </p>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="border rounded-3 p-4 h-100">
          <h5 class="fw-semibold mb-3">Thông tin booking</h5>
          <p class="mb-2"><strong>Mã booking:</strong>
            <span class="badge bg-primary"><?= htmlspecialchars($customer['booking_code']) ?></span>
          </p>
          <p class="mb-2"><strong>Tour:</strong> <?= htmlspecialchars($customer['tour_name'] ?? 'Chưa rõ') ?></p>
          <p class="mb-2"><strong>Mã tour:</strong> <?= htmlspecialchars($customer['tour_code'] ?? '-') ?></p>
          <p class="mb-2"><strong>Ngày đi:</strong> <?= htmlspecialchars($customer['start_date']) ?></p>
          <p class="mb-2"><strong>Ngày về:</strong> <?= htmlspecialchars($customer['end_date']) ?></p>
          <p class="mb-0"><strong>Trạng thái booking:</strong>
            <span class="badge bg-<?= $customer['status'] === 'done' ? 'success' : ($customer['status'] === 'cancel' ? 'danger' : 'warning') ?>">
              <?= htmlspecialchars($customer['status'] ?? 'pending') ?>
            </span>
          </p>
        </div>
      </div>
    </div>

    <?php if (!empty($customer['note'])): ?>
      <div class="border rounded-3 p-4 mt-4">
        <h5 class="fw-semibold mb-3">Ghi chú booking</h5>
        <p class="mb-0"><?= nl2br(htmlspecialchars($customer['note'])) ?></p>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

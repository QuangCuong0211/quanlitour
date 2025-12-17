<?php
// views/guide/customer-list.php - Danh sách khách hàng + điểm danh
$act = 'hdv-customers';

ob_start();
?>

<h4 class="mb-4 text-success fw-bold">
    <i class="fas fa-users"></i> Danh sách khách hàng - Tour: <?= htmlspecialchars($departure['tour_name']) ?>
</h4>
<p class="text-muted mb-4">
    <i class="fas fa-calendar-alt"></i> Ngày khởi hành: <?= date('d/m/Y', strtotime($departure['departure_date'])) ?>
    &nbsp; | &nbsp;
    <i class="fas fa-bus"></i> Mã tour: <?= htmlspecialchars($departure['tour_id'] ?? $departure['id']) ?>
</p>

<?php if (count($customers) > 0): ?>
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-success">
                <tr>
                    <th width="5%">STT</th>
                    <th width="20%">Họ tên</th>
                    <th width="10%">Loại khách</th>
                    <th width="15%">Phone</th>
                    <th width="20%">Email</th>
                    <th width="12%">Mã booking</th>
                    <th width="10%">Trạng thái điểm danh</th>
                    <th width="8%">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; foreach ($customers as $cust): ?>
                <tr>
                    <td class="text-center"><?= $stt++ ?></td>
                    <td><strong><?= htmlspecialchars($cust['name']) ?></strong></td>
                    <td class="text-center">
                        <span class="badge bg-<?= $cust['type'] == 'adult' ? 'primary' : 'warning' ?> px-3 py-2">
                            <?= $cust['type'] == 'adult' ? 'Người lớn' : 'Trẻ em' ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($cust['phone'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($cust['email'] ?? '-') ?></td>
                    <td class="text-center"><?= htmlspecialchars($cust['booking_code']) ?></td>
                    <td class="text-center">
                        <?php if ($cust['attended'] ?? 0): ?>
                            <span class="badge bg-success fs-6 px-3 py-2">Đã điểm danh</span>
                        <?php else: ?>
                            <span class="badge bg-secondary fs-6 px-3 py-2">Chưa điểm danh</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if (!($cust['attended'] ?? 0)): ?>
                        <form action="index.php?act=hdv-attendance" method="POST" style="display:inline;">
                            <input type="hidden" name="bc_id" value="<?= $cust['bc_id'] ?>">
                            <input type="hidden" name="departure_id" value="<?= $departure['id'] ?>">
                            <button type="submit" 
                                    class="btn btn-success btn-sm px-4" 
                                    onclick="return confirm('Xác nhận điểm danh cho khách:\n<?= htmlspecialchars($cust['name']) ?>?')">
                                <i class="fas fa-check me-1"></i> Điểm danh
                            </button>
                        </form>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-sm px-4" disabled>
                                <i class="fas fa-check me-1"></i> Đã điểm danh
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Nút quay lại -->
<div class="mt-4 text-center">
    <a href="javascript:history.back()" class="btn btn-outline-secondary btn-lg px-5">
        <i class="fas fa-arrow-left me-2"></i> Quay lại
    </a>
</div>

<?php else: ?>
<div class="alert alert-info text-center p-5 rounded-4 shadow">
    <i class="fas fa-users-slash fa-4x mb-4 text-info"></i>
    <h4>Chưa có khách hàng nào đặt tour này</h4>
    <p class="lead text-muted">Danh sách sẽ hiển thị khi có booking được xác nhận.</p>
</div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require "views/guide/layout.php";
?>
<?php
// views/guide/customer-list.php
$act = 'hdv-customers';

ob_start();
?>

<h4 class="mb-4 text-success fw-bold">
    <i class="fas fa-users"></i> Danh sách khách hàng - Tour: <?= htmlspecialchars($departure['tour_name']) ?>
</h4>
<p class="text-muted">
    <i class="fas fa-calendar"></i> Ngày khởi hành: <?= date('d/m/Y', strtotime($departure['departure_date'])) ?>
    &nbsp; | &nbsp;
    <i class="fas fa-bus"></i> Mã tour: <?= htmlspecialchars($departure['tour_id'] ?? $departure['id']) ?>
</p>

<?php if (count($customers) > 0): ?>
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-success">
                <tr>
                    <th>STT</th>
                    <th>Họ tên</th>
                    <th>Loại khách</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Mã booking</th>
                    <th>Trạng thái điểm danh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; foreach ($customers as $cust): ?>
                <tr>
                    <td><?= $stt++ ?></td>
                    <td><strong><?= htmlspecialchars($cust['name']) ?></strong></td>
                    <td>
                        <span class="badge bg-<?= $cust['type'] == 'adult' ? 'primary' : 'warning' ?>">
                            <?= $cust['type'] == 'adult' ? 'Người lớn' : 'Trẻ em' ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($cust['phone'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($cust['email'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($cust['booking_code']) ?></td>
                    <td>
                        <?php if ($cust['attended'] ?? 0): ?>
                            <span class="badge bg-success">Đã điểm danh</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Chưa điểm danh</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!($cust['attended'] ?? 0)): ?>
                        <form action="index.php?act=hdv-attendance" method="POST" style="display:inline;">
                            <input type="hidden" name="bc_id" value="<?= $cust['bc_id'] ?>">
                            <input type="hidden" name="departure_id" value="<?= $departure['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Điểm danh khách: <?= htmlspecialchars($cust['name']) ?>?')">
                                <i class="fas fa-check"></i> Điểm danh
                            </button>
                        </form>
                        <?php else: ?>
                            <button class="btn btn-sm btn-secondary" disabled>Đã điểm danh</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 text-center">
    <a href="javascript:history.back()" class="btn btn-outline-secondary px-5">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
</div>

<?php else: ?>
<div class="alert alert-info text-center p-5">
    <i class="fas fa-users-slash fa-3x mb-3"></i>
    <h4>Chưa có khách hàng nào đặt tour này</h4>
</div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require "views/guide/layout.php";
?>
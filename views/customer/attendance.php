<?php
function flashMessage(string $key): void
{
    if (empty($_SESSION[$key])) {
        return;
    }

    $color  = $key === 'success' ? '#d4edda' : '#f8d7da';
    $border = $key === 'success' ? '#c3e6cb' : '#f5c6cb';
    $text   = $key === 'success' ? '#155724' : '#721c24';

    echo "<div style='background:$color;color:$text;padding:15px;margin-bottom:20px;" .
         "border-radius:8px;border:1px solid $border;max-width:1400px;margin:0 auto 20px;'>" .
         htmlspecialchars($_SESSION[$key]) .
         '</div>';
    unset($_SESSION[$key]);
}

$presentCount = 0;
$absentCount  = 0;
$pendingCount = 0;

foreach ($customers as $customer) {
    switch ($customer['attendance_status']) {
        case 'present':
            $presentCount++;
            break;
        case 'absent':
            $absentCount++;
            break;
        default:
            $pendingCount++;
            break;
    }
}

include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
    <?php flashMessage('success'); ?>
    <?php flashMessage('error'); ?>

    <div class="page-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Điểm danh khách hàng</h2>
            <div class="d-flex gap-2">
                <a href="?act=booking-list" class="btn btn-secondary btn-sm">Quay lại danh sách booking</a>
                <a href="?act=booking-detail&id=<?= $booking['id'] ?>" class="btn btn-outline-info btn-sm">Xem chi tiết booking</a>
            </div>
        </div>

        <div class="border rounded p-3 mb-4 bg-light">
            <div class="row g-3">
                <div class="col-md-3">
                    <span class="text-muted d-block">Mã booking</span>
                    <span class="badge bg-primary fs-6"><?= htmlspecialchars($booking['booking_code']) ?></span>
                </div>
                <div class="col-md-3">
                    <span class="text-muted d-block">Ngày đi</span>
                    <strong><?= htmlspecialchars($booking['start_date']) ?></strong>
                </div>
                <div class="col-md-3">
                    <span class="text-muted d-block">Ngày về</span>
                    <strong><?= htmlspecialchars($booking['end_date']) ?></strong>
                </div>
                <div class="col-md-3">
                    <span class="text-muted d-block">Trạng thái</span>
                    <span class="badge bg-dark text-uppercase"><?= htmlspecialchars($booking['status'] ?? 'pending') ?></span>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="p-3 border rounded text-center h-100 bg-white">
                    <div class="text-muted">Đã đến</div>
                    <div class="fs-3 text-success fw-bold" id="present-count">
                        <?= $presentCount ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 border rounded text-center h-100 bg-white">
                    <div class="text-muted">Vắng mặt</div>
                    <div class="fs-3 text-danger fw-bold" id="absent-count">
                        <?= $absentCount ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 border rounded text-center h-100 bg-white">
                    <div class="text-muted">Chưa điểm danh</div>
                    <div class="fs-3 text-secondary fw-bold" id="pending-count">
                        <?= $pendingCount ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if (empty($customers)): ?>
            <div class="alert alert-warning">Booking này chưa có khách để điểm danh.</div>
        <?php else: ?>
            <form method="post" action="?act=customer-attendance-update" id="attendance-form">
                <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Danh sách khách hàng</h4>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="check-all">Chọn tất cả</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="uncheck-all">Bỏ chọn</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th style="width: 80px;">Có mặt</th>
                                <th>Tên khách</th>
                                <th>Điện thoại</th>
                                <th>Email</th>
                                <th>Loại</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $cust): ?>
                                <?php
                                $status = $cust['attendance_status'] ?? 'pending';
                                $isPresent = $status === 'present';
                                $badgeClass = 'bg-secondary';
                                $label = 'Chưa điểm danh';

                                if ($status === 'present') {
                                    $badgeClass = 'bg-success';
                                    $label = 'Đã đến';
                                } elseif ($status === 'absent') {
                                    $badgeClass = 'bg-danger';
                                    $label = 'Vắng mặt';
                                }
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <input
                                            type="checkbox"
                                            class="form-check-input attendance-toggle"
                                            name="attendance[]"
                                            value="<?= $cust['id'] ?>"
                                            <?= $isPresent ? 'checked' : '' ?>
                                        >
                                    </td>
                                    <td><?= htmlspecialchars($cust['name']) ?></td>
                                    <td><?= htmlspecialchars($cust['phone']) ?></td>
                                    <td><?= htmlspecialchars($cust['email']) ?></td>
                                    <td class="text-center">
                                        <span class="badge <?= $cust['type'] === 'adult' ? 'bg-success' : 'bg-info' ?>">
                                            <?= $cust['type'] === 'adult' ? 'Người lớn' : 'Trẻ em' ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge <?= $badgeClass ?> status-badge" data-default="<?= $badgeClass ?>">
                                            <?= $label ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">Lưu điểm danh</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<script>
    const attendanceRows = document.querySelectorAll('#attendance-form tbody tr');
    const presentCounter = document.getElementById('present-count');
    const absentCounter  = document.getElementById('absent-count');
    const pendingCounter = document.getElementById('pending-count');

    function updateCounters() {
        let present = 0;
        let total   = attendanceRows.length;
        let pending = 0;

        attendanceRows.forEach(row => {
            const checkbox = row.querySelector('.attendance-toggle');
            const badge    = row.querySelector('.status-badge');

            if (checkbox.checked) {
                present++;
                badge.classList.remove('bg-danger', 'bg-secondary');
                badge.classList.add('bg-success');
                badge.textContent = 'Đã đến';
            } else {
                const defaultStatus = badge.getAttribute('data-default');
                if (defaultStatus === 'bg-secondary') {
                    pending++;
                    badge.classList.remove('bg-success', 'bg-danger');
                    badge.classList.add('bg-secondary');
                    badge.textContent = 'Chưa điểm danh';
                } else {
                    badge.classList.remove('bg-success', 'bg-secondary');
                    badge.classList.add('bg-danger');
                    badge.textContent = 'Vắng mặt';
                }
            }
        });

        const absent = total - present - pending;

        presentCounter.textContent = present;
        absentCounter.textContent  = Math.max(absent, 0);
        pendingCounter.textContent = pending;
    }

    document.querySelectorAll('.attendance-toggle').forEach(checkbox => {
        checkbox.addEventListener('change', updateCounters);
    });

    document.getElementById('check-all')?.addEventListener('click', () => {
        document.querySelectorAll('.attendance-toggle').forEach(checkbox => {
            checkbox.checked = true;
        });
        updateCounters();
    });

    document.getElementById('uncheck-all')?.addEventListener('click', () => {
        document.querySelectorAll('.attendance-toggle').forEach(checkbox => {
            checkbox.checked = false;
        });
        updateCounters();
    });

    updateCounters();
</script>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>

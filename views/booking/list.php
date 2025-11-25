<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách Booking</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">

    <style>
        body { background: #f3f4f6; font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        .nowrap { white-space: nowrap; }
        .note-cell { max-width: 260px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .admin-note-cell { max-width: 300px; word-wrap: break-word; }
    </style>
</head>
<body class="py-4">
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Danh sách Booking</h2>
        <div class="d-flex gap-2">
            <a href="?act=admin" class="btn btn-secondary">Quay về Dashboard</a>
            <a href="?act=booking-add" class="btn btn-primary">+ Thêm booking</a>
        </div>
    </div>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-dark text-center">
            <tr>
                <th class="nowrap">ID</th>
                <th class="nowrap">Mã</th>
                <th class="nowrap">Khách hàng</th>
                <th class="nowrap">Phone</th>
                <th class="nowrap">Email</th>
                <th class="nowrap">Người lớn</th>
                <th class="nowrap">Trẻ em</th>
                <th class="nowrap">Tổng tiền</th>
                <th class="nowrap">Ngày đi</th>
                <th class="nowrap">Ngày về</th>
                <th class="nowrap">Ghi chú khách</th>
                <th class="nowrap">Hướng dẫn viên</th>
                <th class="nowrap">Ghi chú Admin</th> <!-- CỘT MỚI -->
                <th class="nowrap">Hành động</th>
            </tr>
            </thead>

            <tbody>
            <?php if (!empty($bookings)): ?>
                <?php $stt = 1; foreach ($bookings as $item): ?>
                    <?php
                    // HDV
                    $guide_name = "Chưa phân bổ"; $guide_note = "";
                    if (!empty($item['guide_id'])) {
                        $guide = pdo_query_one("SELECT name FROM users WHERE id = ?", $item['guide_id']);
                        if ($guide) {
                            $guide_name = htmlspecialchars($guide['name']);
                            $guide_note = $item['guide_note'] ? "<br><small class='text-muted'>(" . htmlspecialchars($item['guide_note']) . ")</small>" : "";
                        } else $guide_name = "<span class='text-danger'>HDV đã xóa</span>";
                    }
                    ?>
                    <tr>
                        <td class="text-center nowrap"><?= $stt++; ?></td>
                        <td class="nowrap"><span class="badge bg-primary"><?= htmlspecialchars($item['booking_code']); ?></span></td>
                        <td class="nowrap"><?= htmlspecialchars($item['customer_name']); ?></td>
                        <td class="nowrap"><?= htmlspecialchars($item['phone']); ?></td>
                        <td class="nowrap"><?= htmlspecialchars($item['email']); ?></td>
                        <td class="text-center nowrap"><?= (int)$item['adult']; ?></td>
                        <td class="text-center nowrap"><?= isset($item['children']) ? (int)$item['children'] : (int)($item['child'] ?? 0); ?></td>
                        <td class="text-end text-danger fw-bold nowrap"><?= number_format($item['total_price']); ?> đ</td>
                        <td class="text-center nowrap"><?= htmlspecialchars($item['start_date']); ?></td>
                        <td class="text-center nowrap"><?= htmlspecialchars($item['end_date']); ?></td>
                        <td class="note-cell"><?= htmlspecialchars($item['note']); ?></td>

                        <!-- HDV -->
                        <td class="text-center">
                            <?php if (!empty($item['guide_id'])): ?>
                                <strong class="text-success"><?= $guide_name ?></strong><?= $guide_note ?>
                            <?php else: ?>
                                <span class="text-danger">Chưa phân bổ</span>
                            <?php endif; ?>
                        </td>

                        <!-- GHI CHÚ ADMIN -->
                        <td class="admin-note-cell">
                            <?php if (!empty($item['admin_note'])): ?>
                                <span class="text-primary"><?= nl2br(htmlspecialchars($item['admin_note'])) ?></span>
                            <?php else: ?>
                                <span class="text-muted">Chưa có</span>
                            <?php endif; ?>
                        </td>

                        <!-- HÀNH ĐỘNG -->
                        <td class="text-center nowrap">
                            <button type="button" class="btn btn-info btn-sm text-white me-1" data-bs-toggle="modal" data-bs-target="#guideModal"
                                    onclick="openGuideModal(<?= $item['id'] ?>, <?= $item['guide_id'] ?? 'null' ?>, <?= $item['guide_note'] ? "'".addslashes(htmlspecialchars($item['guide_note']))."'" : 'null' ?>)">
                                HDV
                            </button>

                            <button type="button" class="btn btn-secondary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#noteModal"
                                    onclick="openNoteModal(<?= $item['id'] ?>, <?= $item['admin_note'] ? "'".addslashes(htmlspecialchars($item['admin_note']))."'" : 'null' ?>)">
                                Ghi chú
                            </button>

                            <a href="?act=booking-edit&id=<?= $item['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="?act=booking-delete&id=<?= $item['id']; ?>" onclick="return confirm('Xóa thật không?')" class="btn btn-danger btn-sm">Xóa</a>
                            <a href="?act=booking-issues&booking_id=<?= $item['id'] ?>" class="btn btn-danger btn-sm">Sự cố</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="14" class="text-center text-muted p-3">Chưa có booking nào!</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Phân bổ HDV (giữ nguyên) -->
<div class="modal fade" id="guideModal" tabindex="-1"> ... </div> <!-- giữ nguyên phần bạn đã có -->

<!-- Modal Ghi chú Admin (MỚI) -->
<div class="modal fade" id="noteModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="index.php?act=booking-save-note" method="post">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">Ghi chú Admin - Booking #<span id="noteBookingId"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="booking_id" id="note_booking_id">
                    <textarea name="admin_note" id="admin_note" class="form-control" rows="8" 
                              placeholder="Ghi chú nội bộ: khách yêu cầu gì, đã gọi chưa, cần nhắc HDV điều gì, xử lý sự cố..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu ghi chú</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openGuideModal(id, guideId, note) {
    document.getElementById('booking_id').value = id;
    document.getElementById('guide_id').value = guideId || '';
    document.getElementById('guide_note').value = note || '';
}
function openNoteModal(id, note) {
    document.getElementById('note_booking_id').value = id;
    document.getElementById('admin_note').value = note || '';
    document.getElementById('noteBookingId').textContent = id;
}
</script>
</body>
</html>
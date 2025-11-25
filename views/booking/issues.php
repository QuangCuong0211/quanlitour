<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xử lý sự cố - Booking #<?= htmlspecialchars($booking['booking_code']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Xử lý sự cố/phản hồi - Booking #<?= htmlspecialchars($booking['booking_code']) ?></h3>
        <a href="?act=booking-list" class="btn btn-secondary">Quay lại danh sách</a>
    </div>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#issueModal">
        Thêm/Xử lý sự cố mới
    </button>

    <div class="row">
        <?php foreach ($issues as $i): ?>
            <div class="col-md-6 mb-3">
                <div class="card border-<?= $i['status']=='resolved'?'success':($i['status']=='processing'?'warning':($i['status']=='rejected'?'danger':'secondary')) ?>">
                    <div class="card-header d-flex justify-content-between">
                        <strong><?= htmlspecialchars($i['title']) ?></strong>
                        <span class="badge bg-<?= $i['status']=='resolved'?'success':($i['status']=='processing'?'warning':($i['status']=='rejected'?'danger':'secondary')) ?>">
                            <?= $i['status']=='pending'?'Chờ xử lý':($i['status']=='processing'?'Đang xử lý':($i['status']=='resolved'?'Đã giải quyết':'Từ chối')) ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><?= nl2br(htmlspecialchars($i['description'])) ?></p>
                        <?php if ($i['attachment']): ?>
                            <a href="uploads/issues/<?= $i['attachment'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                Tải file đính kèm
                            </a>
                        <?php endif; ?>
                        <small class="text-muted d-block mt-2">
                            Bởi: <?= htmlspecialchars($i['creator_name'] ?? 'Admin') ?> - 
                            <?= date('d/m/Y H:i', strtotime($i['created_at'])) ?>
                            <?php if ($i['updated_at'] != $i['created_at']): ?>
                                (cập nhật <?= date('d/m/Y H:i', strtotime($i['updated_at'])) ?>)
                            <?php endif; ?>
                        </small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($issues)): ?>
            <div class="col-12 text-center text-muted py-5">
                <h5>Chưa có phản hồi hoặc sự cố nào</h5>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Thêm/Xử lý sự cố -->
<div class="modal fade" id="issueModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="index.php?act=booking-save-issue" method="post" enctype="multipart/form-data">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Thêm/Xử lý sự cố</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
                    <input type="hidden" name="issue_id" value="0">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiêu đề sự cố</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô tả chi tiết</label>
                        <textarea name="description" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="pending">Chờ xử lý</option>
                            <option value="processing">Đang xử lý</option>
                            <option value="resolved">Đã giải quyết</option>
                            <option value="rejected">Từ chối</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">File đính kèm (hình ảnh, biên bản...)</label>
                        <input type="file" name="attachment" class="form-control" accept=".jpg,.png,.pdf,.doc,.docx">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">Lưu xử lý</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
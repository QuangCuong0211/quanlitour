<!-- views/tour/add.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm tour mới</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body { background:#f3f4f6; }
        .card-shadow { box-shadow:0 10px 25px rgba(0,0,0,0.06); border-radius:18px; }
    </style>
</head>
<body class="py-4">
<div class="container" style="max-width: 900px;">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-1">Thêm tour mới</h2>
            <div class="text-muted">Nhập thông tin tour du lịch</div>
        </div>
        <a href="?act=tour-list" class="btn btn-outline-secondary">
            ← Danh sách tour
        </a>
    </div>

    <?php if (!empty($_GET['error'])): ?>
        <div class="alert alert-danger mb-3">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <div class="card card-shadow border-0">
        <div class="card-body p-4">

            <form action="?act=tour-save" method="post" class="row g-3">

                <div class="col-12">
                    <label class="form-label fw-semibold">Tên tour</label>
                    <input type="text" name="name" class="form-control"
                           placeholder="Ví dụ: Hà Nội - Hạ Long 3N2Đ" required>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Mô tả</label>
                    <textarea name="desc" class="form-control" rows="4"
                              placeholder="Mô tả lịch trình, dịch vụ bao gồm..." required></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Giá tour (1 người lớn)</label>
                    <input type="number" name="price" class="form-control"
                           min="0" value="0" required>
                </div>

                <div class="col-12 d-flex justify-content-end mt-3">
                    <a href="?act=tour-list" class="btn btn-outline-secondary me-2">Hủy</a>
                    <button class="btn btn-primary">Lưu tour</button>
                </div>
            </form>

        </div>
    </div>

</div>
</body>
</html>

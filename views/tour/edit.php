<?php
// views/tour/edit.php

require_once __DIR__ . '/../../commons/env.php';

$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("ID không hợp lệ!");
}

$stmt = $conn->prepare("SELECT id, name, description, price FROM tours WHERE id = ?");
if (!$stmt) {
    die("Lỗi prepare: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$tour = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$tour) {
    die("Tour không tồn tại!");
}

$msg   = $_GET['msg']   ?? '';
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Tour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Sửa Tour</h2>

    <?php if ($msg): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <?= htmlspecialchars($msg) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    <?php endif; ?>

    <form action="?act=tour-update" method="post" class="mt-3">
        <input type="hidden" name="id" value="<?= htmlspecialchars($tour['id']) ?>">

        <div class="mb-3">
            <label class="form-label">Tên Tour</label>
            <input
                type="text"
                name="name"
                class="form-control"
                value="<?= htmlspecialchars($tour['name']) ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea
                name="desc"
                class="form-control"
                rows="4"
                required
            ><?= htmlspecialchars($tour['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá Tour</label>
            <input
                type="number"
                name="price"
                class="form-control"
                value="<?= htmlspecialchars($tour['price']) ?>"
                min="0"
                required
            >
        </div>

        <button class="btn btn-success">Cập nhật</button>
        <a href="?act=tour-list" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

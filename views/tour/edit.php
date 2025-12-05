<?php
require_once "models/TourModel.php";

$id = $_GET['id'] ?? null;
if (!$id) die("Thiếu ID tour!");

$tourModel = new TourModel();
$tour = $tourModel->getTourById($id);

if (!$tour) die("Tour không tồn tại!");

// Map dữ liệu theo đúng tên cột trong DB
$tour_id        = $tour['tour_id'] ?? "";
$name           = $tour['name'] ?? "";
$description    = $tour['description'] ?? "";
$departure_date = $tour['departure_date'] ?? "";
$price          = $tour['price'] ?? "";
$customer       = $tour['customer'] ?? "";
$guide          = $tour['guide'] ?? "";
$status         = $tour['status'] ?? 1;
$note           = $tour['note'] ?? "";
?>

<?php include_once "views/header.php"; ?>

<div class="container mt-4">
    <h3 class="mb-3">Sửa Tour</h3>

    <form action="../../index.php?action=tourUpdate" method="POST" class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Mã Tour *</label>
            <input type="text" name="tour_id" class="form-control" value="<?= $tour_id ?>" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Tên Tour *</label>
            <input type="text" name="name" class="form-control" value="<?= $name ?>" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Ngày đi *</label>
            <input type="date" name="departure_date" class="form-control" value="<?= $departure_date ?>" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Giá *</label>
            <input type="number" name="price" class="form-control" value="<?= $price ?>" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Khách Hàng *</label>
            <input type="text" name="customer" class="form-control" value="<?= $customer ?>" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Hướng Dẫn Viên *</label>
            <input type="text" name="guide" class="form-control" value="<?= $guide ?>" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Trạng Thái *</label>
            <select name="status" class="form-select">
                <option value="1" <?= $status == 1 ? "selected" : "" ?>>Hoạt động</option>
                <option value="0" <?= $status == 0 ? "selected" : "" ?>>Ngừng hoạt động</option>
            </select>
        </div>

        <div class="col-md-12">
            <label class="form-label">Ghi chú</label>
            <textarea name="note" class="form-control" rows="3"><?= $note ?></textarea>
        </div>

        <div class="col-md-12">
            <label class="form-label">Mô Tả *</label>
            <textarea name="description" class="form-control" rows="5" required><?= $description ?></textarea>
        </div>

        <input type="hidden" name="id" value="<?= $tour['id'] ?>">

        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            <a href="../../index.php?action=tourList" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

<?php include_once "views/footer.php"; ?>

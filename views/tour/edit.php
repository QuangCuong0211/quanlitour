<?php
require_once '../models/TourModel.php';

$model = new TourModel();

// Lấy ID từ URL
if (!isset($_GET['id']) || $_GET['id'] <= 0) {
    die("ID không hợp lệ");
}

$id = $_GET['id'];

// Lấy dữ liệu tour
$tour = $model->getTourById($id);
if (!$tour) {
    die("Tour không tồn tại");
}

$errors = [];
$success = "";

// Nếu submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Lấy dữ liệu từ POST để giữ lại nếu sai
    $name  = trim($_POST['name'] ?? '');
    $desc  = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');

    // Validate
    if ($name === "") {
        $errors['name'] = "Tên tour không được để trống";
    }
    if ($desc === "") {
        $errors['description'] = "Mô tả không được để trống";
    }
    if ($price === "") {
        $errors['price'] = "Giá không được để trống";
    } elseif (!is_numeric($price) || $price <= 0) {
        $errors['price'] = "Giá phải là số lớn hơn 0";
    }

    // Nếu không có lỗi → cập nhật
    if (empty($errors)) {
        $result = $model->updateTour($id, $name, $desc, (float)$price);

        if ($result['status'] === 'updated') {
            $success = "Cập nhật thành công!";
            // Cập nhật lại dữ liệu để hiển thị đúng
            $tour = $model->getTourById($id);
        } elseif ($result['status'] === 'nochange') {
            $success = "Không có thay đổi nào!";
        } else {
            $errors['system'] = "Lỗi hệ thống: " . $result['message'];
        }
    }
}

// Nếu chưa submit → gán dữ liệu gốc từ DB
$nameValue  = $_POST['name']         ?? $tour['name'];
$descValue  = $_POST['description']  ?? $tour['description'];
$priceValue = $_POST['price']        ?? $tour['price'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa Tour</title>
    <style>
        .error { color: red; font-size: 14px; }
        .success { color: green; font-size: 16px; }
    </style>
</head>
<body>

<h2>Sửa tour</h2>

<?php if ($success): ?>
    <p class="success"><?= $success ?></p>
<?php endif; ?>

<?php if (isset($errors['system'])): ?>
    <p class="error"><?= $errors['system'] ?></p>
<?php endif; ?>

<form method="POST">

    <label>Tên tour:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($nameValue) ?>"><br>
    <?php if (isset($errors['name'])): ?>
        <span class="error"><?= $errors['name'] ?></span><br>
    <?php endif; ?>
    <br>

    <label>Mô tả:</label><br>
    <textarea name="description" rows="4"><?= htmlspecialchars($descValue) ?></textarea><br>
    <?php if (isset($errors['description'])): ?>
        <span class="error"><?= $errors['description'] ?></span><br>
    <?php endif; ?>
    <br>

    <label>Giá:</label><br>
    <input type="text" name="price" value="<?= htmlspecialchars($priceValue) ?>"><br>
    <?php if (isset($errors['price'])): ?>
        <span class="error"><?= $errors['price'] ?></span><br>
    <?php endif; ?>

    <br><br>
    <button type="submit">Cập nhật</button>
</form>

</body>
</html>

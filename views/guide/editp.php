<h2>Sửa hướng dẫn viên</h2>

<?php
// Đảm bảo biến hdv tồn tại
$hdv = $hdv ?? null;
?>

<?php if (!empty($hdv)) : ?>
<form action="list.php?act=hdv-update" method="POST">

    <input type="hidden" name="id" value="<?= $guide['id'] ?>">

    <label>Tên:</label><br>
    <input type="text" name="name" value="<?= $guide['name'] ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $guide['email'] ?>" required><br><br>

    <label>SĐT:</label><br>
    <input type="text" name="sdt" value="<?= $guide['sdt'] ?>" required><br><br>

    <label>Ngôn ngữ:</label><br>
    <input type="text" name="language" value="<?= $guide['language'] ?>" required><br><br>

    <label>Kinh nghiệm (năm):</label><br>
    <input type="number" name="exp" value="<?= $guide['exp'] ?>" required><br><br>

    <button type="submit">Cập nhật</button>
</form>

<?php else: ?>
    <p>Dữ liệu không tồn tại.</p>
<?php endif; ?>

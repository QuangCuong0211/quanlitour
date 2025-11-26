<h2>Sửa thông tin hdv</h2>

<form action="list.php?act=hdv-update" method="POST">
    <input type="hidden" name="id" value="<?= $guide['id'] ?>">

    <label>Tên:</label><br>
    <input type="text" name="name" value="<?= $guide['name'] ?>" required><br><br>

    <label>SĐT:</label><br>
    <input type="text" name="sdt" value="<?= $guide['sdt'] ?>" required><br><br>

    <label>nn:</label><br>
    <input type="text" name="language" value="<?= $guide['language'] ?>" required><br><br>

    <label>Kinh nghiệm (năm):</label><br>
    <input type="number" name="exp" value="<?= $guide['exp'] ?>" required><br><br>

    <button type="submit">Cập nhật</button>
</form>

<br>
<a href="list.php?act=hdv-list">Quay lại danh sách</a>
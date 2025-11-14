<?php
require "../../config/database.php";

$sql = "SELECT * FROM tour";
$tours = mysqli_query($conn, $sql);
?>

<h2>Danh sách Tour</h2>
<a href="add.php">+ Thêm tour</a>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Tên tour</th>
        <th>Giá</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($tours)) : ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['tour_name'] ?></td>
        <td><?= $row['price'] ?></td>
        <td><?= $row['status'] ?></td>
        <td>
            <a href="edit.php?id=<?= $row['id'] ?>">Sửa</a> |
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Xóa?')">Xóa</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

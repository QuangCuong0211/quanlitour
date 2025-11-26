<h2>Danh sách người dùng</h2>

<a href="../user/list.php">Chuyển sang giao diện user</a>
<br><br>

<a href="index.php?controller=users&action=add">Thêm người dùng</a>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>Email</th>
        <th>SĐT</th>
        <th>Role</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
    </tr>

    <?php foreach($users as $row): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['phone'] ?></td>
        <td><?= $row['role'] ?></td>
        <td>
            <?= $row['status'] == 1 ? 'Đang hoạt động' : 'Bị khóa' ?>
        </td>
        <td>
            <a href="index.php?controller=users&action=edit&id=<?= $row['id'] ?>">Sửa</a> |
            <a href="index.php?controller=users&action=toggle&id=<?= $row['id'] ?>">
                <?= $row['status'] == 1 ? 'Khóa' : 'Mở' ?>
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

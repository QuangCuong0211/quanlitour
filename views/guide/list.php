<h2>Ds hdv</h2>
<a href="add.php?act=hdv-add">Thêm mới</a>

<table border="1" cellspacing="0" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>email</th>
        <th>SĐT</th>
        <th>Kinh nghiệm</th>
        <th>Hành động</th>
    </tr>

    
  <?php
// Đảm bảo biến tồn tại
$listHdv = $listHdv ?? [];
?>
     <?php if (!empty($listHdv)) : ?>
    <?php foreach ($listHdv as $key => $value) : ?>
       <tr>
                <td><?=$key + 1?></td>
                <td><?=$value['name']?></td>
                <td><?=$value['email']?></td>
                <td><?=$value['sdt']?></td> <!-- Hiển thị số lượng sản phẩm -->
                <td><?=$value['language']?></td> <!-- Hiển thị số lượng đã bán -->
                <td><?=$value['exp']?>năm</td>
            <td>
            <a href="list.php?act=hdv-edit&id=<?= $value['id']; ?>">Sửa</a>
            <a onclick="return confirm('Xóa hướng dẫn viên này?')" 
               href="list.php?act=hdv-delete&id=<?= $value['id']; ?>">Xóa</a>
        </td>
            </tr>
    <?php endforeach; ?>
<?php else: ?>
    <p>Không có dữ liệu.</p>
<?php endif; ?>

</table>
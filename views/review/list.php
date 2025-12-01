<h2>Danh sách đánh giá Tour</h2>
<a href="index.php?act=review-add" class="btn btn-success">Thêm đánh giá</a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Tour</th>
        <th>Tên khách</th>
        <th>Rating</th>
        <th>Nội dung</th>
        <th>Hành động</th>
    </tr>

    <?php foreach ($reviews as $r): ?>
    <tr>
        <td><?= $r['id'] ?></td>
        <td><?= $r['tour_name'] ?></td>
        <td><?= $r['customer_name'] ?></td>
        <td><?= $r['rating'] ?>/5</td>
        <td><?= $r['content'] ?></td>
        <td>
            <a href="index.php?act=review-edit&id=<?= $r['id'] ?>" class="btn btn-warning btn-sm">Sửa</a> 
            <a href="index.php?act=review-delete&id=<?= $r['id'] ?>" 
               onclick="return confirm('Xoá đánh giá này?')" 
               class="btn btn-danger btn-sm">Xoá</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

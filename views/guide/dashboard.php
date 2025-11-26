<?php include __DIR__.'/../partials/header.php'; ?>
<h1>Dashboard HDV</h1>
<p>Xin chào <?= $_SESSION['user']['name'] ?? 'HDV' ?></p>
<a href="/hdv/tours">Tour của tôi</a>
<?php include __DIR__.'/../partials/footer.php'; ?>

<h2>Danh sách Hướng dẫn viên</h2>
<a href="index.php?act=hdv-add">Thêm mới</a>

<table border="1" cellspacing="0" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>SĐT</th>
        <th>Kinh nghiệm</th>
        <th>Hành động</th>
    </tr>

    <?php foreach ($data as $item): ?>
    <tr>
        <td><?= $item['id']; ?></td>
        <td><?= $item['name']; ?></td>
        <td><?= $item['email']; ?></td>
        <td><?= $item['sdt']; ?></td>
         <td><?= $item['language']; ?></td>
        <td><?= $item['exp']; ?> năm</td>
        <td>
            <a href="index.php?act=hdv-edit&id=<?= $item['id']; ?>">Sửa</a>
            <a onclick="return confirm('Xóa hướng dẫn viên này?')" 
               href="index.php?act=hdv-delete&id=<?= $item['id']; ?>">Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
  <!-- <td>
                    <?php if (!empty($value['image1'])): ?>
                        <img src="../public/user/img/<?=$value['image1']?>" alt="Product Image">
                    <?php endif; ?>
                    <?php if (!empty($value['image2'])): ?>
                        <img src="../public/user/img/<?=$value['image2']?>" alt="Product Image">
                    <?php endif; ?>
                </td>
                     <td>
                    <input type="checkbox" 
                        onchange="toggleProductVisibility(<?=$value['product_id']?>)" 
                        <?= $value['is_hidden'] ? 'checked' : '' ?> >
                </td>

                <td>
                    <a href="?page=showeditproduct&id=<?=$value['product_id']?>">
                        <button class="btn-i">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </a>
                </td>
                <?php foreach($listHdv as $key => $value) { ?>
            <tr>
                <td><?=$key + 1?></td>
                <td><?=$value['name']?></td>
                <td><?=$value['email']?></td>
                <td><?=$value['sdt']?></td> <!-- Hiển thị số lượng sản phẩm -->
                <td><?=$value['language']?></td> <!-- Hiển thị số lượng đã bán -->
                <td><?=$value['exp']?>năm</td>
            <td>
            <a href="index.php?act=hdv-edit&id=<?= $item['id']; ?>">Sửa</a>
            <a onclick="return confirm('Xóa hướng dẫn viên này?')" 
               href="index.php?act=hdv-delete&id=<?= $item['id']; ?>">Xóa</a>
        </td>
            </tr>
        <?php } ?>
<?php
// Flash message
function flash($key) {
    if (!empty($_SESSION[$key])) {
        $color = $key === 'success' ? '#d4edda' : '#f8d7da';
        $border = $key === 'success' ? '#c3e6cb' : '#f5c6cb';
        $text = $key === 'success' ? '#155724' : '#721c24';

        echo "<div style='background:$color;color:$text;padding:15px;margin-bottom:20px;
                border-radius:5px;border:1px solid $border;'>"
             . htmlspecialchars($_SESSION[$key]) .
             "</div>";

        unset($_SESSION[$key]);
    }
}

flash('success');
flash('error');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý HDV</title>
    

    <style>
        body {
            margin: 0; font-family: Arial; background: #f4f4f4;
        }
        .sidebar {
            width:220px;height:100vh;background:#1E293B;color:#fff;
            position:fixed;top:0;left:0;padding-top:20px;
        }
        .sidebar a {
            display:block;padding:12px 20px;color:#fff;
            text-decoration:none;border-left:3px solid transparent;
        }
        .sidebar a.active, .sidebar a:hover {
            background:#334155;border-left-color:#10b981;
        }
        .content { margin-left:220px;padding:20px; }
        .card {
            background:#fff;border-radius:8px;padding:20px;
            box-shadow:0 2px 5px rgba(0,0,0,.1);
        }
        table { width:100%;border-collapse:collapse;background:#fff; }
        th {
            background:#1e293b;color:#fff;padding:12px;text-align:left;
        }
        td { padding:12px;border-bottom:1px solid #ddd;font-size:14px; }
        img { border-radius:6px;object-fit:cover; }
        .btn { padding:8px 15px;color:#fff;border-radius:5px;text-decoration:none; }
        .btn-edit { background:#f59e0b; }
        .btn-danger { background:#ef4444; }
        .btn-add { background:#10b981; }
    </style>
</head>

<body>

<div class="sidebar">
    <h2 style="text-align:center;margin:0 0 30px 0;">Admin</h2>
    <a href="?act=admin" ><i class="fas fa-home"></i> Dashboard</a>
    <a href="?act=tour-list" ><i class="fas fa-map-marked-alt"></i> Quản lý Tour</a>
    <a href="?act=guide-list" ><i class="fas fa-user-tie"></i> Quản lý HDV</a>
    <a href="?act=booking-list"><i class="fas fa-calendar-check"></i> Quản lý Booking</a>
    <a href="?act=category-list" class="active"><i class="fas fa-tags"></i> Danh mục</a>
    <a href="?act=customer-list"><i class="fas fa-users"></i> Khách hàng</a>
</div>

<div class="content">
    <div class="card">
        <h2>Danh Sách HDV</h2>

        <a href="?act=guide-add" class="btn btn-add">+ Thêm HDV</a>
        <br><br>

        <?php if (empty($guides)): ?>
            <div style="text-align:center;padding:30px;color:#6b7280;">Chưa có HDV</div>
        <?php else: ?>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Ảnh</th>
                <th>Kinh Nghiệm</th>
                <th>Ngoại Ngữ</th>
                <th>Hành Động</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($guides as $g): ?>

                <?php
                // Dữ liệu an toàn
                $id = htmlspecialchars($g['id'] ?? '');
                $name = htmlspecialchars($g['name'] ?? '');
                $email = htmlspecialchars($g['email'] ?? '');
                $sdt = htmlspecialchars($g['sdt'] ?? '');
                $exp = htmlspecialchars($g['exp'] ?? '');
                $lang = htmlspecialchars($g['language'] ?? '');

                // Xử lý ảnh
                $imgName = trim($g['img'] ?? '');

                // Nếu ảnh trong DB đã có đuôi → dùng luôn
                if ($imgName && preg_match('/\.(jpg|jpeg|png)$/i', $imgName)) {
                    $finalImg = "uploads/$imgName";
                } else {
                    // Thử tìm file theo 2 đuôi
                    $jpg = "uploads/$imgName.jpg";
                    $png = "uploads/$imgName.png";

                    if ($imgName && file_exists($jpg)) $finalImg = $jpg;
                    elseif ($imgName && file_exists($png)) $finalImg = $png;
                    else $finalImg = "uploads/no-image.png";
                }
                ?>

                <tr>
                    <td><?= $id ?></td>
                    <td><?= $name ?></td>
                    <td><?= $email ?></td>
                    <td><?= $sdt ?></td>
                    <td>
                        <img src="<?= $finalImg ?>" width="80" height="80">
                    </td>
                    <td><?= $exp ?></td>
                    <td><?= $lang ?></td>

                    <td>
                        <div style="display:flex;gap:10px;">
                            <a class="btn btn-edit" href="?act=guide-edit&id=<?= $id ?>">Sửa</a>
                            <a class="btn btn-danger"
                               onclick="return confirm('Xóa HDV này?')"
                               href="?act=guide-delete&id=<?= $id ?>">Xóa</a>
                        </div>
                    </td>
                </tr>

            <?php endforeach; ?>
            </tbody>
        </table>

        <?php endif; ?>

    </div>
</div>

</body>
</html>

<?php include "../database.php"; ?>

<a href="../user/list.php">Chuyển sang giao diện user</a>
<br><br>

<?php
$id = $_GET['id'];

if ($_POST) {
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $conn->query("UPDATE users SET password='$pass' WHERE id=$id");

    header("Location: list.php");
}
?>

<h2>Đổi mật khẩu</h2>

<form method="post">
    Mật khẩu mới:
    <input type="password" name="password" required>
    <br><br>
    <button type="submit">Cập nhật</button>
</form>

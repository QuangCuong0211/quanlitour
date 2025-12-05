<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập - Quản lý Tour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 420px;
        }
        .btn-login {
            background: #10b981;
            border: none;
            font-weight: 600;
            padding: 12px;
        }
        .btn-login:hover { background: #059669; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2 class="text-center mb-4 fw-bold text-dark">ĐĂNG NHẬP HỆ THỐNG</h2>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <form action="index.php?act=login" method="POST">
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control form-control-lg" 
                       value="<?= $_POST['email'] ?? '' ?>" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Mật khẩu</label>
                <input type="password" name="password" class="form-control form-control-lg" required>
            </div>
            <button type="submit" class="btn btn-success btn-login w-100">
                Đăng nhập
            </button>
        </form>

        <div class="text-center mt-4 text-muted">
            <small>
                Test:<br>
                Admin: admin@gmail.com / password<br>
                HDV: hdv@gmail.com / password
            </small>
        </div>
    </div>
</body>
</html>
<?php
session_start();

require_once './commons/env.php';
require_once './commons/function.php';

// Controllers
require_once './controllers/ProductController.php';
require_once './controllers/UserController.php';

// Models
require_once './models/ProductModel.php';
require_once './models/UserModel.php';

$act = $_GET['act'] ?? '/';

$productController = new ProductController();
$userController = new UserController();

// Danh sách route rõ ràng (key = route, value = [controller, phương thức])
$routes = [
    '/'           => [$productController, 'Home'],
    'admin'       => [$productController, 'Admin'],

    // Tour CRUD
    'tour-list'   => [$productController, 'tourList'],
    'tour-add'    => [$productController, 'tourAdd'],
    'tour-save'   => [$productController, 'tourSave'],
    'tour-edit'   => [$productController, 'tourEdit'],
    'tour-update' => [$productController, 'tourUpdate'],
    'tour-delete' => [$productController, 'tourDelete'],

    // User Management
    'login'       => [$userController, 'login'],
    'logout'      => [$userController, 'logout'],
    'user-list'   => [$userController, 'userList'],
    'user-add'    => [$userController, 'userAdd'],
    'user-save'   => [$userController, 'userSave'],
    'user-edit'   => [$userController, 'userEdit'],
    'user-update' => [$userController, 'userUpdate'],
    'user-delete' => [$userController, 'userDelete'],
    'user-change-password' => [$userController, 'userChangePassword'],
];

// Kiểm tra route tồn tại
if (array_key_exists($act, $routes)) {
    [$controller, $method] = $routes[$act];

    // Gọi hàm Controller
    $controller->$method();

} else {
    // 404
    echo "404 - Không tìm thấy route!";
}

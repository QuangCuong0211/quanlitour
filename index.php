<?php
session_start();

require_once './commons/env.php';
require_once './commons/function.php';

// Controllers
require_once './controllers/ProductController.php';
require_once './controllers/UserController.php';
require_once './controllers/DepartureController.php';
require_once './controllers/CustomerController.php';

// Models
require_once './models/ProductModel.php';
require_once './models/UserModel.php';
require_once './models/DepartureModel.php';
require_once './models/CustomerModel.php';

$act = $_GET['act'] ?? '/';

$productController = new ProductController();
$userController = new UserController();
$departureController = new DepartureController();
$customerController = new CustomerController();

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

    // Departure Management (Lịch Khởi Hành)
    'departure-list'   => [$departureController, 'departureList'],
    'departure-add'    => [$departureController, 'departureAdd'],
    'departure-save'   => [$departureController, 'departureSave'],
    'departure-edit'   => [$departureController, 'departureEdit'],
    'departure-update' => [$departureController, 'departureUpdate'],
    'departure-delete' => [$departureController, 'departureDelete'],

    // Customer Management (Danh Sách Khách Hàng)
    'customer-list'   => [$customerController, 'customerList'],
    'customer-add'    => [$customerController, 'customerAdd'],
    'customer-save'   => [$customerController, 'customerSave'],
    'customer-edit'   => [$customerController, 'customerEdit'],
    'customer-update' => [$customerController, 'customerUpdate'],
    'customer-delete' => [$customerController, 'customerDelete'],
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

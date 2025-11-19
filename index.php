<?php
require_once './commons/env.php';
require_once './commons/function.php';

// Controllers
require_once './controllers/ProductController.php';
require_once './controllers/UserController.php';

// Models
require_once './models/ProductModel.php';

$act = $_GET['act'] ?? '/';

$productController = new ProductController();
$userController = new UserController();

// Routes cho ProductController
$productRoutes = [
    '/'           => 'Home',
    'admin'       => 'Admin',

    // Tour CRUD
    'tour-list'   => 'tourList',
    'tour-add'    => 'tourAdd',
    'tour-save'   => 'tourSave',
    'tour-edit'   => 'tourEdit',
    'tour-update' => 'tourUpdate',
    'tour-delete' => 'tourDelete',
];

// Routes cho UserController
$userRoutes = [
    'user-list'   => 'list',
    'user-add'    => 'add',
    'user-store'  => 'store',
    'user-edit'   => 'edit',
    'user-update' => 'update',
    'user-delete' => 'delete',
];

if (array_key_exists($act, $productRoutes)) {
    $method = $productRoutes[$act];
    $productController->$method();

} elseif (array_key_exists($act, $userRoutes)) {
    $method = $userRoutes[$act];
    $userController->$method();

} else {
    echo "404 - Không tìm thấy route!";
}

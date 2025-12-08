<?php
session_start(); 

require_once './commons/env.php';
require_once './commons/database.php';
require_once './commons/function.php';

// Models
require_once './models/TourModel.php';
require_once './models/BookingModel.php';
require_once './models/CategoryModel.php';
require_once './models/DepartureModel.php';
require_once './models/CustomerModel.php';
require_once './models/GuideModel.php';

// Controllers
require_once './controllers/TourController.php';
require_once './controllers/BookingController.php';
require_once './controllers/CategoryController.php';
require_once './controllers/DepartureController.php';
require_once './controllers/CustomerController.php';
require_once './controllers/GuideController.php';
require_once './controllers/ReviewController.php';

$act = $_GET['act'] ?? '/';

$tourController = new TourController();
$bookingController = new BookingController();
$categoryController = new CategoryController();
$departureController = new DepartureController();
$customerController = new CustomerController();
$guideController = new GuideController();
$reviewController = new ReviewController();

// ==================== XỬ LÝ ĐĂNG NHẬP ====================
if ($act === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = pdo_query_one("SELECT * FROM users WHERE email = ?", $email);
        $hash = $user['password'] ?? '';
        $valid = false;

        if ($hash) {
            if (str_starts_with($hash, '$2y$') || str_starts_with($hash, '$argon2')) {
                $valid = password_verify($password, $hash);
            } else {
                $valid = md5($password) === $hash;
            }
        }

        if ($user && $valid) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'] ?? ($user['fullname'] ?? $user['email']);
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['success'] = "Chào mừng {$_SESSION['user_name']}!";

            $redirect = $user['role'] === 'hdv' ? 'booking-list' : 'admin';
            header("Location: index.php?act={$redirect}");
            exit;
        }

        $_SESSION['error'] = "Email hoặc mật khẩu không đúng!";
    }
    require "views/auth/login.php";
    exit;
}

// ==================== XỬ LÝ ĐĂNG XUẤT ====================
if ($act === 'logout') {
    session_destroy();
    header("Location: index.php?act=login");
    exit;
}

// ==================== BẢO VỆ TRANG ADMIN ====================
$protected_routes = [
    'admin', 'guide-list', 'guide-add', 'guide-save', 'guide-edit', 'guide-update', 'guide-delete',
    'tour-list', 'tour-add', 'tour-save', 'tour-edit', 'tour-update', 'tour-delete',
    'booking-list', 'booking-add', 'booking-save', 'booking-edit', 'booking-update', 'booking-delete', 'booking-change-status',
    'category-list', 'category-add', 'category-save', 'category-edit', 'category-update', 'category-delete',
    'departure-list', 'departure-add', 'departure-save', 'departure-edit', 'departure-update', 'departure-delete',
    'customer-list', 'customer-add', 'customer-save', 'customer-edit', 'customer-update', 'customer-delete',
    'review-list'
];

$admin_only_routes = [
    'admin', 'guide-list', 'guide-add', 'guide-save', 'guide-edit', 'guide-update', 'guide-delete',
    'tour-list', 'tour-add', 'tour-save', 'tour-edit', 'tour-update', 'tour-delete',
    'category-list', 'category-add', 'category-save', 'category-edit', 'category-update', 'category-delete',
    'departure-list', 'departure-add', 'departure-save', 'departure-edit', 'departure-update', 'departure-delete',
    'customer-list', 'customer-add', 'customer-save', 'customer-edit', 'customer-update', 'customer-delete',
    'review-list'
];

if (in_array($act, $protected_routes) && empty($_SESSION['user_id'])) {
    $_SESSION['error'] = "Vui lòng đăng nhập để truy cập!";
    header("Location: index.php?act=login");
    exit;
}

if (in_array($act, $admin_only_routes) && ($_SESSION['user_role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Bạn cần quyền admin để truy cập phần này.';
    header('Location: index.php?act=booking-list');
    exit;
}

// ==================== DANH SÁCH ROUTE ====================
$routes = [
    '/' => ['controller' => $tourController, 'method' => 'Home'],
    'admin' => ['controller' => $tourController, 'method' => 'Admin'],

    // AUTH
    'login' => ['controller' => null, 'method' => null],
    'logout' => ['controller' => null, 'method' => null],

    // GUIDE
    'guide-list' => ['controller' => $guideController, 'method' => 'guideList'],
    'guide-add' => ['controller' => $guideController, 'method' => 'guideAdd'],
    'guide-save' => ['controller' => $guideController, 'method' => 'guideSave'],
    'guide-edit' => ['controller' => $guideController, 'method' => 'guideEdit'],
    'guide-update' => ['controller' => $guideController, 'method' => 'guideUpdate'],
    'guide-delete' => ['controller' => $guideController, 'method' => 'guideDelete'],

    // TOUR
    'tour-list' => ['controller' => $tourController, 'method' => 'tourList'],
    'tour-add' => ['controller' => $tourController, 'method' => 'tourAdd'],
    'tour-save' => ['controller' => $tourController, 'method' => 'tourSave'],
    'tour-edit' => ['controller' => $tourController, 'method' => 'tourEdit'],
    'tour-update' => ['controller' => $tourController, 'method' => 'tourUpdate'],
    'tour-delete' => ['controller' => $tourController, 'method' => 'tourDelete'],

    // BOOKING
    'booking-list' => ['controller' => $bookingController, 'method' => 'index'],
    'booking-add' => ['controller' => $bookingController, 'method' => 'create'],
    'booking-save' => ['controller' => $bookingController, 'method' => 'store'],
    'booking-edit' => ['controller' => $bookingController, 'method' => 'edit'],
    'booking-update' => ['controller' => $bookingController, 'method' => 'update'],
    'booking-delete' => ['controller' => $bookingController, 'method' => 'delete'],
    'booking-change-status' => ['controller' => $bookingController, 'method' => 'changeStatus'],

    // CATEGORY
    'category-list' => ['controller' => $categoryController, 'method' => 'categoryList'],
    'category-add' => ['controller' => $categoryController, 'method' => 'categoryAdd'],
    'category-save' => ['controller' => $categoryController, 'method' => 'categorySave'],
    'category-edit' => ['controller' => $categoryController, 'method' => 'categoryEdit'],
    'category-update' => ['controller' => $categoryController, 'method' => 'categoryUpdate'],
    'category-delete' => ['controller' => $categoryController, 'method' => 'categoryDelete'],

    // DEPARTURE
    'departure-list' => ['controller' => $departureController, 'method' => 'departureList'],
    'departure-add' => ['controller' => $departureController, 'method' => 'departureAdd'],
    'departure-save' => ['controller' => $departureController, 'method' => 'departureSave'],
    'departure-edit' => ['controller' => $departureController, 'method' => 'departureEdit'],
    'departure-update' => ['controller' => $departureController, 'method' => 'departureUpdate'],
    'departure-delete' => ['controller' => $departureController, 'method' => 'departureDelete'],

    // CUSTOMER
    'customer-list' => ['controller' => $customerController, 'method' => 'customerList'],
    'customer-add' => ['controller' => $customerController, 'method' => 'customerAdd'],
    'customer-save' => ['controller' => $customerController, 'method' => 'customerSave'],
    'customer-edit' => ['controller' => $customerController, 'method' => 'customerEdit'],
    'customer-update' => ['controller' => $customerController, 'method' => 'customerUpdate'],
    'customer-delete' => ['controller' => $customerController, 'method' => 'customerDelete'],

    // REVIEW
    'review-list' => ['controller' => $reviewController, 'method' => 'reviewList'],
];

if (array_key_exists($act, $routes)) {
    $route = $routes[$act];
    $controller = $route['controller'];
    $method = $route['method'];

    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        echo "404 - Method không tồn tại!";
    }
} else {
    echo "404 - Không tìm thấy route!";
}
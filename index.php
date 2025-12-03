<?php
session_start(); // NHỚ CÓ để dùng $_SESSION flash message

require_once './commons/env.php';
require_once './commons/database.php';   // << tạo $conn
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

$act = $_GET['act'] ?? '/';

$tourController = new TourController();
$bookingController = new BookingController();
$categoryController = new CategoryController();
$departureController = new DepartureController();
$customerController = new CustomerController();
$guideController = new GuideController();

$routes = [
    '/'            => ['controller' => $tourController, 'method' => 'Home'],
    'admin'        => ['controller' => $tourController, 'method' => 'Admin'],

    'tour-list'    => ['controller' => $tourController, 'method' => 'tourList'],
    'tour-add'     => ['controller' => $tourController, 'method' => 'tourAdd'],
    'tour-save'    => ['controller' => $tourController, 'method' => 'tourSave'],
    'tour-edit'    => ['controller' => $tourController, 'method' => 'tourEdit'],
    'tour-update'  => ['controller' => $tourController, 'method' => 'tourUpdate'],
    'tour-delete'  => ['controller' => $tourController, 'method' => 'tourDelete'],

    'booking-list'   => ['controller' => $bookingController, 'method' => 'index'],
    'booking-assign-guide' => ['controller' => $bookingController, 'method' => 'assignGuide'],
    'booking-save-note'    => ['controller' => $bookingController, 'method' => 'saveAdminNote'],
    'booking-add'    => ['controller' => $bookingController, 'method' => 'create'],
    'booking-save'   => ['controller' => $bookingController, 'method' => 'store'],
    'booking-edit'   => ['controller' => $bookingController, 'method' => 'edit'],
    'booking-update' => ['controller' => $bookingController, 'method' => 'update'],
    'booking-delete' => ['controller' => $bookingController, 'method' => 'delete'],
    'booking-issues'     => ['controller' => $bookingController, 'method' => 'issues'],
    'booking-save-issue' => ['controller' => $bookingController, 'method' => 'saveIssue'],

    'category-list'   => ['controller' => $categoryController, 'method' => 'categoryList'],
    'category-add'    => ['controller' => $categoryController, 'method' => 'categoryAdd'],
    'category-save'   => ['controller' => $categoryController, 'method' => 'categorySave'],
    'category-edit'   => ['controller' => $categoryController, 'method' => 'categoryEdit'],
    'category-update' => ['controller' => $categoryController, 'method' => 'categoryUpdate'],
    'category-delete' => ['controller' => $categoryController, 'method' => 'categoryDelete'],

    'departure-list'   => ['controller' => $departureController, 'method' => 'departureList'],
    'departure-add'    => ['controller' => $departureController, 'method' => 'departureAdd'],
    'departure-save'   => ['controller' => $departureController, 'method' => 'departureSave'],
    'departure-edit'   => ['controller' => $departureController, 'method' => 'departureEdit'],
    'departure-update' => ['controller' => $departureController, 'method' => 'departureUpdate'],
    'departure-delete' => ['controller' => $departureController, 'method' => 'departureDelete'],

    'customer-list'   => ['controller' => $customerController, 'method' => 'customerList'],
    'customer-add'    => ['controller' => $customerController, 'method' => 'customerAdd'],
    'customer-save'   => ['controller' => $customerController, 'method' => 'customerSave'],
    'customer-edit'   => ['controller' => $customerController, 'method' => 'customerEdit'],
    'customer-update' => ['controller' => $customerController, 'method' => 'customerUpdate'],
    'customer-delete' => ['controller' => $customerController, 'method' => 'customerDelete'],

    'guide-list'   => ['controller' => $guideController, 'method' => 'guideList'],
    'guide-add'    => ['controller' => $guideController, 'method' => 'guideAdd'],
    'guide-save'   => ['controller' => $guideController, 'method' => 'guideSave'],
    'guide-edit'   => ['controller' => $guideController, 'method' => 'guideEdit'],
    'guide-update' => ['controller' => $guideController, 'method' => 'guideUpdate'],
    'guide-toggle' => ['controller' => $guideController, 'method' => 'guideToggleStatus'],
    'guide-delete' => ['controller' => $guideController, 'method' => 'guideDelete'],

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

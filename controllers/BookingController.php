<?php
require_once "models/BookingModel.php";
require_once "models/TourModel.php";

class BookingController
{
    private $bookingModel;
    private $tourModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->tourModel    = new TourModel();
    }

    // =============================
    // DANH SÁCH BOOKING
    // =============================
    public function index()
    {
        $bookings = $this->bookingModel->getAll();
        include "views/booking/list.php";
    }

    // =============================
    // FORM THÊM BOOKING
    // =============================
    public function create()
    {
        $tours = $this->tourModel->getAllTours();
        include "views/booking/add.php";
    }

    // =============================
    // LƯU BOOKING
    // =============================
    public function store()
{
    $names  = $_POST['customer_name'] ?? [];
    $emails = $_POST['email'] ?? [];
    $phones = $_POST['phone'] ?? [];
    $types  = $_POST['customer_type'] ?? [];

    $totalCustomer = count($names);

    if ($totalCustomer < 5) {
        $_SESSION['error'] = "Booking phải có tối thiểu 5 khách hàng!";
        header("Location: ?act=booking-create");
        exit();
    }

    foreach ($names as $i => $name) {
        if (empty($name) || empty($emails[$i]) || empty($phones[$i])) {
            $_SESSION['error'] = "Thông tin khách hàng không được để trống!";
            header("Location: ?act=booking-create");
            exit();
        }
    }

    if ($_POST['end_date'] <= $_POST['start_date']) {
        $_SESSION['error'] = "Ngày kết thúc phải sau ngày khởi hành!";
        header("Location: ?act=booking-create");
        exit();
    }

    // ===== ĐẾM NGƯỜI LỚN / TRẺ EM =====
    $adult = count(array_filter($types, fn($t) => $t === 'adult'));
    $child = count(array_filter($types, fn($t) => $t === 'child'));

    // ===== LẤY GIÁ TOUR =====
    $tour = $this->tourModel->getOne($_POST['tour_id']);
    if (!$tour) {
        $_SESSION['error'] = "Tour không tồn tại!";
        header("Location: ?act=booking-add");
        exit();
    }

    $totalPrice = $adult * $tour['price'] + $child * ($tour['price'] * 0.7);

    $data = [
        "tour_id"       => $_POST['tour_id'],
        "booking_code"  => "BK-" . date("Y") . "-" . rand(10000, 99999),
        "customer_name" => json_encode($names),
        "email"         => json_encode($emails),
        "phone"         => json_encode($phones),
        "adult"         => $adult,
        "child"         => $child,
        "total_price"   => $totalPrice,
        "start_date"    => $_POST['start_date'],
        "end_date"      => $_POST['end_date'],
        "note"          => $_POST['note']
    ];

    if ($this->bookingModel->insert($data)) {
        $_SESSION['success'] = "Thêm booking thành công!";
    } else {
        $_SESSION['error'] = "Không thể thêm booking!";
    }

    header("Location: ?act=booking-list");
    exit();
}


    // =============================
    // FORM SỬA
    // =============================
    public function edit()
    {
        $id      = $_GET['id'];
        $booking = $this->bookingModel->getOne($id);
        $tours   = $this->tourModel->getAllTours();

        include "views/booking/edit.php";
    }

    // =============================
    // CẬP NHẬT
    // =============================
    public function update()
    {
        $customerNames = $_POST['customer_name'] ?? [];
        $emails        = $_POST['email'] ?? [];
        $phones        = $_POST['phone'] ?? [];

        $totalCustomer = count($customerNames);

        if ($totalCustomer < 5) {
            $_SESSION['error'] = "Booking phải có tối thiểu 5 khách hàng!";
            header("Location: ?act=booking-edit&id=" . $_POST['id']);
            exit();
        }

        $data = [
            "id"            => $_POST['id'],
            "customer_name" => json_encode($customerNames),
            "email"         => json_encode($emails),
            "phone"         => json_encode($phones),
            "adult"         => $totalCustomer,
            "child"         => 0,
            "total_price"   => $_POST['total_price'],
            "start_date"    => $_POST['start_date'],
            "end_date"      => $_POST['end_date'],
            "note"          => $_POST['note']
        ];

        if ($this->bookingModel->update($data)) {
            $_SESSION['success'] = "Cập nhật booking thành công!";
        } else {
            $_SESSION['error'] = "Cập nhật booking thất bại!";
        }

        header("Location: ?act=booking-list");
        exit();
    }

    // =============================
    // XOÁ
    // =============================
    public function delete()
    {
        $id = $_GET['id'];

        if ($this->bookingModel->delete($id)) {
            $_SESSION['success'] = "Xóa booking thành công!";
        } else {
            $_SESSION['error'] = "Không thể xóa booking!";
        }

        header("Location: ?act=booking-list");
        exit();
    }
}

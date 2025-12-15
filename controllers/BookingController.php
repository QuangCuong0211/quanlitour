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

    /* =============================
       DANH SÁCH BOOKING
    ============================== */
    public function index()
    {
        $bookings = $this->bookingModel->getAll();

        // GẮN DANH SÁCH KHÁCH CHO TỪNG BOOKING
        foreach ($bookings as &$b) {
            $b['customers'] = $this->bookingModel->getCustomers($b['id']);
        }

        include "views/booking/list.php";
    }

    /* =============================
       FORM THÊM
    ============================== */
    public function create()
    {
        $tours = $this->tourModel->getAllTours();
        include "views/booking/add.php";
    }

    /* =============================
       LƯU BOOKING
    ============================== */
    public function store()
    {
        $names  = $_POST['customer_name'] ?? [];
        $emails = $_POST['email'] ?? [];
        $phones = $_POST['phone'] ?? [];
        $types  = $_POST['customer_type'] ?? [];

        /* ==== VALIDATE ==== */
        if (count($names) < 5) {
            $_SESSION['error'] = "Booking phải có tối thiểu 5 khách!";
            header("Location: ?act=booking-add");
            exit;
        }

        foreach ($names as $i => $n) {
            if (empty($n) || empty($emails[$i]) || empty($phones[$i])) {
                $_SESSION['error'] = "Thông tin khách hàng không được để trống!";
                header("Location: ?act=booking-add");
                exit;
            }
        }

        /* ==== ĐẾM NGƯỜI ==== */
        $adult = count(array_filter($types, fn($t) => $t === 'adult'));
        $child = count(array_filter($types, fn($t) => $t === 'child'));

        /* ==== TOUR ==== */
        $tour = $this->tourModel->getOne($_POST['tour_id']);
        if (!$tour) {
            $_SESSION['error'] = "Tour không tồn tại!";
            header("Location: ?act=booking-add");
            exit;
        }

        /* ==== TÍNH TIỀN ==== */
        $totalPrice = $adult * $tour['price']
            + $child * ($tour['price'] * 0.7);

        /* ==== BOOKING ==== */
        $booking = [
            'tour_id'      => $_POST['tour_id'],
            'booking_code' => 'BK-' . date('Y') . '-' . rand(10000, 99999),
            'adult'        => $adult,
            'child'        => $child,
            'total_price'  => $totalPrice,
            'start_date'   => $_POST['start_date'],
            'end_date'     => $_POST['end_date'],
            'note'         => $_POST['note'] ?? ''
        ];

        /* ==== CUSTOMERS ==== */
        $customers = [];
        foreach ($names as $i => $n) {
            $customers[] = [
                'name'  => $n,
                'phone' => $phones[$i],
                'email' => $emails[$i],
                'type' => $types[$i]
            ];
        }

        /* ==== INSERT ==== */
        $this->bookingModel->insert($booking, $customers);

        $_SESSION['success'] = "Thêm booking thành công!";
        header("Location: ?act=booking-list");
        exit;
    }

    /* =============================
       SỬA
    ============================== */
    public function edit()
    {
        $id = $_GET['id'];

        $booking   = $this->bookingModel->getOne($id);
        $customers = $this->bookingModel->getCustomers($id);
        $tours     = $this->tourModel->getAllTours();

        include "views/booking/edit.php";
    }

    /* =============================
       CẬP NHẬT
    ============================== */
    public function update()
    {
        $booking = $this->bookingModel->getOne($_POST['id']);
        if ($booking['status'] === 'done') {
            $_SESSION['error'] = "Booking đã hoàn tất, không thể chỉnh sửa!";
            header("Location: ?act=booking-list");
            exit;
        }
        $id     = $_POST['id'];
        $names  = $_POST['customer_name'];
        $emails = $_POST['email'];
        $phones = $_POST['phone'];
        $types  = $_POST['customer_type'];

        if (count($names) < 5) {
            $_SESSION['error'] = "Booking phải có tối thiểu 5 khách!";
            header("Location: ?act=booking-edit&id=" . $id);
            exit;
        }

        $adult = count(array_filter($types, fn($t) => $t === 'adult'));
        $child = count(array_filter($types, fn($t) => $t === 'child'));

        $booking = [
            'id'          => $id,
            'adult'       => $adult,
            'child'       => $child,
            'total_price' => $_POST['total_price'],
            'start_date'  => $_POST['start_date'],
            'end_date'    => $_POST['end_date'],
            'note'        => $_POST['note']
        ];

        $customers = [];
        foreach ($names as $i => $n) {
            $customers[] = [
                'name'  => $n,
                'phone' => $phones[$i],
                'email' => $emails[$i],
                'type' => $types[$i]
            ];
        }

        $this->bookingModel->update($booking, $customers);

        $_SESSION['success'] = "Cập nhật booking thành công!";
        header("Location: ?act=booking-list");
        exit;
    }

    /* =============================
       XOÁ
    ============================== */
    public function delete()
    {
        $this->bookingModel->delete($_GET['id']);
        $_SESSION['success'] = "Xóa booking thành công!";
        header("Location: ?act=booking-list");
        exit;
    }

    /* =============================
       ĐỔI TRẠNG THÁI (FIX 404)
    ============================== */
    public function changeStatus()
    {
        $id     = $_POST['id'];
        $status = $_POST['status'];

        $allow = ['pending', 'deposit', 'done', 'cancel'];
        if (!in_array($status, $allow)) {
            $_SESSION['error'] = "Trạng thái không hợp lệ!";
            header("Location: ?act=booking-list");
            exit;
        }

        $this->bookingModel->updateStatus($id, $status);

        $_SESSION['success'] = "Đã cập nhật trạng thái!";
        header("Location: ?act=booking-list");
        exit;
    }
}

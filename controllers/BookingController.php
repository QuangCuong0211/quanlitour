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
        $this->tourModel = new TourModel();
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
        $data = [
            "tour_id"       => $_POST['tour_id'],
            "booking_code"  => "BK-" . date("Y") . "-" . rand(10000, 99999),
            "customer_name" => $_POST['customer_name'],
            "phone"         => $_POST['phone'],
            "email"         => $_POST['email'],
            "adult"         => $_POST['adult'],
            "child"         => $_POST['child'],
            "total_price"   => $_POST['total_price'],
            "start_date"    => $_POST['start_date'],
            "end_date"      => $_POST['end_date'],
            "note"          => $_POST['note'],
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
    // FORM SỬA BOOKING
    // =============================
    public function edit()
    {
        $id = $_GET['id'];
        $booking = $this->bookingModel->getOne($id);
        $tours   = $this->tourModel->getAllTours();

        include "views/booking/edit.php";
    }

    // =============================
    // CẬP NHẬT BOOKING
    // =============================
    public function update()
    {
        $data = [
            "id"            => $_POST['id'],
            "customer_name" => $_POST['customer_name'],
            "phone"         => $_POST['phone'],
            "email"         => $_POST['email'],
            "adult"         => $_POST['adult'],
            "child"         => $_POST['child'],
            "total_price"   => $_POST['total_price'],
            "start_date"    => $_POST['start_date'],
            "end_date"      => $_POST['end_date'],
            "note"          => $_POST['note'],
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
    // XOÁ BOOKING
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

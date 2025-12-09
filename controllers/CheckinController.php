<?php
require_once __DIR__ . '/../models/CheckinModel.php';
require_once __DIR__ . '/../models/BookingModel.php';

class CheckinController {
    protected $model;

    public function __construct() {
        $this->model = new CheckinModel();
    }

    public function show() {
        $booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
        if (!$booking_id) {
            $_SESSION['error'] = 'Booking hợp lệ không được cung cấp.';
            header('Location: index.php?act=booking-list');
            exit;
        }

        $bookingModel = new BookingModel();
        $booking = $bookingModel->getOne($booking_id);
        if (!$booking) {
            $_SESSION['error'] = 'Booking không tồn tại.';
            header('Location: index.php?act=booking-list');
            exit;
        }

        $checkins = $this->model->listByBooking($booking_id);
        $summaryRows = $this->model->getStatusSummary($booking_id);
        $summary = [];
        foreach ($summaryRows as $row) {
            $summary[$row['status']] = $row;
        }

        include __DIR__ . '/../views/checkin/list.php';
    }

    public function upsert() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=booking-list');
            exit;
        }

        $booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
        if (!$booking_id) {
            $_SESSION['error'] = 'Không xác định được booking để điểm danh.';
            header('Location: index.php?act=booking-list');
            exit;
        }

        $customer_name = trim($_POST['customer_name'] ?? '');
        $customer_phone = trim($_POST['customer_phone'] ?? '');
        $status = $_POST['status'] ?? 'pending';
        $checked_by = trim($_POST['checked_by'] ?? ($_SESSION['user_name'] ?? '')); 
        $note = trim($_POST['note'] ?? '');

        if ($customer_name === '' || $customer_phone === '') {
            $_SESSION['error'] = 'Tên và số điện thoại không được rỗng.';
            header("Location: index.php?act=checkin&booking_id={$booking_id}");
            exit;
        }

        $this->model->upsertCheckin($booking_id, $customer_name, $customer_phone, $status, $checked_by, $note);
        $_SESSION['success'] = "Đã lưu điểm danh cho {$customer_name}";
        header("Location: index.php?act=checkin&booking_id={$booking_id}");
        exit;
    }

    public function bulkUpdate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=booking-list');
            exit;
        }

        $booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
        if (!$booking_id) {
            $_SESSION['error'] = 'Không xác định được booking để cập nhật tickbox.';
            header('Location: index.php?act=booking-list');
            exit;
        }

        $presentIds = isset($_POST['present']) ? (array)$_POST['present'] : [];
        $checked_by = trim($_POST['checked_by'] ?? ($_SESSION['user_name'] ?? 'Hệ thống'));

        $this->model->bulkUpdateStatuses($booking_id, $presentIds, $checked_by ?: 'Hệ thống');
        $_SESSION['success'] = 'Đã cập nhật tickbox điểm danh.';
        header("Location: index.php?act=checkin&booking_id={$booking_id}");
        exit;
    }
}

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
    public function assignGuide()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $booking_id = (int)($_POST['booking_id'] ?? 0);
        $guide_id   = !empty($_POST['guide_id']) ? (int)$_POST['guide_id'] : null;
        $note       = trim($_POST['guide_note'] ?? '');

        if ($booking_id > 0) {
            pdo_execute(
                "UPDATE bookings SET guide_id = ?, guide_note = ? WHERE id = ?",
                $guide_id,
                $note,
                $booking_id
            );
            $_SESSION['success'] = "Phân bổ hướng dẫn viên thành công!";
        } else {
            $_SESSION['error'] = "Không tìm thấy booking!";
        }
    }

    // Quay lại trang danh sách booking
    header("Location: index.php?act=booking-list");
    exit;
}
public function saveAdminNote()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $booking_id = (int)($_POST['booking_id'] ?? 0);
        $admin_note = trim($_POST['admin_note'] ?? '');

        if ($booking_id > 0) {
            pdo_execute(
                "UPDATE bookings SET admin_note = ? WHERE id = ?",
                $admin_note,
                $booking_id
            );
            $_SESSION['success'] = "Đã lưu ghi chú admin!";
        } else {
            $_SESSION['error'] = "Không tìm thấy booking!";
        }
    }

    header("Location: index.php?act=booking-list");
    exit;
}
// Xem và xử lý sự cố
public function issues()
{
    $booking_id = $_GET['booking_id'] ?? 0;
    if (!$booking_id) {
        $_SESSION['error'] = "Không tìm thấy booking!";
        header("Location: index.php?act=booking-list");
        exit;
    }

    $issues = pdo_query("SELECT bi.*, u.name as creator_name 
                         FROM booking_issues bi 
                         LEFT JOIN users u ON bi.created_by = u.id 
                         WHERE bi.booking_id = ? 
                         ORDER BY bi.created_at DESC", $booking_id);

    $booking = pdo_query_one("SELECT booking_code FROM bookings WHERE id = ?", $booking_id);

    require_once 'views/booking/issues.php';
}

// Lưu sự cố mới hoặc cập nhật
public function saveIssue()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $booking_id = (int)$_POST['booking_id'];
        $issue_id   = (int)$_POST['issue_id'] ?? 0;
        $title      = trim($_POST['title'] ?? '');
        $desc       = trim($_POST['description'] ?? '');
        $status     = $_POST['status'] ?? 'pending';
        $admin_id   = $_SESSION['user_id'] ?? 1; // giả sử có login

        $attachment = '';
        if (!empty($_FILES['attachment']['name'])) {
            $file = $_FILES['attachment'];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'issue_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            move_uploaded_file($file['tmp_name'], 'uploads/issues/' . $filename);
            $attachment = $filename;
        }

        if ($issue_id > 0) {
            // Cập nhật
            $sql = "UPDATE booking_issues SET title=?, description=?, status=?, attachment=? WHERE id=? AND booking_id=?";
            pdo_execute($sql, $title, $desc, $status, $attachment ?: null, $issue_id, $booking_id);
        } else {
            // Thêm mới
            $sql = "INSERT INTO booking_issues (booking_id, title, description, status, attachment, created_by) VALUES (?, ?, ?, ?, ?, ?)";
            pdo_execute($sql, $booking_id, $title, $desc, $status, $attachment, $admin_id);
        }

        $_SESSION['success'] = "Đã lưu xử lý sự cố!";
    }

    header("Location: index.php?act=booking-issues&booking_id=" . $booking_id);
    exit;
}
}

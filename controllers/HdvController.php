<?php
class HdvController {

    // Kiểm tra quyền HDV (dùng chung cho tất cả method)
    private function checkAuth() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'hdv') {
            $_SESSION['error'] = "Bạn không có quyền truy cập khu vực hướng dẫn viên!";
            header("Location: index.php?act=login");
            exit;
        }
    }

    public function dashboard() {
        $this->checkAuth();
        require "views/guide/dashboard.php";
    }

    public function todaySchedule() {
        $this->checkAuth();
        require "views/guide/today-schedule.php";
    }

    public function monthSchedule() {
        $this->checkAuth();
        require "views/guide/month-schedule.php";
    }

    public function customerList() {
        $this->checkAuth();

        $departure_id = $_GET['departure_id'] ?? 0;
        if (!$departure_id) {
            $_SESSION['error'] = "Không tìm thấy tour!";
            header("Location: index.php?act=hdv-dashboard");
            exit;
        }

        $guide_id = $_SESSION['user_id'];

        // Kiểm tra departure này có thuộc về HDV không
        $departure = pdo_query_one("
            SELECT d.*, t.name AS tour_name
            FROM departures d
            JOIN tours t ON d.tour_id = t.id
            WHERE d.id = ? AND d.guide_id = ?
        ", $departure_id, $guide_id);

        if (!$departure) {
            $_SESSION['error'] = "Tour này không thuộc quyền của bạn!";
            header("Location: index.php?act=hdv-dashboard");
            exit;
        }

        // LẤY DANH SÁCH KHÁCH + CỘT ATTENDED ĐỂ HIỂN THỊ TRẠNG THÁI ĐÚNG
        $customers = pdo_query("
            SELECT 
                bc.id AS bc_id, 
                bc.name, 
                bc.phone, 
                bc.email, 
                bc.type, 
                bc.attended,
                b.booking_code
            FROM booking_customers bc
            JOIN bookings b ON bc.booking_id = b.id
            WHERE b.tour_id = ? AND b.start_date = ?
            ORDER BY bc.type DESC, bc.name ASC
        ", $departure['tour_id'], $departure['departure_date']);

        // Truyền dữ liệu sang view (dùng biến global hoặc include đều được)
        // Ở đây mình dùng require view trực tiếp, nên không cần $data
        require "views/guide/customer-list.php";
    }

    public function markAttendance() {
        $this->checkAuth();

        $bc_id = $_POST['bc_id'] ?? 0;
        $departure_id = $_POST['departure_id'] ?? 0;

        if (!$bc_id || !$departure_id) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            header("Location: index.php?act=hdv-customers&departure_id=$departure_id");
            exit;
        }

        // Kiểm tra quyền: khách này có thuộc tour của HDV không?
        $check = pdo_query_one("
            SELECT d.guide_id
            FROM departures d
            JOIN bookings b ON b.tour_id = d.tour_id AND b.start_date = d.departure_date
            JOIN booking_customers bc ON bc.booking_id = b.id
            WHERE bc.id = ? AND d.id = ?
        ", $bc_id, $departure_id);

        if (!$check || $check['guide_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = "Bạn không có quyền điểm danh khách này!";
            header("Location: index.php?act=hdv-customers&departure_id=$departure_id");
            exit;
        }

        // Kiểm tra đã điểm danh chưa
        $current = pdo_query_one("SELECT attended FROM booking_customers WHERE id = ?", $bc_id);

        if ($current && $current['attended'] == 1) {
            $_SESSION['error'] = "Khách này đã được điểm danh rồi!";
        } else {
            // Cập nhật điểm danh thật vào database
            pdo_execute("UPDATE booking_customers SET attended = 1 WHERE id = ?", $bc_id);
            $_SESSION['success'] = "Điểm danh thành công cho khách!";
        }

        // Quay lại trang danh sách với departure_id để reload dữ liệu mới
        header("Location: index.php?act=hdv-customers&departure_id=$departure_id");
        exit;
    }
}
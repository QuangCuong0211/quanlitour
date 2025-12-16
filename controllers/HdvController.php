<?php
class HdvController {

    // Kiểm tra quyền HDV (dùng chung cho tất cả method)
    private function checkAuth() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'hdv') {
            $_SESSION['error'] = "Bạn không có quyền truy cập!";
            header("Location: index.php?act=login");
            exit;
        }
    }

    public function dashboard() {
        $this->checkAuth();
        // Code dashboard sẽ thêm ở bước sau
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

        // Lấy danh sách khách hàng chi tiết
        $customers = pdo_query("
            SELECT bc.id AS bc_id, bc.name, bc.phone, bc.email, bc.type,
                   b.booking_code, b.status AS booking_status
            FROM booking_customers bc
            JOIN bookings b ON bc.booking_id = b.id
            WHERE b.tour_id = ? AND b.start_date = ?
            ORDER BY bc.type DESC, bc.name ASC
        ", $departure['tour_id'], $departure['departure_date']);

        // Truyền dữ liệu sang view
        $data = [
            'departure' => $departure,
            'customers' => $customers
        ];

        // Dùng cách render giống admin (nếu bạn có hàm render) hoặc require trực tiếp
        require "views/guide/customer-list.php";
    }

       public function markAttendance() {
        $this->checkAuth();

        $bc_id = $_POST['bc_id'] ?? 0;
        $departure_id = $_POST['departure_id'] ?? 0;

        if (!$bc_id || !$departure_id) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
        } else {
            // Kiểm tra quyền: khách này có thuộc tour của HDV không?
            $check = pdo_query_one("
                SELECT d.guide_id
                FROM departures d
                JOIN bookings b ON b.tour_id = d.tour_id AND b.start_date = d.departure_date
                JOIN booking_customers bc ON bc.booking_id = b.id
                WHERE bc.id = ? AND d.id = ?
            ", $bc_id, $departure_id);

            if ($check && $check['guide_id'] == $_SESSION['user_id']) {
                // Ở đây bạn có thể:
                // 1. Thêm cột attended (tinyint) vào bảng booking_customers (khuyến nghị)
                // 2. Hoặc tạo bảng attendance_log riêng
                // Tạm thời mình giả lập thành công (bạn có thể mở rộng sau)

                // Ví dụ đơn giản: thêm cột attended nếu chưa có (bạn chạy SQL 1 lần)
                // ALTER TABLE booking_customers ADD COLUMN attended TINYINT(1) DEFAULT 0;

                // Cập nhật điểm danh
                pdo_execute("UPDATE booking_customers SET attended = 1 WHERE id = ?", $bc_id);

                $_SESSION['success'] = "Điểm danh thành công!";
            } else {
                $_SESSION['error'] = "Bạn không có quyền điểm danh khách này!";
            }
        }

        header("Location: index.php?act=hdv-customers&departure_id=$departure_id");
        exit;
    }
}
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
        require "views/guide/customer-list.php";
    }

    public function markAttendance() {
        $this->checkAuth();
        // Code điểm danh sẽ thêm sau
        header("Location: index.php?act=hdv-customers" . (isset($_GET['departure_id']) ? "&departure_id=" . $_GET['departure_id'] : ""));
    }
}
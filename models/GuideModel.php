<?php
require_once "commons/database.php";
require_once "commons/function.php";

class GuideModel {

    // Lấy tất cả HDV (hướng dẫn viên)
    public static function getGuides($search = '') {
        if (!empty($search)) {
            return pdo_query(
                "SELECT id, name, email, phone, role, status, created_at FROM users WHERE role = 'hdv' AND (name LIKE ? OR email LIKE ? OR phone LIKE ?) ORDER BY id DESC",
                "%$search%", "%$search%", "%$search%"
            );
        }
        return pdo_query("SELECT id, name, email, phone, role, status, created_at FROM users WHERE role = 'hdv' ORDER BY id DESC");
    }

    // Lấy HDV theo ID
    public static function findGuide($id) {
        return pdo_query_one("SELECT id, name, email, phone, role, status, created_at FROM users WHERE id = ? AND role = 'hdv'", $id);
    }

    // Tạo HDV mới
    public static function createGuide($name, $email, $phone, $password) {
        $hashed_password = md5($password);
        return pdo_execute(
            "INSERT INTO users (name, email, phone, password, role, status) VALUES (?, ?, ?, ?, 'hdv', 1)",
            $name, $email, $phone, $hashed_password
        );
    }

    // Cập nhật thông tin HDV
    public static function updateGuide($id, $name, $email, $phone) {
        return pdo_execute(
            "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ? AND role = 'hdv'",
            $name, $email, $phone, $id
        );
    }

    // Đổi mật khẩu HDV
    public static function changePassword($id, $new_password) {
        $hashed_password = md5($new_password);
        return pdo_execute(
            "UPDATE users SET password = ? WHERE id = ? AND role = 'hdv'",
            $hashed_password, $id
        );
    }

    // Khóa/Mở tài khoản HDV
    public static function toggleStatus($id) {
        $guide = self::findGuide($id);
        if (!$guide) return false;
        
        $new_status = $guide['status'] ? 0 : 1;
        return pdo_execute(
            "UPDATE users SET status = ? WHERE id = ? AND role = 'hdv'",
            $new_status, $id
        );
    }

    // Xóa HDV
    public static function deleteGuide($id) {
        return pdo_execute("DELETE FROM users WHERE id = ? AND role = 'hdv'", $id);
    }

    // Lấy thông tin HDV cùng số booking
    public static function getGuideWithStats($id) {
        $guide = self::findGuide($id);
        if (!$guide) return null;
        
        $stats = pdo_query_one(
            "SELECT COUNT(*) as total_bookings FROM bookings WHERE guide_id = ?",
            $id
        );
        
        return array_merge($guide, $stats);
    }
}
?>

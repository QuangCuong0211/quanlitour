<?php
require_once "commons/env.php";

class UserModel {

    // Lấy tất cả user
    public static function all() {
        return pdo_query("SELECT * FROM users ORDER BY id DESC");
    }

    // Lấy user theo ID
    public static function find($id) {
        return pdo_query_one("SELECT * FROM users WHERE id = ?", $id);
    }

    // Thêm user
    public static function create($fullname, $email, $password, $role) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        return pdo_execute(
            "INSERT INTO users(fullname,email,password,role) VALUES (?,?,?,?)",
            $fullname, $email, $password, $role
        );
    }

    // Cập nhật user
    public static function updateUser($id, $fullname, $email, $role, $status) {
        return pdo_execute(
            "UPDATE users SET fullname=?, email=?, role=?, status=? WHERE id=?",
            $fullname, $email, $role, $status, $id
        );
    }

    // Xóa user
    public static function deleteUser($id) {
        return pdo_execute("DELETE FROM users WHERE id=?", $id);
    }
}

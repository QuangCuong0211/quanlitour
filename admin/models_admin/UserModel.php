<?php

class UserModel extends BaseModel {
    
    // Lấy tất cả người dùng
    public function getAll() {
        $sql = "SELECT * FROM nguoidung ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }
    
    // Lấy người dùng theo ID
    public function getById($id) {
        $sql = "SELECT * FROM nguoidung WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    // Thêm người dùng mới
    public function create($data) {
        $sql = "INSERT INTO nguoidung (full_name, email, password, role, status, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['full_name'],
            $data['email'],
            $data['password'],
            $data['role'],
            $data['status']
        ]);
    }
    
    // Cập nhật người dùng
    public function update($id, $data) {
        $sql = "UPDATE nguoidung SET full_name = ?, email = ?, role = ?, status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['full_name'],
            $data['email'],
            $data['role'],
            $data['status'],
            $id
        ]);
    }
    
    // Cập nhật mật khẩu
    public function updatePassword($id, $password) {
        $sql = "UPDATE nguoidung SET password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$password, $id]);
    }
    
    // Xóa người dùng
    public function delete($id) {
        $sql = "DELETE FROM nguoidung WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Kiểm tra email có tồn tại
    public function checkEmailExists($email, $excludeId = null) {
        if ($excludeId) {
            $sql = "SELECT COUNT(*) as count FROM nguoidung WHERE email = ? AND id != ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$email, $excludeId]);
        } else {
            $sql = "SELECT COUNT(*) as count FROM nguoidung WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$email]);
        }
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
    
    // Tìm kiếm người dùng
    public function search($keyword) {
        $sql = "SELECT * FROM nguoidung WHERE full_name LIKE ? OR email LIKE ? ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $keyword = '%' . $keyword . '%';
        $stmt->execute([$keyword, $keyword]);
        return $stmt->fetchAll();
    }
}

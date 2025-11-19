<?php

class UserModel {
    private $conn;
    private $table = 'users';

    public function __construct() {
        $this->conn = connectDB();
    }

    // Lấy tất cả người dùng
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy người dùng theo ID
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Lấy người dùng theo email
    public function getByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Thêm người dùng mới
    public function create($data) {
        $sql = "INSERT INTO {$this->table} 
                (name, email, password, phone, role, status, created_at) 
                VALUES (:name, :email, :password, :phone, :role, :status, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':role', $data['role']); // 'admin' hoặc 'hdv'
        $stmt->bindParam(':status', $data['status']); // 0 hoặc 1

        return $stmt->execute();
    }

    // Cập nhật người dùng
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                name = :name, 
                email = :email, 
                phone = :phone, 
                role = :role, 
                status = :status,
                updated_at = NOW() 
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':status', $data['status']);

        return $stmt->execute();
    }

    // Cập nhật mật khẩu
    public function updatePassword($id, $password) {
        $sql = "UPDATE {$this->table} SET 
                password = :password,
                updated_at = NOW() 
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':password', $password);

        return $stmt->execute();
    }

    // Xóa người dùng
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Đăng nhập
    public function login($email, $password) {
        $user = $this->getByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] == 1) {
                return $user;
            } else {
                return null; // Tài khoản bị khóa
            }
        }
        
        return null;
    }

    // Kiểm tra email đã tồn tại
    public function emailExists($email, $excludeId = null) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE email = :email";
        
        if ($excludeId) {
            $sql .= " AND id != :excludeId";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        
        if ($excludeId) {
            $stmt->bindParam(':excludeId', $excludeId);
        }
        
        $stmt->execute();
        $result = $stmt->fetch();
        
        return $result['count'] > 0;
    }

    // Lấy danh sách HDV
    public function getHDVList() {
        $sql = "SELECT * FROM {$this->table} WHERE role = 'hdv' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy danh sách Admin
    public function getAdminList() {
        $sql = "SELECT * FROM {$this->table} WHERE role = 'admin' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

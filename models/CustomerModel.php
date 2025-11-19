<?php

class CustomerModel {
    private $conn;
    private $table = 'customers';

    public function __construct() {
        $this->conn = connectDB();
    }

    // Lấy tất cả khách hàng
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy khách hàng theo ID
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Lấy khách hàng theo email
    public function getByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Thêm khách hàng mới
    public function create($data) {
        $sql = "INSERT INTO {$this->table} 
                (name, email, phone, address, city, identity_number, status, created_at) 
                VALUES (:name, :email, :phone, :address, :city, :identity_number, :status, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':city', $data['city']);
        $stmt->bindParam(':identity_number', $data['identity_number']);
        $stmt->bindParam(':status', $data['status']);

        return $stmt->execute();
    }

    // Cập nhật khách hàng
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                name = :name, 
                email = :email, 
                phone = :phone, 
                address = :address, 
                city = :city, 
                identity_number = :identity_number, 
                status = :status,
                updated_at = NOW() 
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':city', $data['city']);
        $stmt->bindParam(':identity_number', $data['identity_number']);
        $stmt->bindParam(':status', $data['status']);

        return $stmt->execute();
    }

    // Xóa khách hàng
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Kiểm tra email tồn tại
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

    // Tìm kiếm khách hàng
    public function search($keyword) {
        $keyword = "%$keyword%";
        $sql = "SELECT * FROM {$this->table} 
                WHERE name LIKE :keyword OR email LIKE :keyword OR phone LIKE :keyword
                ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy danh sách khách hàng theo trạng thái
    public function getByStatus($status) {
        $sql = "SELECT * FROM {$this->table} WHERE status = :status ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Đếm tổng khách hàng
    public function countAll() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }

    // Lấy khách hàng mới nhất
    public function getRecent($limit = 5) {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

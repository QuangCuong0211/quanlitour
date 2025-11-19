<?php

class DepartureModel {
    private $conn;
    private $table = 'departures';

    public function __construct() {
        $this->conn = connectDB();
    }

    // Lấy tất cả lịch khởi hành
    public function getAll() {
        $sql = "SELECT d.*, t.name as tour_name 
                FROM {$this->table} d
                LEFT JOIN tours t ON d.tour_id = t.id
                ORDER BY d.departure_date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy lịch khởi hành theo ID
    public function getById($id) {
        $sql = "SELECT d.*, t.name as tour_name, t.price as tour_price
                FROM {$this->table} d
                LEFT JOIN tours t ON d.tour_id = t.id
                WHERE d.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Lấy lịch khởi hành theo tour_id
    public function getByTourId($tour_id) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE tour_id = :tour_id 
                ORDER BY departure_date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tour_id', $tour_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Thêm lịch khởi hành mới
    public function create($data) {
        $sql = "INSERT INTO {$this->table} 
                (tour_id, departure_date, return_date, guide_id, seats_available, status, created_at) 
                VALUES (:tour_id, :departure_date, :return_date, :guide_id, :seats_available, :status, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':tour_id', $data['tour_id']);
        $stmt->bindParam(':departure_date', $data['departure_date']);
        $stmt->bindParam(':return_date', $data['return_date']);
        $stmt->bindParam(':guide_id', $data['guide_id']);
        $stmt->bindParam(':seats_available', $data['seats_available']);
        $stmt->bindParam(':status', $data['status']);

        return $stmt->execute();
    }

    // Cập nhật lịch khởi hành
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                tour_id = :tour_id,
                departure_date = :departure_date, 
                return_date = :return_date, 
                guide_id = :guide_id, 
                seats_available = :seats_available, 
                status = :status,
                updated_at = NOW() 
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':tour_id', $data['tour_id']);
        $stmt->bindParam(':departure_date', $data['departure_date']);
        $stmt->bindParam(':return_date', $data['return_date']);
        $stmt->bindParam(':guide_id', $data['guide_id']);
        $stmt->bindParam(':seats_available', $data['seats_available']);
        $stmt->bindParam(':status', $data['status']);

        return $stmt->execute();
    }

    // Xóa lịch khởi hành
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Lấy số ghế có sẵn
    public function getAvailableSeats($id) {
        $sql = "SELECT seats_available FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? $result['seats_available'] : 0;
    }

    // Cập nhật số ghế
    public function updateAvailableSeats($id, $seats) {
        $sql = "UPDATE {$this->table} SET seats_available = :seats WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':seats', $seats);
        return $stmt->execute();
    }

    // Lấy danh sách lịch sắp tới
    public function getUpcomingDepartures() {
        $sql = "SELECT d.*, t.name as tour_name
                FROM {$this->table} d
                LEFT JOIN tours t ON d.tour_id = t.id
                WHERE d.departure_date >= DATE(NOW()) AND d.status = 'active'
                ORDER BY d.departure_date ASC
                LIMIT 10";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Đếm số lịch khởi hành
    public function countAll() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
}

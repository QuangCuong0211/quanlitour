<?php
class DepartureModel
{
    public $conn;

    public function __construct()
    {
        require_once __DIR__ . '/../commons/env.php';

        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

        if ($this->conn->connect_error) {
            die('Kết nối DB thất bại: ' . $this->conn->connect_error);
        }
    }

    // Lấy tất cả lịch khởi hành với thông tin tour
    public function getAllDepartures()
    {
        $sql = "SELECT d.*, t.name as tour_name, u.name as guide_name 
                FROM departures d
                LEFT JOIN tours t ON d.tour_id = t.id
                LEFT JOIN users u ON d.guide_id = u.id
                ORDER BY d.departure_date DESC";
        $result = $this->conn->query($sql);

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    // Lấy lịch khởi hành theo id
    public function getDepartureById($id)
    {
        $sql = "SELECT d.*, t.name as tour_name, u.name as guide_name 
                FROM departures d
                LEFT JOIN tours t ON d.tour_id = t.id
                LEFT JOIN users u ON d.guide_id = u.id
                WHERE d.id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $departure = $result->fetch_assoc();
        $stmt->close();

        return $departure ?: false;
    }

    // Lấy danh sách tour
    public function getTours()
    {
        $sql = "SELECT id, name FROM tours ORDER BY name ASC";
        $result = $this->conn->query($sql);

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    // Lấy danh sách hướng dẫn viên
    public function getGuides()
    {
        $sql = "SELECT id, name FROM users WHERE role = 'hdv' ORDER BY name ASC";
        $result = $this->conn->query($sql);

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    // Thêm lịch khởi hành
    public function insertDeparture($tour_id, $departure_date, $return_date, $guide_id, $seats_available, $status = 'active')
    {
        $sql = "INSERT INTO departures (tour_id, departure_date, return_date, guide_id, seats_available, status) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("isssis", $tour_id, $departure_date, $return_date, $guide_id, $seats_available, $status);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    // Cập nhật lịch khởi hành
    public function updateDeparture($id, $tour_id, $departure_date, $return_date, $guide_id, $seats_available, $status = 'active')
    {
        $sql = "UPDATE departures SET tour_id = ?, departure_date = ?, return_date = ?, guide_id = ?, seats_available = ?, status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("isssii", $tour_id, $departure_date, $return_date, $guide_id, $seats_available, $status, $id);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    // Xóa lịch khởi hành
    public function deleteDeparture($id)
    {
        $sql = "DELETE FROM departures WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }
}

<?php
class TourModel
{
    public $conn;

    public function __construct()
    {
        // Kết nối DB – dùng env.php
        require_once __DIR__ . '/../commons/env.php';

        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

        if ($this->conn->connect_error) {
            die('Kết nối DB thất bại: ' . $this->conn->connect_error);
        }
    }

    // Lấy tất cả tour
    public function getAllTours()
    {
        $sql = "SELECT * FROM tours ORDER BY id DESC";
        $result = $this->conn->query($sql);

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    // Lấy tour theo id
    public function getTourById($id)
    {
        $sql = "SELECT * FROM tours WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tour   = $result->fetch_assoc();
        $stmt->close();

        return $tour ?: false;
    }

    // Thêm tour
    public function insertTour($name, $desc, $price)
    {
        $sql = "INSERT INTO tours (name, description, price) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssd", $name, $desc, $price);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    // Cập nhật tour – trả về status chi tiết
    public function updateTour($id, $name, $desc, $price)
    {
        $sql = "UPDATE tours SET name = ?, description = ?, price = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return [
                'status'  => 'error',
                'message' => 'Lỗi prepare: ' . $this->conn->error,
            ];
        }

        $stmt->bind_param("ssdi", $name, $desc, $price, $id);

        if (!$stmt->execute()) {
            $err = $stmt->error;
            $stmt->close();
            return [
                'status'  => 'error',
                'message' => 'Lỗi execute: ' . $err,
            ];
        }

        $affected = $stmt->affected_rows;
        $stmt->close();

        if ($affected > 0) {
            return [
                'status'   => 'updated',
                'affected' => $affected,
            ];
        } else {
            return [
                'status'   => 'nochange',
                'affected' => 0,
            ];
        }
    }

    // Xóa tour
    public function deleteTour($id)
    {
        $sql = "DELETE FROM tours WHERE id = ?";
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

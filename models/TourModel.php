<?php
class TourModel
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

    // Lấy tour theo ID
    public function getTourById($id)
    {
        $sql = "SELECT * FROM tours WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) return false;

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tour   = $result->fetch_assoc();
        $stmt->close();

        return $tour ?: false;
    }

    // Thêm tour bằng mảng dữ liệu
    public function insertTour($data)
    {
        $sql = "INSERT INTO tours (tour_id, name, description, departure_date, price, customer, guide, status, note)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param(
            "sssssssss",
            $data['tour_id'],
            $data['name'],
            $data['description'],
            $data['departure_date'],
            $data['price'],
            $data['customer'],
            $data['guide'],
            $data['status'],
            $data['note']
        );

        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    // Cập nhật tour bằng mảng dữ liệu
    public function updateTour($id, $data)
    {
        $sql = "UPDATE tours SET
                    tour_id = ?,
                    name = ?,
                    description = ?,
                    departure_date = ?,
                    price = ?,
                    customer = ?,
                    guide = ?,
                    status = ?,
                    note = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return ['status' => 'error', 'message' => $this->conn->error];
        }

        $stmt->bind_param(
            "sssssssssi",
            $data['tour_id'],
            $data['name'],
            $data['description'],
            $data['departure_date'],
            $data['price'],
            $data['customer'],
            $data['guide'],
            $data['status'],
            $data['note'],
            $id
        );

        if (!$stmt->execute()) {
            $err = $stmt->error;
            $stmt->close();
            return ['status' => 'error', 'message' => $err];
        }

        $affected = $stmt->affected_rows;
        $stmt->close();

        return [
            'status'   => $affected > 0 ? 'updated' : 'nochange',
            'affected' => $affected
        ];
    }

    // Xóa tour
    public function deleteTour($id)
    {
        $sql = "DELETE FROM tours WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) return false;

        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }
}

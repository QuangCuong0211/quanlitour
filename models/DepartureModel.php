<?php
class DepartureModel
{
    private mysqli $conn;

    public function __construct()
    {
        require_once __DIR__ . '/../commons/env.php';

        $this->conn = new mysqli(
            DB_HOST,
            DB_USERNAME,
            DB_PASSWORD,
            DB_NAME,
            DB_PORT
        );

        if ($this->conn->connect_error) {
            die('Kết nối DB thất bại: ' . $this->conn->connect_error);
        }

        $this->conn->set_charset('utf8mb4');
    }

    // =============================
    // LẤY DANH SÁCH LỊCH KHỞI HÀNH
    // =============================
    public function getAllDepartures(): array
    {
        $sql = "
            SELECT 
                d.*,
                t.name AS tour_name,
                u.name AS guide_name
            FROM departures d
            LEFT JOIN tours t ON d.tour_id = t.id
            LEFT JOIN users u ON d.guide_id = u.id
            ORDER BY d.departure_date DESC
        ";

        $result = $this->conn->query($sql);
        $data = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $result->free();
        }

        return $data;
    }

    // =============================
    // LẤY 1 LỊCH KHỞI HÀNH
    // =============================
    public function getDepartureById(int $id): ?array
    {
        $sql = "
            SELECT 
                d.*,
                t.name AS tour_name,
                u.name AS guide_name
            FROM departures d
            LEFT JOIN tours t ON d.tour_id = t.id
            LEFT JOIN users u ON d.guide_id = u.id
            WHERE d.id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return null;

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc() ?: null;
        $stmt->close();

        return $row;
    }

    // =============================
    // THÊM LỊCH KHỞI HÀNH
    // =============================
    public function insertDeparture(
        int $tour_id,
        string $departure_date,
        string $return_date,
        int $guide_id,
        int $seats_available,
        string $status = 'active'
    ): bool {
        $sql = "
            INSERT INTO departures 
            (tour_id, departure_date, return_date, guide_id, seats_available, status)
            VALUES (?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param(
            "issiis",
            $tour_id,
            $departure_date,
            $return_date,
            $guide_id,
            $seats_available,
            $status
        );

        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    // =============================
    // CẬP NHẬT
    // =============================
    public function updateDeparture(
        int $id,
        int $tour_id,
        string $departure_date,
        string $return_date,
        int $guide_id,
        int $seats_available,
        string $status
    ): bool {
        $sql = "
            UPDATE departures 
            SET tour_id = ?, departure_date = ?, return_date = ?, 
                guide_id = ?, seats_available = ?, status = ?
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param(
            "ississi",
            $tour_id,
            $departure_date,
            $return_date,
            $guide_id,
            $seats_available,
            $status,
            $id
        );

        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    // =============================
    // XOÁ
    // =============================
    public function deleteDeparture(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM departures WHERE id = ?");
        if (!$stmt) return false;

        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }
}

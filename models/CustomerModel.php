<?php
class CustomerModel
{
    public mysqli $conn;

    public function __construct()
    {
        require_once __DIR__ . '/../commons/env.php';

        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
        if ($this->conn->connect_error) {
            die('Kết nối DB thất bại: ' . $this->conn->connect_error);
        }
        $this->conn->set_charset('utf8mb4');
    }

    public function getCustomersFromBookings(): array
    {
        $sql = "
            SELECT
                bc.id,
                bc.booking_id,
                bc.name,
                bc.email,
                bc.phone,
                bc.type,
                b.booking_code,
                b.start_date,
                b.end_date,
                b.status,
                t.name   AS tour_name,
                t.tour_id AS tour_code
            FROM booking_customers bc
            JOIN bookings b ON bc.booking_id = b.id
            LEFT JOIN tours t ON b.tour_id = t.id
            ORDER BY bc.id DESC";

        $result = $this->conn->query($sql);
        if (!$result) {
            return [];
        }

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $result->free();
        return $rows;
    }

    public function getBookingCustomerById(int $id): ?array
    {
        $sql = "
            SELECT
                bc.*,
                b.booking_code,
                b.start_date,
                b.end_date,
                b.note,
                b.status,
                t.name   AS tour_name,
                t.tour_id AS tour_code
            FROM booking_customers bc
            JOIN bookings b ON bc.booking_id = b.id
            LEFT JOIN tours t ON b.tour_id = t.id
            WHERE bc.id = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $customer = $result->fetch_assoc() ?: null;
        $stmt->close();

        return $customer;
    }

    public function updateBookingCustomer(int $id, array $data): bool
    {
        $customer = $this->getBookingCustomerById($id);
        if (!$customer) {
            return false;
        }

        $sql = "UPDATE booking_customers SET name = ?, email = ?, phone = ?, type = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            'ssssi',
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['type'],
            $id
        );

        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $this->syncBookingCounters((int)$customer['booking_id']);
        }

        return $ok;
    }

    public function deleteBookingCustomer(int $id): bool
    {
        $stmt = $this->conn->prepare('SELECT booking_id FROM booking_customers WHERE id = ?');
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($bookingId);
        $hasRow = $stmt->fetch();
        $stmt->close();

        if (!$hasRow) {
            return false;
        }

        $deleteStmt = $this->conn->prepare('DELETE FROM booking_customers WHERE id = ?');
        if (!$deleteStmt) {
            return false;
        }

        $deleteStmt->bind_param('i', $id);
        $ok = $deleteStmt->execute();
        $deleteStmt->close();

        if ($ok) {
            $this->syncBookingCounters((int)$bookingId);
        }

        return $ok;
    }

    private function syncBookingCounters(int $bookingId): void
    {
        $stmt = $this->conn->prepare(
            "SELECT 
                SUM(CASE WHEN type = 'adult' THEN 1 ELSE 0 END) AS adult,
                SUM(CASE WHEN type = 'child' THEN 1 ELSE 0 END) AS child
             FROM booking_customers WHERE booking_id = ?"
        );

        if (!$stmt) {
            return;
        }

        $stmt->bind_param('i', $bookingId);
        $stmt->execute();
        $stmt->bind_result($adult, $child);
        $stmt->fetch();
        $stmt->close();

        $adult = $adult ?? 0;
        $child = $child ?? 0;

        $update = $this->conn->prepare('UPDATE bookings SET adult = ?, child = ? WHERE id = ?');
        if (!$update) {
            return;
        }

        $update->bind_param('iii', $adult, $child, $bookingId);
        $update->execute();
        $update->close();
    }
}

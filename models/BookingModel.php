<?php
// models/BookingModel.php

class BookingModel
{
    private PDO $conn;

    public function __construct()
    {
        require_once __DIR__ . '/../commons/env.php';

        $this->conn = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USERNAME,
            DB_PASSWORD,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }

    /* =============================
       DANH SÁCH BOOKING (LIST)
       -> FIX: có total_price, adult, child
    ============================== */
   public function getAll(): array
{
    $sql = "
        SELECT 
            b.id,
            b.booking_code,
            b.start_date,
            b.end_date,
            b.note,
            b.status,
            b.total_price,

            SUM(CASE WHEN c.type = 'adult' THEN 1 ELSE 0 END) AS adult,
            SUM(CASE WHEN c.type = 'child' THEN 1 ELSE 0 END) AS child

        FROM bookings b
        LEFT JOIN booking_customers c 
            ON b.id = c.booking_id
        GROUP BY b.id
        ORDER BY b.id DESC
    ";

    return $this->conn->query($sql)->fetchAll();
}


    /* =============================
       CHI TIẾT BOOKING
    ============================== */
    public function getOne(int $id): ?array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM bookings WHERE id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /* =============================
       KHÁCH THEO BOOKING
    ============================== */
    public function getCustomers(int $bookingId): array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM booking_customers WHERE booking_id = ?"
        );
        $stmt->execute([$bookingId]);
        return $stmt->fetchAll();
    }

    /* =============================
       THÊM BOOKING + KHÁCH
    ============================== */
    public function insert(array $booking, array $customers): bool
    {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare(
                "INSERT INTO bookings
                (tour_id, booking_code, adult, child, total_price,
                 start_date, end_date, note, status)
                 VALUES (?,?,?,?,?,?,?,?, 'pending')"
            );

            $stmt->execute([
                $booking['tour_id'],
                $booking['booking_code'],
                $booking['adult'],
                $booking['child'],
                $booking['total_price'],
                $booking['start_date'],
                $booking['end_date'],
                $booking['note']
            ]);

            $bookingId = (int)$this->conn->lastInsertId();

            $stmtCus = $this->conn->prepare(
                "INSERT INTO booking_customers
                (booking_id, name, phone, email, type)
                VALUES (?,?,?,?,?)"
            );

            foreach ($customers as $c) {
                $stmtCus->execute([
                    $bookingId,
                    $c['name'],
                    $c['phone'],
                    $c['email'],
                    $c['type']
                ]);
            }

            $this->conn->commit();
            return true;
        } catch (Throwable $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    /* =============================
       CẬP NHẬT BOOKING + KHÁCH
    ============================== */
    public function update(array $booking, array $customers): bool
    {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare(
                "UPDATE bookings SET
                    adult = ?,
                    child = ?,
                    total_price = ?,
                    start_date = ?,
                    end_date = ?,
                    note = ?
                 WHERE id = ?"
            );

            $stmt->execute([
                $booking['adult'],
                $booking['child'],
                $booking['total_price'],
                $booking['start_date'],
                $booking['end_date'],
                $booking['note'],
                $booking['id']
            ]);

            // Xoá khách cũ
            $this->conn
                ->prepare("DELETE FROM booking_customers WHERE booking_id = ?")
                ->execute([$booking['id']]);

            // Thêm lại khách
            $stmtCus = $this->conn->prepare(
                "INSERT INTO booking_customers
                (booking_id, name, phone, email, type)
                VALUES (?,?,?,?,?)"
            );

            foreach ($customers as $c) {
                $stmtCus->execute([
                    $booking['id'],
                    $c['name'],
                    $c['phone'],
                    $c['email'],
                    $c['type']
                ]);
            }

            $this->conn->commit();
            return true;
        } catch (Throwable $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    /* =============================
       XOÁ BOOKING
    ============================== */
    public function delete(int $id): void
    {
        $this->conn
            ->prepare("DELETE FROM booking_customers WHERE booking_id = ?")
            ->execute([$id]);

        $this->conn
            ->prepare("DELETE FROM bookings WHERE id = ?")
            ->execute([$id]);
    }

    /* =============================
       ĐỔI TRẠNG THÁI
    ============================== */
    public function updateStatus(int $id, string $status): void
    {
        $stmt = $this->conn->prepare(
            "UPDATE bookings SET status = ? WHERE id = ?"
        );
        $stmt->execute([$status, $id]);
    }
}

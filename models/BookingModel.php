<?php
class BookingModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB(); // PDO
    }

    /* =========================
       LẤY TẤT CẢ BOOKING
    ========================== */
    public function getAll()
    {
        $sql = "SELECT * FROM bookings ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* =========================
       LẤY 1 BOOKING THEO ID
    ========================== */
    public function getOne($id)
    {
        $sql = "SELECT * FROM bookings WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* =========================
       THÊM BOOKING
    ========================== */
    public function insert($data)
    {
        $sql = "INSERT INTO bookings 
            (tour_id, booking_code, customer_name, phone, email, 
             adult, child, total_price, start_date, end_date, note)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $data['tour_id'],
            $data['booking_code'],
            $data['customer_name'],
            $data['phone'],
            $data['email'],
            $data['adult'],
            $data['child'],
            $data['total_price'],
            $data['start_date'],
            $data['end_date'],
            $data['note']
        ]);
    }

    /* =========================
       CẬP NHẬT BOOKING
    ========================== */
    public function update($data)
    {
        $sql = "UPDATE bookings SET
                customer_name=?, phone=?, email=?, adult=?, child=?, 
                total_price=?, start_date=?, end_date=?, note=?
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $data['customer_name'],
            $data['phone'],
            $data['email'],
            $data['adult'],
            $data['child'],
            $data['total_price'],
            $data['start_date'],
            $data['end_date'],
            $data['note'],
            $data['id']
        ]);
    }

    /* =========================
       XOÁ BOOKING
    ========================== */
    public function delete($id)
    {
        $sql = "DELETE FROM bookings WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}

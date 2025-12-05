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
             adult, child, total_price, start_date, end_date, note, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";

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
       ĐỔI TRẠNG THÁI
    ========================== */
    public function changeStatus($id, $newStatus)
    {
        // Lấy status cũ
        $old = $this->getOne($id);
        $oldStatus = $old['status'];

        // Cập nhật trạng thái
        $sql = "UPDATE bookings SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([$newStatus, $id]);

        if ($result) {
            $this->logStatus($id, $oldStatus, $newStatus);
        }

        return $result;
    }

    /* =========================
       LƯU LỊCH SỬ TRẠNG THÁI
    ========================== */
    private function logStatus($bookingId, $old, $new)
    {
        $sql = "INSERT INTO booking_status_logs (booking_id, old_status, new_status) 
                VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$bookingId, $old, $new]);
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

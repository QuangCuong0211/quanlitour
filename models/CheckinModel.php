<?php
class CheckinModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function listByBooking($booking_id) {
        $sql = "SELECT * FROM checkins WHERE booking_id = ? ORDER BY checkin_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$booking_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function upsertCheckin($booking_id, $customer_name, $customer_phone, $status, $checked_by, $note) {
        $sql = "SELECT id FROM checkins WHERE booking_id = ? AND customer_name = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$booking_id, $customer_name]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $sql = "UPDATE checkins SET customer_phone = ?, status = ?, checked_by = ?, note = ?, checkin_at = NOW() WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$customer_phone, $status, $checked_by, $note, $existing['id']]);
        }

        $sql = "INSERT INTO checkins (booking_id, customer_name, customer_phone, status, checked_by, note, checkin_at)
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$booking_id, $customer_name, $customer_phone, $status, $checked_by, $note]);
    }

    public function getStatusSummary($booking_id) {
        $sql = "SELECT status, COUNT(*) as qty FROM checkins WHERE booking_id = ? GROUP BY status";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$booking_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function bulkUpdateStatuses($booking_id, array $presentIds, $checked_by) {
        if (!$booking_id) {
            return false;
        }

        $presentIds = array_map('intval', $presentIds);
        $presentMap = array_fill_keys($presentIds, true);
        $records = $this->listByBooking($booking_id);

        $sql = "UPDATE checkins SET status = ?, checked_by = ?, checkin_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        foreach ($records as $record) {
            $status = isset($presentMap[(int)$record['id']]) ? 'present' : 'absent';
            $stmt->execute([$status, $checked_by, $record['id']]);
        }

        return true;
    }
}

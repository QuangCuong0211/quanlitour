<?php

class TourModel
{
    /* =========================
       LẤY TẤT CẢ TOUR (CHO BOOKING)
       ========================= */
    public function getAllTours()
    {
        $sql = "
            SELECT 
                t.*,
                g.name AS guide_name
            FROM tours t
            LEFT JOIN guides g ON t.guide_id = g.id
            ORDER BY t.id DESC
        ";
        return pdo_query($sql);
    }

    /* =========================
       LẤY 1 TOUR THEO ID
       ========================= */
    public function getOne($id)
    {
        $sql = "
            SELECT 
                t.*,
                g.name AS guide_name
            FROM tours t
            LEFT JOIN guides g ON t.guide_id = g.id
            WHERE t.id = ?
        ";
        return pdo_query_one($sql, $id);
    }

    /* =========================
       THÊM TOUR
       ========================= */
    public function insert($data)
    {
        $sql = "
            INSERT INTO tours (name, price, guide_id, status)
            VALUES (?, ?, ?, ?)
        ";
        pdo_execute(
            $sql,
            $data['name'],
            $data['price'],
            $data['guide_id'],
            $data['status']
        );
    }

    /* =========================
       CẬP NHẬT TOUR
       ========================= */
    public function update($id, $data)
    {
        $sql = "
            UPDATE tours
            SET name = ?, price = ?, guide_id = ?, status = ?
            WHERE id = ?
        ";
        pdo_execute(
            $sql,
            $data['name'],
            $data['price'],
            $data['guide_id'],
            $data['status'],
            $id
        );
    }

    /* =========================
       XOÁ TOUR
       ========================= */
    public function delete($id)
    {
        pdo_execute("DELETE FROM tours WHERE id = ?", $id);
    }
    /* =========================
       KIỂM TRA TOUR CÓ BOOKING KHÔNG
       ========================= */
    public function hasBooking($tourId)
{
    $sql = "SELECT COUNT(*) FROM bookings WHERE tour_id = ?";
    return pdo_query_value($sql, $tourId) > 0;
}

}

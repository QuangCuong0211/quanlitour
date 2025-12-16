<?php
class TourModel
{
    /* =========================
       LẤY TẤT CẢ TOUR (CÓ DANH MỤC)
    ========================= */
    public function getAllTours()
    {
        $sql = "
            SELECT 
                t.*,
                c.name AS category_name
            FROM tours t
            LEFT JOIN categories c ON c.id = t.category_id
            ORDER BY t.id DESC
        ";
        return pdo_query($sql);
    }

    public function getOne($id)
    {
        $sql = "
            SELECT * FROM tours WHERE id = ?
        ";
        return pdo_query_one($sql, $id);
    }

    public function insert($data)
    {
        $sql = "
            INSERT INTO tours (name, price, category_id, status)
            VALUES (?, ?, ?, ?)
        ";
        pdo_execute(
            $sql,
            $data['name'],
            $data['price'],
            $data['category_id'],
            $data['status']
        );
    }

    public function update($id, $data)
    {
        $sql = "
            UPDATE tours
            SET name = ?, price = ?, category_id = ?, status = ?
            WHERE id = ?
        ";
        pdo_execute(
            $sql,
            $data['name'],
            $data['price'],
            $data['category_id'],
            $data['status'],
            $id
        );
    }

    public function delete($id)
    {
        pdo_execute("DELETE FROM tours WHERE id = ?", $id);
    }

    public function hasBooking($tourId)
    {
        $sql = "SELECT COUNT(*) FROM bookings WHERE tour_id = ?";
        return pdo_query_value($sql, $tourId) > 0;
    }
}

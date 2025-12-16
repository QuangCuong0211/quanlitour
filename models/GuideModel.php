<?php
class GuideModel
{
    /* =====================
       DANH SÁCH HDV
    ====================== */
    public function getAll()
    {
        $sql = "
            SELECT g.*, t.name AS tour_name
            FROM guides g
            LEFT JOIN tours t ON t.guide_id = g.id
            ORDER BY g.id DESC
        ";
        return pdo_query($sql);
    }

    /* =====================
       LẤY 1 HDV
    ====================== */
    public function getById($id)
    {
        $sql = "
            SELECT g.*, t.id AS tour_id
            FROM guides g
            LEFT JOIN tours t ON t.guide_id = g.id
            WHERE g.id = ?
        ";
        return pdo_query_one($sql, $id);
    }

    /* =====================
       THÊM HDV
    ====================== */
    public function insert($data)
    {
        $sql = "INSERT INTO guides (name, email, sdt, img, status)
                VALUES (?, ?, ?, ?, ?)";
        $guideId = pdo_execute(
            $sql,
            $data['name'],
            $data['email'],
            $data['sdt'],
            $data['img'],
            $data['status']
        );

        // gán tour
        if (!empty($data['tour_id'])) {
            pdo_execute(
                "UPDATE tours SET guide_id = ? WHERE id = ?",
                $guideId,
                $data['tour_id']
            );
        }
        return true;
    }

    /* =====================
       CẬP NHẬT HDV
    ====================== */
    public function update($data)
    {
        $sql = "UPDATE guides
                SET name=?, email=?, sdt=?, img=?, status=?
                WHERE id=?";
        pdo_execute(
            $sql,
            $data['name'],
            $data['email'],
            $data['sdt'],
            $data['img'],
            $data['status'],
            $data['id']
        );

        // bỏ tour cũ
        pdo_execute("UPDATE tours SET guide_id = NULL WHERE guide_id = ?", $data['id']);

        // gán tour mới
        if (!empty($data['tour_id'])) {
            pdo_execute(
                "UPDATE tours SET guide_id = ? WHERE id = ?",
                $data['id'],
                $data['tour_id']
            );
        }
        return true;
    }

    /* =====================
       XOÁ HDV
    ====================== */
    public function delete($id)
    {
        pdo_execute("UPDATE tours SET guide_id = NULL WHERE guide_id = ?", $id);
        pdo_execute("DELETE FROM guides WHERE id = ?", $id);
        return true;
    }
}

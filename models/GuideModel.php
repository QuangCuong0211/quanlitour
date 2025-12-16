<?php
class GuideModel
{
    private $conn;

    public function __construct()
    {
        require_once __DIR__ . '/../commons/database.php';
        $this->conn = connectDB();
    }

    public function getAll()
    {
        return pdo_query("SELECT * FROM guides ORDER BY id DESC");
    }

    public function find($id)
    {
        return pdo_query_one("SELECT * FROM guides WHERE id = ?", $id);
    }

    public function insert($name, $email, $sdt, $img, $status)
    {
        return pdo_execute(
            "INSERT INTO guides(name,email,sdt,img,status) VALUES (?,?,?,?,?)",
            $name, $email, $sdt, $img, $status
        );
    }

    public function update($id, $name, $email, $sdt, $img, $status)
    {
        return pdo_execute(
            "UPDATE guides SET name=?, email=?, sdt=?, img=?, status=? WHERE id=?",
            $name, $email, $sdt, $img, $status, $id
        );
    }

    public function delete($id)
    {
        return pdo_execute("DELETE FROM guides WHERE id=?", $id);
    }
}

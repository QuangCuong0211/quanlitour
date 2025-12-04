<?php
class GuideModel
{
    public $conn;

    public function __construct()
    {
        require_once __DIR__ . '/../commons/env.php';

        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

        if ($this->conn->connect_error) {
            die('Kết nối DB thất bại: ' . $this->conn->connect_error);
        }
    }
 
    // Lấy tất cả khách hàng
    public function getAllGuides()
    {
        $sql = "SELECT * FROM guide ORDER BY id DESC";
        $result = $this->conn->query($sql);

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    // Lấy khách hàng theo id
    public function getGuideById($id)
    {
        $sql = "SELECT * FROM guide WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $guide = $result->fetch_assoc();
        $stmt->close();

        return $guide ?: false;
    }

    // Thêm khách hàng
    public function insertGuide($name, $email, $sdt, $img, $exp, $language)
    {
        $sql = "INSERT INTO guide (name, email, sdt, img, exp, language) 
                VALUES (?, ?, ?,?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssisss", $name, $email, $sdt, $img, $exp, $language);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    // Cập nhật khách hàng
    public function updateGuide($id, $name, $email,  $sdt, $img, $exp, $language)
    {
        $sql = "UPDATE guide SET name = ?, email = ?, sdt = ?, img = ?, exp = ?, language = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssssssi", $name, $email, $sdt, $img, $exp, $language, $id);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    // Xóa khách hàng
    public function deleteGuide($id)
    {
        $sql = "DELETE FROM guide WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }
}

<?php
class CategoryModel
{
    public $conn;

    public function __construct()
    {
        // Kết nối DB – dùng env.php
        require_once __DIR__ . '/../commons/env.php';

        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

        if ($this->conn->connect_error) {
            die('Kết nối DB thất bại: ' . $this->conn->connect_error);
        }
    }

    // Lấy tất cả danh mục
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories ORDER BY id DESC";
        $result = $this->conn->query($sql);

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    // Lấy danh mục theo id
    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_assoc();
        $stmt->close();

        return $category ?: false;
    }

    // Thêm danh mục
    public function insertCategory($name, $description, $slug, $status = 1)
    {
        $sql = "INSERT INTO categories (name, description, slug, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("sssi", $name, $description, $slug, $status);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    // Cập nhật danh mục
    public function updateCategory($id, $name, $description, $slug, $status = 1)
    {
        $sql = "UPDATE categories SET name = ?, description = ?, slug = ?, status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return [
                'status'  => 'error',
                'message' => 'Lỗi prepare: ' . $this->conn->error,
            ];
        }

        $stmt->bind_param("sssii", $name, $description, $slug, $status, $id);

        if (!$stmt->execute()) {
            $err = $stmt->error;
            $stmt->close();
            return [
                'status'  => 'error',
                'message' => 'Lỗi execute: ' . $err,
            ];
        }

        $affected = $stmt->affected_rows;
        $stmt->close();

        if ($affected > 0) {
            return [
                'status'   => 'updated',
                'affected' => $affected,
            ];
        } else {
            return [
                'status'   => 'nochange',
                'affected' => 0,
            ];
        }
    }

    // Xóa danh mục
    public function deleteCategory($id)
    {
        $sql = "DELETE FROM categories WHERE id = ?";
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

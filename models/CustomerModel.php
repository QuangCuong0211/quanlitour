<?php
class CustomerModel
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
    public function getAllCustomers()
    {
        $sql = "SELECT * FROM customers ORDER BY id DESC";
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
    public function getCustomerById($id)
    {
        $sql = "SELECT * FROM customers WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $customer = $result->fetch_assoc();
        $stmt->close();

        return $customer ?: false;
    }

    // Thêm khách hàng
    public function insertCustomer($name, $email, $phone, $address, $city, $identity_number = '', $status = 1)
    {
        $sql = "INSERT INTO customers (name, email, phone, address, city, identity_number, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssssssi", $name, $email, $phone, $address, $city, $identity_number, $status);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    // Cập nhật khách hàng
    public function updateCustomer($id, $name, $email, $phone, $address, $city, $identity_number = '', $status = 1)
    {
        $sql = "UPDATE customers SET name = ?, email = ?, phone = ?, address = ?, city = ?, identity_number = ?, status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssssssii", $name, $email, $phone, $address, $city, $identity_number, $status, $id);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    // Xóa khách hàng
    public function deleteCustomer($id)
    {
        $sql = "DELETE FROM customers WHERE id = ?";
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

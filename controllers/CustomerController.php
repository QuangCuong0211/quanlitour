<?php
class CustomerController
{
    public $modelCustomer;

    public function __construct()
    {
        $this->modelCustomer = new CustomerModel();
    }

    // Hiển thị danh sách khách hàng
    public function customerList()
    {
        $customers = $this->modelCustomer->getAllCustomers();
        require_once './views/customer/list.php';
    }

    // Hiển thị form thêm khách hàng
    public function customerAdd()
    {
        require_once './views/customer/add.php';
    }

    // Lưu khách hàng mới
    public function customerSave()
    {
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['address']) || empty($_POST['city'])) {
            $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin bắt buộc!";
            header("Location: ?act=customer-add");
            exit();
        }

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $city = trim($_POST['city']);
        $identity_number = trim($_POST['identity_number'] ?? '');
        $status = intval($_POST['status'] ?? 1);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email không hợp lệ!";
            header("Location: ?act=customer-add");
            exit();
        }

        if ($this->modelCustomer->insertCustomer($name, $email, $phone, $address, $city, $identity_number, $status)) {
            $_SESSION['success'] = "Thêm khách hàng thành công!";
        } else {
            $_SESSION['error'] = "Thêm khách hàng thất bại!";
        }

        header("Location: ?act=customer-list");
        exit();
    }

    // Hiển thị form chỉnh sửa khách hàng
    public function customerEdit()
    {
        $id = $_GET['id'] ?? 0;
        $customer = $this->modelCustomer->getCustomerById($id);

        if (!$customer) {
            $_SESSION['error'] = "Khách hàng không tồn tại!";
            header("Location: ?act=customer-list");
            exit();
        }

        require_once './views/customer/edit.php';
    }

    // Cập nhật khách hàng
    public function customerUpdate()
    {
        $id = intval($_POST['id']);
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $city = trim($_POST['city']);
        $identity_number = trim($_POST['identity_number'] ?? '');
        $status = intval($_POST['status'] ?? 1);

        if ($id <= 0 || empty($name) || empty($email) || empty($phone) || empty($address) || empty($city)) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            header("Location: ?act=customer-edit&id=$id");
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email không hợp lệ!";
            header("Location: ?act=customer-edit&id=$id");
            exit();
        }

        if ($this->modelCustomer->updateCustomer($id, $name, $email, $phone, $address, $city, $identity_number, $status)) {
            $_SESSION['success'] = "Cập nhật khách hàng thành công!";
        } else {
            $_SESSION['error'] = "Cập nhật khách hàng thất bại!";
        }

        header("Location: ?act=customer-list");
        exit();
    }

    // Xóa khách hàng
    public function customerDelete()
    {
        $id = intval($_GET['id']);

        if ($this->modelCustomer->deleteCustomer($id)) {
            $_SESSION['success'] = "Xóa khách hàng thành công!";
        } else {
            $_SESSION['error'] = "Xóa khách hàng thất bại!";
        }

        header("Location: ?act=customer-list");
        exit();
    }
}

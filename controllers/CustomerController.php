<?php
class CustomerController
{
    public CustomerModel $modelCustomer;

    public function __construct()
    {
        $this->modelCustomer = new CustomerModel();
    }

    public function customerList(): void
    {
        $customers = $this->modelCustomer->getCustomersFromBookings();
        require_once './views/customer/list.php';
    }

    public function customerDetail(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $customer = $this->modelCustomer->getBookingCustomerById($id);

        if (!$customer) {
            $_SESSION['error'] = 'Khách hàng không tồn tại.';
            header('Location: ?act=customer-list');
            exit();
        }

        require_once './views/customer/detail.php';
    }

    public function customerAdd(): void
    {
        $_SESSION['error'] = 'Khách hàng được tạo từ booking, không thể thêm thủ công.';
        header('Location: ?act=customer-list');
        exit();
    }

    public function customerSave(): void
    {
        $_SESSION['error'] = 'Khách hàng được tạo từ booking, không thể thêm thủ công.';
        header('Location: ?act=customer-list');
        exit();
    }

    public function customerEdit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $customer = $this->modelCustomer->getBookingCustomerById($id);

        if (!$customer) {
            $_SESSION['error'] = 'Khách hàng không tồn tại.';
            header('Location: ?act=customer-list');
            exit();
        }

        require_once './views/customer/edit.php';
    }

    public function customerUpdate(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $type = $_POST['type'] ?? 'adult';

        if ($id <= 0) {
            $_SESSION['error'] = 'Yêu cầu không hợp lệ.';
            header('Location: ?act=customer-list');
            exit();
        }

        if ($name === '') {
            $_SESSION['error'] = 'Tên khách hàng không được để trống.';
            header("Location: ?act=customer-edit&id=$id");
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email không hợp lệ.';
            header("Location: ?act=customer-edit&id=$id");
            exit();
        }

        if (!preg_match('/^(03|05|07|08|09)[0-9]{8}$/', $phone)) {
            $_SESSION['error'] = 'Số điện thoại không hợp lệ.';
            header("Location: ?act=customer-edit&id=$id");
            exit();
        }

        if (!in_array($type, ['adult', 'child'], true)) {
            $_SESSION['error'] = 'Loại khách không hợp lệ.';
            header("Location: ?act=customer-edit&id=$id");
            exit();
        }

        $ok = $this->modelCustomer->updateBookingCustomer($id, [
            'name'  => $name,
            'email' => $email,
            'phone' => $phone,
            'type'  => $type,
        ]);

        $_SESSION[$ok ? 'success' : 'error'] = $ok
            ? 'Cập nhật khách hàng thành công.'
            : 'Cập nhật khách hàng thất bại.';

        header('Location: ?act=customer-list');
        exit();
    }

    public function customerDelete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error'] = 'Yêu cầu không hợp lệ.';
            header('Location: ?act=customer-list');
            exit();
        }

        $ok = $this->modelCustomer->deleteBookingCustomer($id);
        $_SESSION[$ok ? 'success' : 'error'] = $ok
            ? 'Xóa khách hàng thành công.'
            : 'Xóa khách hàng thất bại.';

        header('Location: ?act=customer-list');
        exit();
    }
}

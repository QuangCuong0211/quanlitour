<?php

class CustomerController {
    private $customerModel;

    public function __construct() {
        $this->customerModel = new CustomerModel();
    }

    // Danh sách khách hàng
    public function customerList() {
        $search = $_GET['search'] ?? '';
        
        if ($search) {
            $customers = $this->customerModel->search($search);
        } else {
            $customers = $this->customerModel->getAll();
        }
        
        require_once './views/admin/customers/list.php';
    }

    // Form thêm khách hàng
    public function customerAdd() {
        require_once './views/admin/customers/add.php';
    }

    // Lưu khách hàng mới
    public function customerSave() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $city = $_POST['city'] ?? '';
            $identity_number = $_POST['identity_number'] ?? '';
            $status = $_POST['status'] ?? 1;

            $errors = [];

            if (empty($name)) {
                $errors[] = 'Tên khách hàng không được để trống';
            }

            if (empty($email)) {
                $errors[] = 'Email không được để trống';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            } elseif ($this->customerModel->emailExists($email)) {
                $errors[] = 'Email đã tồn tại';
            }

            if (empty($phone)) {
                $errors[] = 'Số điện thoại không được để trống';
            }

            if (empty($address)) {
                $errors[] = 'Địa chỉ không được để trống';
            }

            if (empty($city)) {
                $errors[] = 'Thành phố không được để trống';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: ?act=customer-add');
                exit;
            }

            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'city' => $city,
                'identity_number' => $identity_number,
                'status' => $status
            ];

            if ($this->customerModel->create($data)) {
                $_SESSION['success'] = 'Thêm khách hàng thành công';
                header('Location: ?act=customer-list');
            } else {
                $_SESSION['errors'] = ['Có lỗi xảy ra, vui lòng thử lại'];
                header('Location: ?act=customer-add');
            }
            exit;
        }
    }

    // Form chỉnh sửa khách hàng
    public function customerEdit() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ?act=customer-list');
            exit;
        }

        $customer = $this->customerModel->getById($id);

        if (!$customer) {
            $_SESSION['errors'] = ['Khách hàng không tồn tại'];
            header('Location: ?act=customer-list');
            exit;
        }

        require_once './views/admin/customers/edit.php';
    }

    // Cập nhật khách hàng
    public function customerUpdate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $city = $_POST['city'] ?? '';
            $identity_number = $_POST['identity_number'] ?? '';
            $status = $_POST['status'] ?? 1;

            $errors = [];

            if (!$id) {
                $errors[] = 'ID không hợp lệ';
            }

            if (empty($name)) {
                $errors[] = 'Tên khách hàng không được để trống';
            }

            if (empty($email)) {
                $errors[] = 'Email không được để trống';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            } elseif ($this->customerModel->emailExists($email, $id)) {
                $errors[] = 'Email đã tồn tại';
            }

            if (empty($phone)) {
                $errors[] = 'Số điện thoại không được để trống';
            }

            if (empty($address)) {
                $errors[] = 'Địa chỉ không được để trống';
            }

            if (empty($city)) {
                $errors[] = 'Thành phố không được để trống';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: ?act=customer-edit&id=$id");
                exit;
            }

            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'city' => $city,
                'identity_number' => $identity_number,
                'status' => $status
            ];

            if ($this->customerModel->update($id, $data)) {
                $_SESSION['success'] = 'Cập nhật khách hàng thành công';
                header('Location: ?act=customer-list');
            } else {
                $_SESSION['errors'] = ['Có lỗi xảy ra, vui lòng thử lại'];
                header("Location: ?act=customer-edit&id=$id");
            }
            exit;
        }
    }

    // Xóa khách hàng
    public function customerDelete() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['errors'] = ['ID không hợp lệ'];
            header('Location: ?act=customer-list');
            exit;
        }

        if ($this->customerModel->delete($id)) {
            $_SESSION['success'] = 'Xóa khách hàng thành công';
        } else {
            $_SESSION['errors'] = ['Có lỗi xảy ra, vui lòng thử lại'];
        }

        header('Location: ?act=customer-list');
        exit;
    }
}

<?php

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // Trang danh sách tài khoản
    public function userList() {
        $users = $this->userModel->getAll();
        require_once './views/admin/users/list.php';
    }

    // Trang thêm tài khoản
    public function userAdd() {
        require_once './views/admin/users/add.php';
    }

    // Lưu tài khoản mới
    public function userSave() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $role = $_POST['role'] ?? 'hdv'; // Mặc định là HDV
            $status = $_POST['status'] ?? 1;

            // Validate dữ liệu
            $errors = [];
            
            if (empty($name)) {
                $errors[] = 'Tên không được để trống';
            }
            
            if (empty($email)) {
                $errors[] = 'Email không được để trống';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            } elseif ($this->userModel->emailExists($email)) {
                $errors[] = 'Email đã tồn tại';
            }
            
            if (empty($password)) {
                $errors[] = 'Mật khẩu không được để trống';
            } elseif (strlen($password) < 6) {
                $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự';
            }
            
            if (empty($phone)) {
                $errors[] = 'Số điện thoại không được để trống';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: ?act=user-add');
                exit;
            }

            // Mã hóa mật khẩu
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
                'phone' => $phone,
                'role' => $role,
                'status' => $status
            ];

            if ($this->userModel->create($data)) {
                $_SESSION['success'] = 'Thêm tài khoản thành công';
                header('Location: ?act=user-list');
            } else {
                $_SESSION['errors'] = ['Có lỗi xảy ra, vui lòng thử lại'];
                header('Location: ?act=user-add');
            }
            exit;
        }
    }

    // Trang chỉnh sửa tài khoản
    public function userEdit() {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: ?act=user-list');
            exit;
        }

        $user = $this->userModel->getById($id);
        
        if (!$user) {
            $_SESSION['errors'] = ['Tài khoản không tồn tại'];
            header('Location: ?act=user-list');
            exit;
        }

        require_once './views/admin/users/edit.php';
    }

    // Cập nhật tài khoản
    public function userUpdate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $role = $_POST['role'] ?? 'hdv';
            $status = $_POST['status'] ?? 1;

            // Validate dữ liệu
            $errors = [];
            
            if (empty($id)) {
                $errors[] = 'ID không hợp lệ';
            }
            
            if (empty($name)) {
                $errors[] = 'Tên không được để trống';
            }
            
            if (empty($email)) {
                $errors[] = 'Email không được để trống';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            } elseif ($this->userModel->emailExists($email, $id)) {
                $errors[] = 'Email đã tồn tại';
            }
            
            if (empty($phone)) {
                $errors[] = 'Số điện thoại không được để trống';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: ?act=user-edit&id=$id");
                exit;
            }

            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'role' => $role,
                'status' => $status
            ];

            if ($this->userModel->update($id, $data)) {
                $_SESSION['success'] = 'Cập nhật tài khoản thành công';
                header('Location: ?act=user-list');
            } else {
                $_SESSION['errors'] = ['Có lỗi xảy ra, vui lòng thử lại'];
                header("Location: ?act=user-edit&id=$id");
            }
            exit;
        }
    }

    // Cập nhật mật khẩu
    public function userChangePassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            $errors = [];

            if (empty($currentPassword)) {
                $errors[] = 'Mật khẩu hiện tại không được để trống';
            }

            if (empty($newPassword)) {
                $errors[] = 'Mật khẩu mới không được để trống';
            } elseif (strlen($newPassword) < 6) {
                $errors[] = 'Mật khẩu mới phải có ít nhất 6 ký tự';
            }

            if ($newPassword !== $confirmPassword) {
                $errors[] = 'Mật khẩu xác nhận không khớp';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: ?act=user-edit&id=$id");
                exit;
            }

            $user = $this->userModel->getById($id);

            if (!$user || !password_verify($currentPassword, $user['password'])) {
                $_SESSION['errors'] = ['Mật khẩu hiện tại không chính xác'];
                header("Location: ?act=user-edit&id=$id");
                exit;
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            if ($this->userModel->updatePassword($id, $hashedPassword)) {
                $_SESSION['success'] = 'Cập nhật mật khẩu thành công';
                header("Location: ?act=user-edit&id=$id");
            } else {
                $_SESSION['errors'] = ['Có lỗi xảy ra, vui lòng thử lại'];
                header("Location: ?act=user-edit&id=$id");
            }
            exit;
        }
    }

    // Xóa tài khoản
    public function userDelete() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['errors'] = ['ID không hợp lệ'];
            header('Location: ?act=user-list');
            exit;
        }

        if ($this->userModel->delete($id)) {
            $_SESSION['success'] = 'Xóa tài khoản thành công';
        } else {
            $_SESSION['errors'] = ['Có lỗi xảy ra, vui lòng thử lại'];
        }

        header('Location: ?act=user-list');
        exit;
    }

    // Đăng nhập
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $errors = [];

            if (empty($email)) {
                $errors[] = 'Email không được để trống';
            }

            if (empty($password)) {
                $errors[] = 'Mật khẩu không được để trống';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: ?act=login');
                exit;
            }

            $user = $this->userModel->login($email, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: ?act=admin');
                exit;
            } else {
                $_SESSION['errors'] = ['Email hoặc mật khẩu không chính xác'];
                header('Location: ?act=login');
                exit;
            }
        } else {
            require_once './views/login.php';
        }
    }

    // Đăng xuất
    public function logout() {
        session_destroy();
        header('Location: ?act=login');
        exit;
    }
}

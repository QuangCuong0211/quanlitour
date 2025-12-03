<?php
require_once "models/GuideModel.php";

class GuideController {

    // Danh sách HDV
    public function guideList() {
        $search = $_GET['search'] ?? '';
        $guides = GuideModel::getGuides($search);
        require "views/guide/list.php";
    }

    // Trang thêm HDV
    public function guideAdd() {
        require "views/guide/add.php";
    }

    // Xử lý thêm HDV
    public function guideSave() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($name) || empty($email) || empty($phone) || empty($password)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin!';
                header('Location: ?act=guide-add');
                exit;
            }

            // Kiểm tra email đã tồn tại
            $existing = pdo_query_one("SELECT id FROM users WHERE email = ?", $email);
            if ($existing) {
                $_SESSION['error'] = 'Email đã tồn tại trong hệ thống!';
                header('Location: ?act=guide-add');
                exit;
            }

            if (GuideModel::createGuide($name, $email, $phone, $password)) {
                $_SESSION['success'] = 'Thêm hướng dẫn viên thành công!';
                header('Location: ?act=guide-list');
            } else {
                $_SESSION['error'] = 'Lỗi khi thêm hướng dẫn viên!';
                header('Location: ?act=guide-add');
            }
            exit;
        }
    }

    // Trang sửa HDV
    public function guideEdit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = 'ID không hợp lệ!';
            header('Location: ?act=guide-list');
            exit;
        }

        $guide = GuideModel::findGuide($id);
        if (!$guide) {
            $_SESSION['error'] = 'Hướng dẫn viên không tồn tại!';
            header('Location: ?act=guide-list');
            exit;
        }

        require "views/guide/edit.php";
    }

    // Xử lý sửa HDV
    public function guideUpdate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $new_password = $_POST['new_password'] ?? '';

            if (!$id || empty($name) || empty($email) || empty($phone)) {
                $_SESSION['error'] = 'Thông tin không hợp lệ!';
                header('Location: ?act=guide-list');
                exit;
            }

            $guide = GuideModel::findGuide($id);
            if (!$guide) {
                $_SESSION['error'] = 'Hướng dẫn viên không tồn tại!';
                header('Location: ?act=guide-list');
                exit;
            }

            // Kiểm tra email trùng với người khác
            $existing = pdo_query_one("SELECT id FROM users WHERE email = ? AND id != ?", $email, $id);
            if ($existing) {
                $_SESSION['error'] = 'Email đã tồn tại trong hệ thống!';
                header('Location: ?act=guide-edit&id=' . $id);
                exit;
            }

            if (GuideModel::updateGuide($id, $name, $email, $phone)) {
                // Nếu có nhập mật khẩu mới
                if (!empty($new_password)) {
                    GuideModel::changePassword($id, $new_password);
                }

                $_SESSION['success'] = 'Cập nhật hướng dẫn viên thành công!';
                header('Location: ?act=guide-list');
            } else {
                $_SESSION['error'] = 'Lỗi khi cập nhật hướng dẫn viên!';
                header('Location: ?act=guide-edit&id=' . $id);
            }
            exit;
        }
    }

    // Khóa/Mở tài khoản HDV
    public function guideToggleStatus() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = 'ID không hợp lệ!';
            header('Location: ?act=guide-list');
            exit;
        }

        $guide = GuideModel::findGuide($id);
        if (!$guide) {
            $_SESSION['error'] = 'Hướng dẫn viên không tồn tại!';
            header('Location: ?act=guide-list');
            exit;
        }

        if (GuideModel::toggleStatus($id)) {
            $status = $guide['status'] ? 'khóa' : 'mở khóa';
            $_SESSION['success'] = 'Tài khoản đã được ' . $status . ' thành công!';
        } else {
            $_SESSION['error'] = 'Lỗi khi thay đổi trạng thái tài khoản!';
        }

        header('Location: ?act=guide-list');
        exit;
    }

    // Xóa HDV
    public function guideDelete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = 'ID không hợp lệ!';
            header('Location: ?act=guide-list');
            exit;
        }

        $guide = GuideModel::findGuide($id);
        if (!$guide) {
            $_SESSION['error'] = 'Hướng dẫn viên không tồn tại!';
            header('Location: ?act=guide-list');
            exit;
        }

        if (GuideModel::deleteGuide($id)) {
            $_SESSION['success'] = 'Xóa hướng dẫn viên thành công!';
        } else {
            $_SESSION['error'] = 'Lỗi khi xóa hướng dẫn viên!';
        }

        header('Location: ?act=guide-list');
        exit;
    }
}
?>

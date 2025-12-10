<?php
class GuideController
{
    public $modelGuide;

    public function __construct()
    {
        $this->modelGuide = new GuideModel();
    }

    // Hiển thị danh sách khách hàng
    public function guideList()
    {
        $guides = $this->modelGuide->getAllGuides();
        require_once './views/guide/list.php';
    }

    // Hiển thị form thêm khách hàng
    public function guideAdd()
    {
        require_once './views/guide/add.php';
    }

    // Lưu khách hàng mới
    public function GuideSave()
    {
        // if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['sdt']) || empty($_POST['img']) || empty($_POST['exp']) || empty($_POST['language'])) {
        //     $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin bắt buộc!";
        //     header("Location: ?act=guide-add");
        //     exit();
        // }

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $img = trim($_POST['img']);
        $sdt = trim($_POST['sdt']);
        $exp = trim($_POST['exp']);
        $language = trim($_POST['language']);

        // KIỂM TRA TÊN
        if (empty($name)) {
            $_SESSION['error'] = "Tên HDV không được để trống!";
            header("Location: ?act=guide-add");
            exit();
        }

        // KIỂM TRA EMAIL
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email không hợp lệ!";
            header("Location: ?act=guide-add");
            exit();
        }

        // KIỂM TRA SỐ ĐIỆN THOẠI (chuẩn VN)
        if (!preg_match("/^(03|05|07|08|09)[0-9]{8}$/", $sdt)) {
            $_SESSION['error'] = "Số điện thoại không hợp lệ!";
            header("Location: ?act=guide-add");
            exit();
        }

        // KIỂM TRA KINH NGHIỆM
        if (empty($exp)) {
            $_SESSION['error'] = "Vui lòng nhập kinh nghiệm!";
            header("Location: ?act=guide-add");
            exit();
        }

        // KIỂM TRA NGÔN NGỮ
        if (empty($language)) {
            $_SESSION['error'] = "Vui lòng nhập ngôn ngữ!";
            header("Location: ?act=guide-add");
            exit();
        }
        if ($this->modelGuide->insertGuide($name, $email, $sdt, $img, $exp, $language)) {
            $_SESSION['success'] = "Thêm hdv thành công!";
        } else {
            $_SESSION['error'] = "Thêm hdv thất bại!";
        }

        header("Location: ?act=guide-list");
        exit();
    }

    // Hiển thị form chỉnh sửa khách hàng
    public function guideEdit()
    {
        $id = $_GET['id'] ?? 0;
        $guide = $this->modelGuide->getGuideById($id);

        if (!$guide) {
            $_SESSION['error'] = "hdv không tồn tại!";
            header("Location: ?act=guide-list");
            exit();
        }

        require_once './views/guide/edit.php';
    }


    public function guideUpdate()
    {
        $id = intval($_POST['id']);
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $sdt = trim($_POST['sdt']);
        $img = trim($_POST['img']);
        $exp = trim($_POST['exp']);
        $language = trim($_POST['language']);

        // if ($id <= 0 || empty($name) || empty($email) || empty($sdt) || empty($img) || empty($exp) || empty($language)) {
        //     $_SESSION['error'] = "Dữ liệu không hợp lệ!";
        //     header("Location: ?act=guide-edit&id=$id");
        //     exit();
        // }
        // Validate cơ bản
        if (empty($name)) {
            $_SESSION['error'] = "Tên HDV không được để trống!";
            header("Location: ?act=guide-edit&id=$id");
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email không hợp lệ!";
            header("Location: ?act=guide-edit&id=$id");
            exit();
        }

        if (!preg_match("/^(03|05|07|08|09)[0-9]{8}$/", $sdt)) {
            $_SESSION['error'] = "Số điện thoại không hợp lệ!";
            header("Location: ?act=guide-edit&id=$id");
            exit();
        }

        if (empty($exp)) {
            $_SESSION['error'] = "Vui lòng nhập kinh nghiệm!";
            header("Location: ?act=guide-edit&id=$id");
            exit();
        }

        if (empty($language)) {
            $_SESSION['error'] = "Vui lòng nhập ngôn ngữ!";
            header("Location: ?act=guide-edit&id=$id");
            exit();
        }

        // Xử lý ảnh — KHÔNG BẮT BUỘC đổi
        // if (!empty($img['name'])) {
        //     $filename = time() . "_" . $img['name'];
        //     move_uploaded_file($img['tmp_name'], "uploads/" . $filename);
        // } else {
        //     // Nếu không upload ảnh mới → giữ ảnh cũ
        //     $filename = $gui['img'];
        // }

        // // Lưu vào database (ví dụ)
        // $sql = "UPDATE guide SET 
        //     name=?, email=?, sdt=?, exp=?, language=?, img=?
        // WHERE id=?";

        // // ...code PDO execute...

        // $_SESSION['success'] = "Cập nhật thành công!";
        // header("Location: ?act=guide-edit&id=$id");
        // exit();

        if ($this->modelGuide->updateGuide($id, $name, $email, $sdt, $img, $exp, $language)) {
            $_SESSION['success'] = "Cập nhật hdv thành công!";
        } else {
            $_SESSION['error'] = "Cập nhật hdv thất bại!";
        }

        header("Location: ?act=guide-list");
        exit();
    }

    // Xóa khách hàng
    public function guideDelete()
    {
        $id = intval($_GET['id']);

        if ($this->modelGuide->deleteGuide($id)) {
            $_SESSION['success'] = "Xóa hdv thành công!";
        } else {
            $_SESSION['error'] = "Xóa hdv thất bại!";
        }

        header("Location: ?act=guide-list");
        exit();
    }
}

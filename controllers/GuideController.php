<?php
class GuideController
{
    private $model;

    public function __construct()
    {
        $this->model = new GuideModel();
    }

    /* =====================
       DANH SÁCH
    ====================== */
    public function guideList()
    {
        $guides = $this->model->getAll();
        require './views/guide/list.php';
    }

    /* =====================
       FORM THÊM
    ====================== */
    public function guideAdd()
    {
        $tourModel = new TourModel();
        $tours = $tourModel->getAll();
        require './views/guide/add.php';
    }

    /* =====================
       LƯU THÊM
    ====================== */
    public function guideSave()
    {
        // ===== UPLOAD ẢNH =====
        $imgName = null;

        if (!empty($_FILES['img']['name'])) {
            $uploadDir = './uploads/guides/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
            $allow = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($ext, $allow)) {
                $_SESSION['error'] = "Ảnh không hợp lệ";
                header("Location:?act=guide-add"); exit;
            }

            $imgName = time() . '_' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['img']['tmp_name'], $uploadDir . $imgName);
        }

        $data = [
            'name'   => trim($_POST['name']),
            'email'  => trim($_POST['email']),
            'sdt'    => trim($_POST['sdt']),
            'img'    => $imgName,
            'tour_id'=> $_POST['tour_id'] ?? null,
            'status' => $_POST['status'] ?? 1
        ];

        // ===== VALIDATE =====
        if ($data['name'] === '') {
            $_SESSION['error'] = "Tên HDV không được để trống";
            header("Location:?act=guide-add"); exit;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email không hợp lệ";
            header("Location:?act=guide-add"); exit;
        }

        if (!preg_match('/^(03|05|07|08|09)[0-9]{8}$/', $data['sdt'])) {
            $_SESSION['error'] = "SĐT không hợp lệ";
            header("Location:?act=guide-add"); exit;
        }

        $this->model->insert($data);
        $_SESSION['success'] = "Thêm HDV thành công";
        header("Location:?act=guide-list");
    }

    /* =====================
       FORM SỬA
    ====================== */
    public function guideEdit()
    {
        $guide = $this->model->getById($_GET['id']);
        $tourModel = new TourModel();
        $tours = $tourModel->getAll();
        require './views/guide/edit.php';
    }

    /* =====================
       CẬP NHẬT
    ====================== */
    public function guideUpdate()
    {
        $old = $this->model->getById($_POST['id']);
        $imgName = $old['img'];

        if (!empty($_FILES['img']['name'])) {
            $uploadDir = './uploads/guides/';
            $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
            $allow = ['jpg','jpeg','png','webp'];

            if (!in_array($ext, $allow)) {
                $_SESSION['error'] = "Ảnh không hợp lệ";
                header("Location:?act=guide-edit&id=".$_POST['id']); exit;
            }

            $imgName = time().'_'.uniqid().'.'.$ext;
            move_uploaded_file($_FILES['img']['tmp_name'], $uploadDir.$imgName);

            if ($old['img'] && file_exists($uploadDir.$old['img'])) {
                unlink($uploadDir.$old['img']);
            }
        }

        $data = [
            'id'     => $_POST['id'],
            'name'   => trim($_POST['name']),
            'email'  => trim($_POST['email']),
            'sdt'    => trim($_POST['sdt']),
            'img'    => $imgName,
            'tour_id'=> $_POST['tour_id'] ?? null,
            'status' => $_POST['status']
        ];

        $this->model->update($data);
        $_SESSION['success'] = "Cập nhật HDV thành công";
        header("Location:?act=guide-list");
    }

    /* =====================
       XOÁ
    ====================== */
    public function guideDelete()
    {
        $guide = $this->model->getById($_GET['id']);
        if ($guide['img'] && file_exists('./uploads/guides/'.$guide['img'])) {
            unlink('./uploads/guides/'.$guide['img']);
        }

        $this->model->delete($_GET['id']);
        $_SESSION['success'] = "Đã xoá HDV";
        header("Location:?act=guide-list");
    }
}

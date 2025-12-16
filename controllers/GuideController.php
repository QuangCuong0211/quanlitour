<?php
class GuideController
{
    private $model;

    public function __construct()
    {
        $this->model = new GuideModel();
    }

    public function guideList()
    {
        $guides = $this->model->getAll();
        require "./views/guide/list.php";
    }

    public function guideAdd()
    {
        require "./views/guide/add.php";
    }

    public function guideSave()
    {
        $name  = trim($_POST['name']);
        $email = trim($_POST['email']);
        $sdt   = trim($_POST['sdt']);
        $img   = trim($_POST['img']);
        $status = $_POST['status'] ?? 1;

        if ($name === '') {
            $_SESSION['error'] = "Tên HDV không được trống";
            header("Location:?act=guide-add"); exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email không hợp lệ";
            header("Location:?act=guide-add"); exit;
        }

        if (!preg_match('/^(03|05|07|08|09)[0-9]{8}$/', $sdt)) {
            $_SESSION['error'] = "SĐT không hợp lệ";
            header("Location:?act=guide-add"); exit;
        }

        $this->model->insert($name,$email,$sdt,$img,$status);
        $_SESSION['success'] = "Thêm HDV thành công";
        header("Location:?act=guide-list");
    }

    public function guideEdit()
    {
        $id = $_GET['id'];
        $guide = $this->model->find($id);
        require "./views/guide/edit.php";
    }

    public function guideUpdate()
    {
        $id = $_POST['id'];
        $name  = trim($_POST['name']);
        $email = trim($_POST['email']);
        $sdt   = trim($_POST['sdt']);
        $img   = trim($_POST['img']);
        $status = $_POST['status'];

        if ($name === '') {
            $_SESSION['error'] = "Tên không hợp lệ";
            header("Location:?act=guide-edit&id=$id"); exit;
        }

        $this->model->update($id,$name,$email,$sdt,$img,$status);
        $_SESSION['success'] = "Cập nhật thành công";
        header("Location:?act=guide-list");
    }

    public function guideDelete()
    {
        $this->model->delete($_GET['id']);
        $_SESSION['success'] = "Đã xóa HDV";
        header("Location:?act=guide-list");
    }
}

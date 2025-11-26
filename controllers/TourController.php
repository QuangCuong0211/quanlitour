<?php
class TourController
{
    public $modelTour;

    public function __construct()
    {
        $this->modelTour = new TourModel();
    }

    public function Home()
    {
        require_once './views/trangchu.php';
    }

    public function Admin()
    {
        require_once './views/admin.php';
    }

    public function tourList()
    {
        $tours = $this->modelTour->getAllTours();
        require_once './views/tour/list.php';
    }

    public function tourAdd()
    {
        require_once './views/tour/add.php';
    }

    public function tourSave()
    {
        if (empty($_POST['name']) || empty($_POST['desc']) || empty($_POST['price'])) {
            $_SESSION['error'] = "Thiếu dữ liệu!";
            header("Location: ?act=tour-add");
            exit();
        }

        $name  = trim($_POST['name']);
        $desc  = trim($_POST['desc']);
        $price = floatval($_POST['price']);

        if ($price < 0) {
            $_SESSION['error'] = "Giá tour không hợp lệ!";
            header("Location: ?act=tour-add");
            exit();
        }

        if ($this->modelTour->insertTour($name, $desc, $price)) {
            $_SESSION['success'] = "Thêm tour thành công!";
        } else {
            $_SESSION['error'] = "Thêm tour thất bại!";
        }

        header("Location: ?act=tour-list");
        exit();
    }

    public function tourEdit()
    {
        $id = $_GET['id'] ?? 0;
        $tour = $this->modelTour->getTourById($id);

        if (!$tour) {
            $_SESSION['error'] = "Tour không tồn tại!";
            header("Location: ?act=tour-list");
            exit();
        }

        require_once './views/tour/edit.php';
    }

    public function tourUpdate()
    {
        $id    = intval($_POST['id']);
        $name  = trim($_POST['name']);
        $desc  = trim($_POST['desc']);
        $price = floatval($_POST['price']);

        if ($id <= 0 || $name === "" || $desc === "" || $price < 0) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            header("Location: ?act=tour-edit&id=$id");
            exit();
        }

        if ($this->modelTour->updateTour($id, $name, $desc, $price)) {
            $_SESSION['success'] = "Cập nhật tour thành công!";
        } else {
            $_SESSION['error'] = "Cập nhật tour thất bại!";
        }

        header("Location: ?act=tour-list");
        exit();
    }

    public function tourDelete()
    {
        $id = intval($_GET['id']);

        if ($this->modelTour->deleteTour($id)) {
            $_SESSION['success'] = "Xóa tour thành công!";
        } else {
            $_SESSION['error'] = "Xóa tour thất bại!";
        }

        header("Location: ?act=tour-list");
        exit();
    }
}

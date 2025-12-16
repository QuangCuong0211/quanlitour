<?php
class TourController
{
    protected $tourModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->tourModel = new TourModel();
        $this->categoryModel = new CategoryModel();
    }

    public function tourList()
    {
        $tours = $this->tourModel->getAllTours();
        require 'views/tour/list.php';
    }

    public function tourAdd()
    {
        $categories = $this->categoryModel->getAllCategories();
        require 'views/tour/add.php';
    }

    public function tourSave()
    {
        $data = [
            'name'        => trim($_POST['name']),
            'price'       => $_POST['price'],
            'category_id' => $_POST['category_id'] ?? null,
            'status'      => $_POST['status']
        ];

        if ($data['name'] === '') {
            $_SESSION['error'] = 'Tên tour không được để trống';
            header('Location: ?act=tour-add');
            exit;
        }

        $this->tourModel->insert($data);
        $_SESSION['success'] = 'Thêm tour thành công';
        header('Location: ?act=tour-list');
        exit;
    }

    public function tourEdit()
    {
        $id = $_GET['id'];
        $tour = $this->tourModel->getOne($id);
        $categories = $this->categoryModel->getAllCategories();
        require 'views/tour/edit.php';
    }

    public function tourUpdate()
    {
        $id = $_POST['id'];

        $data = [
            'name'        => trim($_POST['name']),
            'price'       => $_POST['price'],
            'category_id' => $_POST['category_id'] ?? null,
            'status'      => $_POST['status']
        ];

        $this->tourModel->update($id, $data);
        $_SESSION['success'] = 'Cập nhật tour thành công';
        header('Location: ?act=tour-list');
        exit;
    }

    public function tourDelete()
    {
        $id = (int)$_GET['id'];

        if ($this->tourModel->hasBooking($id)) {
            $_SESSION['error'] = "Không thể xoá tour đã có booking!";
            header("Location: ?act=tour-list");
            exit;
        }

        $this->tourModel->delete($id);
        $_SESSION['success'] = "Đã xoá tour!";
        header("Location: ?act=tour-list");
    }
}

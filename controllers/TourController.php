<?php

class TourController
{
    protected $tourModel;
    protected $guideModel;

    public function __construct()
    {
        $this->tourModel = new TourModel();
        $this->guideModel = new GuideModel();
    }

    public function tourList()
    {
        $tours = $this->tourModel->getAllTours();
        require 'views/tour/list.php';
    }

    public function tourAdd()
    {
        $guides = $this->guideModel->getAll();
        require 'views/tour/add.php';
    }

    public function tourSave()
    {
        $data = [
            'tour_code' => $_POST['tour_code'],
            'name' => $_POST['name'],
            'departure_date' => $_POST['departure_date'],
            'price' => $_POST['price'],
            'status' => $_POST['status'],
            'guide_id' => $_POST['guide_id'],
            'note' => $_POST['note']
        ];

        $this->tourModel->insert($data);
        $_SESSION['success'] = 'Thêm tour thành công';
        header('Location: index.php?act=tour-list');
        exit;
    }

    public function tourEdit()
    {
        $id = $_GET['id'];
        $tour = $this->tourModel->getOne($id);
        $guides = $this->guideModel->getAll();
        require 'views/tour/edit.php';
    }

    public function tourUpdate()
    {
        $id = $_POST['id'];
        $data = [
            'tour_code' => $_POST['tour_code'],
            'name' => $_POST['name'],
            'departure_date' => $_POST['departure_date'],
            'price' => $_POST['price'],
            'status' => $_POST['status'],
            'guide_id' => $_POST['guide_id'],
            'note' => $_POST['note']
        ];

        $this->tourModel->update($id, $data);
        $_SESSION['success'] = 'Cập nhật tour thành công';
        header('Location: index.php?act=tour-list');
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

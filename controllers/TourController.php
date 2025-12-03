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
        $data = $_POST;

        // ================ VALIDATE =================
        $errors = [];

        if (empty($data['tour_id'])) $errors[] = "Mã tour không được để trống.";
        if (empty($data['name'])) $errors[] = "Tên tour không được để trống.";
        if (empty($data['description'])) $errors[] = "Mô tả không được để trống.";

        if (empty($data['departure_date'])) {
            $errors[] = "Ngày khởi hành không được để trống.";
        } elseif (!strtotime($data['departure_date'])) {
            $errors[] = "Ngày khởi hành không hợp lệ.";
        }

        if (empty($data['price']) || $data['price'] <= 0) {
            $errors[] = "Giá tour phải lớn hơn 0.";
        }

        if (empty($data['customer'])) $errors[] = "Tên khách hàng không được để trống.";
        if (empty($data['guide'])) $errors[] = "Tên hướng dẫn viên không được để trống.";
        if (empty($data['status'])) $errors[] = "Vui lòng chọn trạng thái.";

        // Nếu có lỗi → quay lại form
        if (!empty($errors)) {
            $_SESSION['error'] = implode("<br>", $errors);
            header("Location: ?act=tour-add");
            exit();
        }

        // ================ INSERT ================
        $ok = $this->modelTour->insertTour($data);

        if ($ok) {
            $_SESSION['success'] = "Thêm tour thành công!";
        } else {
            $_SESSION['error'] = "Không thể thêm tour. Vui lòng thử lại.";
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
        $id   = intval($_POST['id']);
        $data = $_POST;

        // ================ VALIDATE =================
        $errors = [];

        if ($id <= 0) $errors[] = "ID không hợp lệ.";
        if (empty($data['tour_id'])) $errors[] = "Mã tour không được để trống.";
        if (empty($data['name'])) $errors[] = "Tên tour không được để trống.";
        if (empty($data['description'])) $errors[] = "Mô tả không được để trống.";

        if (empty($data['departure_date'])) {
            $errors[] = "Ngày khởi hành không được để trống.";
        } elseif (!strtotime($data['departure_date'])) {
            $errors[] = "Ngày khởi hành không hợp lệ.";
        }

        if (empty($data['price']) || $data['price'] <= 0) {
            $errors[] = "Giá tour phải lớn hơn 0.";
        }

        if (empty($data['customer'])) $errors[] = "Tên khách hàng không được để trống.";
        if (empty($data['guide'])) $errors[] = "Tên hướng dẫn viên không được để trống.";
        if (empty($data['status'])) $errors[] = "Vui lòng chọn trạng thái.";

        if (!empty($errors)) {
            $_SESSION['error'] = implode("<br>", $errors);
            header("Location: ?act=tour-edit&id=$id");
            exit();
        }

        // ================ UPDATE ================
        $result = $this->modelTour->updateTour($id, $data);

        if ($result['status'] === 'updated') {
            $_SESSION['success'] = "Cập nhật tour thành công!";
        } elseif ($result['status'] === 'nochange') {
            $_SESSION['success'] = "Không có thay đổi nào!";
        } else {
            $_SESSION['error'] = "Cập nhật thất bại: " . $result['message'];
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

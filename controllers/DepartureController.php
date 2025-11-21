<?php
class DepartureController
{
    public $modelDeparture;

    public function __construct()
    {
        $this->modelDeparture = new DepartureModel();
    }

    // Hiển thị danh sách lịch khởi hành
    public function departureList()
    {
        $departures = $this->modelDeparture->getAllDepartures();
        require_once './views/departure/list.php';
    }

    // Hiển thị form thêm lịch khởi hành
    public function departureAdd()
    {
        $tours = $this->modelDeparture->getTours();
        $guides = $this->modelDeparture->getGuides();
        require_once './views/departure/add.php';
    }

    // Lưu lịch khởi hành mới
    public function departureSave()
    {
        if (empty($_POST['tour_id']) || empty($_POST['departure_date']) || empty($_POST['return_date']) || empty($_POST['guide_id']) || empty($_POST['seats_available'])) {
            $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin!";
            header("Location: ?act=departure-add");
            exit();
        }

        $tour_id = intval($_POST['tour_id']);
        $departure_date = $_POST['departure_date'];
        $return_date = $_POST['return_date'];
        $guide_id = intval($_POST['guide_id']);
        $seats_available = intval($_POST['seats_available']);
        $status = $_POST['status'] ?? 'active';

        if (strtotime($departure_date) >= strtotime($return_date)) {
            $_SESSION['error'] = "Ngày khởi hành phải trước ngày kết thúc!";
            header("Location: ?act=departure-add");
            exit();
        }

        if ($seats_available <= 0) {
            $_SESSION['error'] = "Số ghế phải lớn hơn 0!";
            header("Location: ?act=departure-add");
            exit();
        }

        if ($this->modelDeparture->insertDeparture($tour_id, $departure_date, $return_date, $guide_id, $seats_available, $status)) {
            $_SESSION['success'] = "Thêm lịch khởi hành thành công!";
        } else {
            $_SESSION['error'] = "Thêm lịch khởi hành thất bại!";
        }

        header("Location: ?act=departure-list");
        exit();
    }

    // Hiển thị form chỉnh sửa lịch khởi hành
    public function departureEdit()
    {
        $id = $_GET['id'] ?? 0;
        $departure = $this->modelDeparture->getDepartureById($id);

        if (!$departure) {
            $_SESSION['error'] = "Lịch khởi hành không tồn tại!";
            header("Location: ?act=departure-list");
            exit();
        }

        $tours = $this->modelDeparture->getTours();
        $guides = $this->modelDeparture->getGuides();
        require_once './views/departure/edit.php';
    }

    // Cập nhật lịch khởi hành
    public function departureUpdate()
    {
        $id = intval($_POST['id']);
        $tour_id = intval($_POST['tour_id']);
        $departure_date = $_POST['departure_date'];
        $return_date = $_POST['return_date'];
        $guide_id = intval($_POST['guide_id']);
        $seats_available = intval($_POST['seats_available']);
        $status = $_POST['status'] ?? 'active';

        if ($id <= 0 || $tour_id <= 0 || $guide_id <= 0 || $seats_available <= 0) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            header("Location: ?act=departure-edit&id=$id");
            exit();
        }

        if (strtotime($departure_date) >= strtotime($return_date)) {
            $_SESSION['error'] = "Ngày khởi hành phải trước ngày kết thúc!";
            header("Location: ?act=departure-edit&id=$id");
            exit();
        }

        if ($this->modelDeparture->updateDeparture($id, $tour_id, $departure_date, $return_date, $guide_id, $seats_available, $status)) {
            $_SESSION['success'] = "Cập nhật lịch khởi hành thành công!";
        } else {
            $_SESSION['error'] = "Cập nhật lịch khởi hành thất bại!";
        }

        header("Location: ?act=departure-list");
        exit();
    }

    // Xóa lịch khởi hành
    public function departureDelete()
    {
        $id = intval($_GET['id']);

        if ($this->modelDeparture->deleteDeparture($id)) {
            $_SESSION['success'] = "Xóa lịch khởi hành thành công!";
        } else {
            $_SESSION['error'] = "Xóa lịch khởi hành thất bại!";
        }

        header("Location: ?act=departure-list");
        exit();
    }
}

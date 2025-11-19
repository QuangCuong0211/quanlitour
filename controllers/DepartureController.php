<?php

class DepartureController {
    private $departureModel;
    private $productModel;
    private $userModel;

    public function __construct() {
        $this->departureModel = new DepartureModel();
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
    }

    // Danh sách lịch khởi hành
    public function departureList() {
        $departures = $this->departureModel->getAll();
        require_once './views/admin/departures/list.php';
    }

    // Form thêm lịch khởi hành
    public function departureAdd() {
        $tours = $this->productModel->getAllTours();
        $guides = $this->userModel->getHDVList();
        require_once './views/admin/departures/add.php';
    }

    // Lưu lịch khởi hành mới
    public function departureSave() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tour_id = $_POST['tour_id'] ?? null;
            $departure_date = $_POST['departure_date'] ?? '';
            $return_date = $_POST['return_date'] ?? '';
            $guide_id = $_POST['guide_id'] ?? null;
            $seats_available = $_POST['seats_available'] ?? 0;
            $status = $_POST['status'] ?? 'active';

            $errors = [];

            if (!$tour_id) {
                $errors[] = 'Vui lòng chọn tour';
            }

            if (empty($departure_date)) {
                $errors[] = 'Ngày khởi hành không được để trống';
            }

            if (empty($return_date)) {
                $errors[] = 'Ngày kết thúc không được để trống';
            }

            if ($departure_date && $return_date && $departure_date > $return_date) {
                $errors[] = 'Ngày kết thúc phải sau ngày khởi hành';
            }

            if (!$guide_id) {
                $errors[] = 'Vui lòng chọn hướng dẫn viên';
            }

            if (!$seats_available || $seats_available < 1) {
                $errors[] = 'Số ghế phải lớn hơn 0';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: ?act=departure-add');
                exit;
            }

            $data = [
                'tour_id' => $tour_id,
                'departure_date' => $departure_date,
                'return_date' => $return_date,
                'guide_id' => $guide_id,
                'seats_available' => $seats_available,
                'status' => $status
            ];

            if ($this->departureModel->create($data)) {
                $_SESSION['success'] = 'Thêm lịch khởi hành thành công';
                header('Location: ?act=departure-list');
            } else {
                $_SESSION['errors'] = ['Có lỗi xảy ra, vui lòng thử lại'];
                header('Location: ?act=departure-add');
            }
            exit;
        }
    }

    // Form chỉnh sửa lịch khởi hành
    public function departureEdit() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ?act=departure-list');
            exit;
        }

        $departure = $this->departureModel->getById($id);

        if (!$departure) {
            $_SESSION['errors'] = ['Lịch khởi hành không tồn tại'];
            header('Location: ?act=departure-list');
            exit;
        }

        $tours = $this->productModel->getAllTours();
        $guides = $this->userModel->getHDVList();

        require_once './views/admin/departures/edit.php';
    }

    // Cập nhật lịch khởi hành
    public function departureUpdate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $tour_id = $_POST['tour_id'] ?? null;
            $departure_date = $_POST['departure_date'] ?? '';
            $return_date = $_POST['return_date'] ?? '';
            $guide_id = $_POST['guide_id'] ?? null;
            $seats_available = $_POST['seats_available'] ?? 0;
            $status = $_POST['status'] ?? 'active';

            $errors = [];

            if (!$id) {
                $errors[] = 'ID không hợp lệ';
            }

            if (!$tour_id) {
                $errors[] = 'Vui lòng chọn tour';
            }

            if (empty($departure_date)) {
                $errors[] = 'Ngày khởi hành không được để trống';
            }

            if (empty($return_date)) {
                $errors[] = 'Ngày kết thúc không được để trống';
            }

            if ($departure_date && $return_date && $departure_date > $return_date) {
                $errors[] = 'Ngày kết thúc phải sau ngày khởi hành';
            }

            if (!$guide_id) {
                $errors[] = 'Vui lòng chọn hướng dẫn viên';
            }

            if (!$seats_available || $seats_available < 1) {
                $errors[] = 'Số ghế phải lớn hơn 0';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: ?act=departure-edit&id=$id");
                exit;
            }

            $data = [
                'tour_id' => $tour_id,
                'departure_date' => $departure_date,
                'return_date' => $return_date,
                'guide_id' => $guide_id,
                'seats_available' => $seats_available,
                'status' => $status
            ];

            if ($this->departureModel->update($id, $data)) {
                $_SESSION['success'] = 'Cập nhật lịch khởi hành thành công';
                header('Location: ?act=departure-list');
            } else {
                $_SESSION['errors'] = ['Có lỗi xảy ra, vui lòng thử lại'];
                header("Location: ?act=departure-edit&id=$id");
            }
            exit;
        }
    }

    // Xóa lịch khởi hành
    public function departureDelete() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['errors'] = ['ID không hợp lệ'];
            header('Location: ?act=departure-list');
            exit;
        }

        if ($this->departureModel->delete($id)) {
            $_SESSION['success'] = 'Xóa lịch khởi hành thành công';
        } else {
            $_SESSION['errors'] = ['Có lỗi xảy ra, vui lòng thử lại'];
        }

        header('Location: ?act=departure-list');
        exit;
    }
}

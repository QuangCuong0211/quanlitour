<?php
class ProductController
{
    public $modelProduct;

    public function __construct()
    {
        // Giả sử ProductModel tự kết nối DB bên trong
        $this->modelProduct = new ProductModel();
    }

    // Trang chủ
    public function Home()
    {
        $title = "Đây là trang chủ nhé hahaa";
        $thoiTiet = "Hôm nay trời có vẻ là mưa";

        require_once './views/trangchu.php';
    }

    // Trang admin
    public function Admin()
    {
        require_once './views/admin.php';
    }

    // Danh sách tour
    public function tourList()
    {
        $tours = $this->modelProduct->getAllTours();
        require_once './views/tour/list.php';
    }

    // Form thêm tour
    public function tourAdd()
    {
        require_once './views/tour/add.php';
    }

    // Lưu tour mới
    public function tourSave()
    {
        if (empty($_POST['name']) || empty($_POST['desc']) || empty($_POST['price'])) {
            header("Location: ?act=tour-add&error=" . urlencode("Thiếu dữ liệu!"));
            exit();
        }

        $name  = trim($_POST['name']);
        $desc  = trim($_POST['desc']);
        $price = floatval($_POST['price']);

        if ($price < 0) {
            header("Location: ?act=tour-add&error=" . urlencode("Giá tour không hợp lệ!"));
            exit();
        }

        $ok = $this->modelProduct->insertTour($name, $desc, $price);

        if ($ok) {
            header("Location: ?act=tour-list&msg=" . urlencode("Thêm tour thành công!"));
        } else {
            header("Location: ?act=tour-add&error=" . urlencode("Thêm tour thất bại!"));
        }
        exit();
    }

    // Form sửa tour
    public function tourEdit()
    {
        if (!isset($_GET['id'])) {
            header("Location: ?act=tour-list&error=" . urlencode("Thiếu ID tour!"));
            exit;
        }

        $id = intval($_GET['id']);
        if ($id <= 0) {
            header("Location: ?act=tour-list&error=" . urlencode("ID tour không hợp lệ!"));
            exit;
        }

        $tour = $this->modelProduct->getTourById($id);

        if (!$tour) {
            header("Location: ?act=tour-list&error=" . urlencode("Tour không tồn tại!"));
            exit;
        }

        require_once './views/tour/edit.php';
    }

    // Cập nhật tour
    public function tourUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?act=tour-list");
            exit;
        }

        $id    = intval($_POST['id'] ?? 0);
        $name  = trim($_POST['name'] ?? '');
        $desc  = trim($_POST['desc'] ?? '');
        $price = floatval($_POST['price'] ?? 0);

        if ($id <= 0) {
            header("Location: ?act=tour-list&error=" . urlencode('ID không hợp lệ!'));
            exit;
        }

        if ($name === '' || $desc === '' || $price < 0) {
            header("Location: ?act=tour-edit&id={$id}&error=" . urlencode('Dữ liệu không hợp lệ!'));
            exit;
        }

        // Model trả về mảng chi tiết
        $res = $this->modelProduct->updateTour($id, $name, $desc, $price);

        // Nếu lỡ model trả về boolean như cũ, vẫn xử lý được
        if (!is_array($res)) {
            if ($res) {
                header("Location: ?act=tour-edit&id={$id}&msg=" . urlencode('Cập nhật tour thành công!'));
            } else {
                header("Location: ?act=tour-edit&id={$id}&error=" . urlencode('Cập nhật tour thất bại!'));
            }
            exit;
        }

        // Dùng status chi tiết
        switch ($res['status'] ?? '') {
            case 'updated':
                header("Location: ?act=tour-edit&id={$id}&msg=" . urlencode('Cập nhật tour thành công!'));
                break;

            case 'nochange':
                header("Location: ?act=tour-edit&id={$id}&msg=" . urlencode('Không có gì thay đổi (dữ liệu giống trước).'));
                break;

            case 'error':
            default:
                $errMsg = isset($res['message']) ? $res['message'] : 'Cập nhật tour thất bại!';
                header("Location: ?act=tour-edit&id={$id}&error=" . urlencode($errMsg));
                break;
        }

        exit;
    }

    // Xóa tour
    public function tourDelete()
    {
        if (!isset($_GET['id'])) {
            header("Location: ?act=tour-list&error=" . urlencode("Thiếu ID tour!"));
            exit;
        }

        $id = intval($_GET['id']);
        if ($id <= 0) {
            header("Location: ?act=tour-list&error=" . urlencode("ID tour không hợp lệ!"));
            exit;
        }

        $ok = $this->modelProduct->deleteTour($id);

        if ($ok) {
            header("Location: ?act=tour-list&msg=" . urlencode("Xóa tour thành công!"));
        } else {
            header("Location: ?act=tour-list&error=" . urlencode("Xóa tour thất bại!"));
        }
        exit();
    }
}

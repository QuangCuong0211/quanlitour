<?php
class CategoryController
{
    public $modelCategory;

    public function __construct()
    {
        $this->modelCategory = new CategoryModel();
    }

    /* =========================
       DANH SÁCH DANH MỤC
    ========================= */
    public function categoryList()
    {
        $categories = $this->modelCategory->getAllCategories();
        require_once './views/category/list.php';
    }

    /* =========================
       FORM THÊM DANH MỤC
    ========================= */
    public function categoryAdd()
    {
        require_once './views/category/add.php';
    }

    /* =========================
       LƯU DANH MỤC
    ========================= */
    public function categorySave()
    {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $status = intval($_POST['status'] ?? 1);

        // VALIDATE
        if ($name === '' || $slug === '') {
            $_SESSION['error'] = "Tên danh mục và slug không được để trống!";
            header("Location: ?act=category-add");
            exit;
        }

        if (!preg_match('/^[a-z0-9-]+$/', $slug)) {
            $_SESSION['error'] = "Slug chỉ được chứa chữ thường, số và dấu -";
            header("Location: ?act=category-add");
            exit;
        }

        $ok = $this->modelCategory->insertCategory($name, $description, $slug, $status);

        if ($ok) {
            $_SESSION['success'] = "Thêm danh mục thành công!";
        } else {
            $_SESSION['error'] = "Thêm danh mục thất bại!";
        }

        header("Location: ?act=category-list");
        exit;
    }

    /* =========================
       FORM SỬA DANH MỤC
    ========================= */
    public function categoryEdit()
    {
        $id = (int)($_GET['id'] ?? 0);
        $category = $this->modelCategory->getCategoryById($id);

        if (!$category) {
            $_SESSION['error'] = "Danh mục không tồn tại!";
            header("Location: ?act=category-list");
            exit;
        }

        require_once './views/category/edit.php';
    }

    /* =========================
       CẬP NHẬT DANH MỤC
    ========================= */
    public function categoryUpdate()
    {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $status = intval($_POST['status'] ?? 1);

        // VALIDATE
        if ($id <= 0 || $name === '' || $slug === '') {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            header("Location: ?act=category-edit&id=" . $id);
            exit;
        }

        if (!preg_match('/^[a-z0-9-]+$/', $slug)) {
            $_SESSION['error'] = "Slug không hợp lệ!";
            header("Location: ?act=category-edit&id=" . $id);
            exit;
        }

        $result = $this->modelCategory->updateCategory($id, $name, $description, $slug, $status);

        if (is_array($result) && $result['status'] === 'updated') {
            $_SESSION['success'] = "Cập nhật danh mục thành công!";
        } else {
            $_SESSION['success'] = "Không có thay đổi nào!";
        }

        header("Location: ?act=category-list");
        exit;
    }

    /* =========================
       XOÁ DANH MỤC
    ========================= */
    public function categoryDelete()
    {
        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] = "ID không hợp lệ!";
            header("Location: ?act=category-list");
            exit;
        }

        // KHÔNG CHO XOÁ NẾU CÓ TOUR
        if (method_exists($this->modelCategory, 'hasTour') && $this->modelCategory->hasTour($id)) {
            $_SESSION['error'] = "Không thể xoá danh mục đang có tour!";
            header("Location: ?act=category-list");
            exit;
        }

        $this->modelCategory->deleteCategory($id);
        $_SESSION['success'] = "Đã xoá danh mục!";
        header("Location: ?act=category-list");
        exit;
    }
}

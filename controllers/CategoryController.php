<?php
class CategoryController
{
    public $modelCategory;

    public function __construct()
    {
        $this->modelCategory = new CategoryModel();
    }

    // Hiển thị danh sách danh mục
    public function categoryList()
    {
        $categories = $this->modelCategory->getAllCategories();
        require_once './views/category/list.php';
    }

    // Hiển thị form thêm danh mục
    public function categoryAdd()
    {
        require_once './views/category/add.php';
    }

    // Lưu danh mục mới
    public function categorySave()
    {
        if (empty($_POST['name']) || empty($_POST['slug'])) {
            $_SESSION['error'] = "Tên danh mục và slug không được để trống!";
            header("Location: ?act=category-add");
            exit();
        }

        $name = trim($_POST['name']);
        $description = trim($_POST['description'] ?? '');
        $slug = trim($_POST['slug']);
        $status = intval($_POST['status'] ?? 1);

        if ($this->modelCategory->insertCategory($name, $description, $slug, $status)) {
            $_SESSION['success'] = "Thêm danh mục thành công!";
        } else {
            $_SESSION['error'] = "Thêm danh mục thất bại!";
        }

        header("Location: ?act=category-list");
        exit();
    }

    // Hiển thị form chỉnh sửa danh mục
    public function categoryEdit()
    {
        $id = $_GET['id'] ?? 0;
        $category = $this->modelCategory->getCategoryById($id);

        if (!$category) {
            $_SESSION['error'] = "Danh mục không tồn tại!";
            header("Location: ?act=category-list");
            exit();
        }

        require_once './views/category/edit.php';
    }

    // Cập nhật danh mục
    public function categoryUpdate()
    {
        $id = intval($_POST['id']);
        $name = trim($_POST['name']);
        $description = trim($_POST['description'] ?? '');
        $slug = trim($_POST['slug']);
        $status = intval($_POST['status'] ?? 1);

        if ($id <= 0 || empty($name) || empty($slug)) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            header("Location: ?act=category-edit&id=$id");
            exit();
        }

        $result = $this->modelCategory->updateCategory($id, $name, $description, $slug, $status);

        if ($result === true || (is_array($result) && $result['status'] === 'updated')) {
            $_SESSION['success'] = "Cập nhật danh mục thành công!";
        } else {
            $_SESSION['error'] = "Cập nhật danh mục thất bại!";
        }

        header("Location: ?act=category-list");
        exit();
    }

    // Xóa danh mục
    public function categoryDelete()
    {
        $id = intval($_GET['id']);

        if ($this->modelCategory->deleteCategory($id)) {
            $_SESSION['success'] = "Xóa danh mục thành công!";
        } else {
            $_SESSION['error'] = "Xóa danh mục thất bại!";
        }

        header("Location: ?act=category-list");
        exit();
    }
}

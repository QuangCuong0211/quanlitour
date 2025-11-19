<?php

class UsersController {

    private $model;

    public function __construct($db) {
        $this->model = new UserModel($db);
    }

    // Danh sách user
    public function index() {
        $users = $this->model->getAll();
        include "views/users/list.php";
    }

    // Form thêm
    public function add() {
        include "views/users/add.php";
    }

    // Lưu thêm user
    public function store() {
        $data = [
            "name"  => $_POST['name'],
            "email" => $_POST['email'],
            "phone" => $_POST['phone'],
            "role"  => $_POST['role']
        ];

        $this->model->add($data);

        header("Location: index.php?controller=users&action=index");
    }

    // Form sửa
    public function edit() {
        $id = $_GET['id'];
        $user = $this->model->getById($id);
        include "views/users/edit.php";
    }

    // Lưu sửa
    public function update() {
        $id = $_GET['id'];

        $data = [
            "name"  => $_POST['name'],
            "email" => $_POST['email'],
            "phone" => $_POST['phone'],
            "role"  => $_POST['role'],
        ];

        $this->model->update($id, $data);

        header("Location: index.php?controller=users&action=index");
    }

    // Bật/Tắt user
    public function toggle() {
        $id = $_GET['id'];
        $this->model->toggle($id);
        header("Location: index.php?controller=users&action=index");
    }
}

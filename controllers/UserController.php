<?php
require_once "models/UserModel.php";

class UserController {

    // Danh sách tài khoản
    public function list() {
        $users = UserModel::all();
        require_once "views/user/list.php";
    }

    // Form thêm
    public function add() {
        require_once "views/user/add.php";
    }

    // Xử lý thêm
    public function store() {
        UserModel::create($_POST['fullname'], $_POST['email'], $_POST['password'], $_POST['role']);
        header("Location: ?act=user-list");
    }

    // Form sửa
    public function edit() {
        $user = UserModel::find($_GET['id']);
        require_once "views/user/edit.php";
    }

    // Xử lý sửa
    public function update() {
        UserModel::updateUser(
            $_POST['id'],
            $_POST['fullname'],
            $_POST['email'],
            $_POST['role'],
            $_POST['status']
        );
        header("Location: ?act=user-list");
    }

    // Xóa
    public function delete() {
        UserModel::deleteUser($_GET['id']);
        header("Location: ?act=user-list");
    }
}

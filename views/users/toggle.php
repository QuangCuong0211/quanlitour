<?php
include "../database.php";

$id = $_GET['id'];

$user = $conn->query("SELECT status FROM users WHERE id=$id")->fetch_assoc();

$newStatus = ($user['status'] == 'hoatdong') ? 'khoa' : 'hoatdong';

$conn->query("UPDATE users SET status='$newStatus' WHERE id=$id");

header("Location: list.php");

<?php

class ReviewModel {
        public $conn;

    public function __construct()
    {
        require_once __DIR__ . '/../commons/env.php';

        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

        if ($this->conn->connect_error) {
            die('Kết nối DB thất bại: ' . $this->conn->connect_error);
        }
    }

    // Lấy tất cả review
    public function getAllReviews() {
        $sql = "SELECT reviews.*, tours.name AS tour_name FROM reviews 
                JOIN tours ON reviews.tour_id = tours.id ORDER BY id DESC";
        return pdo_query($sql);
    }

    // Lấy review theo id
    public function getReviewById($id) {
        return pdo_query_one("SELECT * FROM reviews WHERE id = ?", $id);
    }

    // Thêm review
    public function addReview($tour_id, $customer_name, $rating, $content) {
        $sql = "INSERT INTO reviews (tour_id, customer_name, rating, content) 
                VALUES (?,?,?,?)";
        pdo_execute($sql, $tour_id, $customer_name, $rating, $content);
    }

    // Cập nhật review
    public function updateReview($id, $tour_id, $customer_name, $rating, $content) {
        $sql = "UPDATE reviews SET tour_id=?, customer_name=?, rating=?, content=? WHERE id=?";
        pdo_execute($sql, $tour_id, $customer_name, $rating, $content, $id);
    }

    // Xoá
    public function deleteReview($id) {
        pdo_execute("DELETE FROM reviews WHERE id = ?", $id);
    }
}

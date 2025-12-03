<?php
require_once __DIR__ . "/../models/ReviewModel.php";
require_once __DIR__ . "/../models/TourModel.php";


class ReviewController {
    public $reviewModel;
    public $tourModel;

    public function __construct() {
        $this->reviewModel = new ReviewModel();
        $this->tourModel = new TourModel();
    }

    public function index() {
        $reviews = $this->reviewModel->getAllReviews();
        include "views/review/list.php";
    }

    public function add() {
        $tours = $this->tourModel->getAllTours(); // để chọn tour
        include "views/review/add.php";
    }

    public function store() {
        $this->reviewModel->addReview($_POST['tour_id'], $_POST['name'], $_POST['rating'], $_POST['content']);
        header("Location: index.php?act=review-list");
    }

    public function edit() {
        $review = $this->reviewModel->getReviewById($_GET['id']);
        $tours = $this->tourModel->getAllTours();
        include "views/review/edit.php";
    }

    public function update() {
        $this->reviewModel->updateReview($_POST['id'], $_POST['tour_id'], $_POST['name'], $_POST['rating'], $_POST['content']);
        header("Location: index.php?act=review-list");
    }

    public function delete() {
        $this->reviewModel->deleteReview($_GET['id']);
        header("Location: index.php?act=review-list");
    }
}

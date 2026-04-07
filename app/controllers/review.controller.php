<?php

namespace app\Controllers;

include_once(dirname(dirname(__DIR__)) . "/Core/Controller.php");
include_once(dirname(__DIR__) . "/models/review.model.php");

use Core\Controller;
use app\Models\ReviewModel;

class ReviewController extends Controller {
  protected $reviewModel;

  public function __construct(){
    $this->reviewModel = new ReviewModel();
  }

  public function addReview($userId, $pId, $reviewText){
    return $this->reviewModel->addReview($userId, $pId, $reviewText);
  }

  public function getReviewsByProductId($pId){
    return $this->reviewModel->getReviewsByProductId($pId);
  }

  public function getReviewCount($pId){
    return $this->reviewModel->getReviewCount($pId);
  }

  public function getReviewCountsForProducts($pIds){
    return $this->reviewModel->getReviewCountsForProducts($pIds);
  }

  public function deleteReview($reviewId){
    return $this->reviewModel->deleteReview($reviewId);
  }

  public function getUserIdByEmail($email){
    return $this->reviewModel->getUserIdByEmail($email);
  }
}

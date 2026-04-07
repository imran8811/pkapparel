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

  public function addReview($userId, $pId, $reviewText, $rating){
    return $this->reviewModel->addReview($userId, $pId, $reviewText, $rating);
  }

  public function hasUserReviewed($userId, $pId){
    return $this->reviewModel->hasUserReviewed($userId, $pId);
  }

  public function updateReview($reviewId, $userId, $reviewText, $rating){
    return $this->reviewModel->updateReview($reviewId, $userId, $reviewText, $rating);
  }

  public function deleteReviewByUser($reviewId, $userId){
    return $this->reviewModel->deleteReviewByUser($reviewId, $userId);
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

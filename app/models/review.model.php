<?php

namespace app\Models;
include_once(dirname(dirname(__DIR__)). "/Core/Model.php");
use Core\Model;
use PDO;

class ReviewModel extends Model {
  public function __construct(){
    parent::__construct();
  }

  public function addReview($userId, $pId, $reviewText, $rating){
    $rating = max(1, min(5, intval($rating)));
    $query = 'INSERT INTO reviews (user_id, p_id, review_text, rating) VALUES (?, ?, ?, ?)';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$userId, $pId, $reviewText, $rating]);
    return $stmt->rowCount() > 0;
  }

  public function updateReview($reviewId, $userId, $reviewText, $rating){
    $rating = max(1, min(5, intval($rating)));
    $query = 'UPDATE reviews SET review_text = ?, rating = ? WHERE review_id = ? AND user_id = ?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$reviewText, $rating, $reviewId, $userId]);
    return $stmt->rowCount() >= 0;
  }

  public function deleteReviewByUser($reviewId, $userId){
    $query = 'DELETE FROM reviews WHERE review_id = ? AND user_id = ?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$reviewId, $userId]);
    return $stmt->rowCount() > 0;
  }

  public function getReviewsByProductId($pId){
    $query = 'SELECT r.*, u.business_name FROM reviews r
              JOIN users u ON r.user_id = u.user_id
              WHERE r.p_id = ?
              ORDER BY r.created_at DESC';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$pId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getReviewCount($pId){
    $query = 'SELECT COUNT(*) as count FROM reviews WHERE p_id = ?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$pId]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res['count'];
  }

  public function getReviewCountsForProducts($pIds){
    if(empty($pIds)) return [];
    $placeholders = implode(',', array_fill(0, count($pIds), '?'));
    $query = "SELECT p_id, COUNT(*) as count, ROUND(AVG(rating), 1) as avg_rating FROM reviews WHERE p_id IN ($placeholders) GROUP BY p_id";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute($pIds);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $map = [];
    foreach($rows as $row){
      $map[$row['p_id']] = ['count' => $row['count'], 'avg_rating' => $row['avg_rating']];
    }
    return $map;
  }

  public function deleteReview($reviewId){
    $query = 'DELETE FROM reviews WHERE review_id = ?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$reviewId]);
    return $stmt->rowCount() > 0;
  }

  public function getUserIdByEmail($email){
    $query = 'SELECT user_id FROM users WHERE user_email = ?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$email]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res ? $res['user_id'] : false;
  }
}

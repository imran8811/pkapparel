<?php
namespace app\Models;
include_once(dirname(dirname(__DIR__)). "/Core/Model.php");
use Core\Model;
use PDO;
use PDOException;

class CartModel extends Model {
  public function __construct(){
    parent::__construct();
  }

  public function addItem($userId, $pId, $sizes, $quantity, $amount){
    try {
      $query = 'INSERT INTO cart (p_id, user_id, cart_sizes, quantity, cart_amount, instructions)
                VALUES (:p_id, :user_id, :cart_sizes, :quantity, :cart_amount, "")
                ON DUPLICATE KEY UPDATE quantity = CAST(quantity AS UNSIGNED) + :qty_add, cart_amount = :amount_upd';
      $stmt = $this->pdo->prepare($query);
      $stmt->execute([
        ':p_id'       => $pId,
        ':user_id'    => $userId,
        ':cart_sizes'  => $sizes,
        ':quantity'    => $quantity,
        ':cart_amount' => $amount,
        ':qty_add'     => $quantity,
        ':amount_upd'  => $amount,
      ]);
      return true;
    } catch(PDOException $e){
      return false;
    }
  }

  public function getCartItems($userId){
    $query = 'SELECT c.*, p.product_name, p.article_no, p.price, p.dept, p.category, p.slug, p.p_sizes
              FROM cart c
              JOIN product p ON c.p_id = p.p_id
              WHERE c.user_id = ?
              ORDER BY c.created_at DESC';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateQuantity($cartId, $userId, $quantity){
    try {
      $query = 'UPDATE cart SET quantity = ? WHERE cart_id = ? AND user_id = ?';
      $stmt = $this->pdo->prepare($query);
      $stmt->execute([$quantity, $cartId, $userId]);
      return true;
    } catch(PDOException $e){
      return false;
    }
  }

  public function removeItem($cartId, $userId){
    try {
      $query = 'DELETE FROM cart WHERE cart_id = ? AND user_id = ?';
      $stmt = $this->pdo->prepare($query);
      $stmt->execute([$cartId, $userId]);
      return $stmt->rowCount() > 0;
    } catch(PDOException $e){
      return false;
    }
  }

  public function clearCart($userId){
    try {
      $query = 'DELETE FROM cart WHERE user_id = ?';
      $stmt = $this->pdo->prepare($query);
      $stmt->execute([$userId]);
      return true;
    } catch(PDOException $e){
      return false;
    }
  }

  public function getCartCount($userId){
    $query = 'SELECT COALESCE(SUM(CAST(quantity AS UNSIGNED)), 0) as total_sets FROM cart WHERE user_id = ?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? (int)$row['total_sets'] : 0;
  }

  public function getProductIdByArticle($articleNo){
    $query = 'SELECT p_id FROM product WHERE article_no = ?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$articleNo]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['p_id'] : null;
  }

  public function getUserIdByEmail($email){
    $query = 'SELECT user_id FROM users WHERE user_email = ?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? (int)$row['user_id'] : null;
  }
}

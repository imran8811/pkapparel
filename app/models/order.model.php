<?php
namespace app\Models;
include_once(dirname(dirname(__DIR__)). "/Core/Model.php");
use Core\Model;
use PDO;
use PDOException;

class OrderModel extends Model {
  public function __construct(){
    parent::__construct();
  }

  public function createOrder($data, $items){
    try {
      $this->pdo->beginTransaction();

      $query = 'INSERT INTO orders (order_no, user_id, total_amount, total_quantity, order_status, add_id, cart_items, shipping_name, shipping_email, shipping_phone, shipping_address, shipping_city, shipping_state, shipping_country, shipping_notes)
                VALUES (:order_no, :user_id, :total_amount, :total_quantity, :order_status, 0, \'\', :shipping_name, :shipping_email, :shipping_phone, :shipping_address, :shipping_city, :shipping_state, :shipping_country, :shipping_notes)';
      $stmt = $this->pdo->prepare($query);
      $stmt->execute([
        ':order_no'        => $data['order_number'],
        ':user_id'         => $data['user_id'],
        ':total_amount'    => $data['total'],
        ':total_quantity'  => $data['total_pieces'],
        ':order_status'    => $data['status'] ?? 'pending',
        ':shipping_name'   => $data['shipping_name'],
        ':shipping_email'  => $data['shipping_email'],
        ':shipping_phone'  => $data['shipping_phone'],
        ':shipping_address'=> $data['shipping_address'],
        ':shipping_city'   => $data['shipping_city'],
        ':shipping_state'  => $data['shipping_state'],
        ':shipping_country'=> $data['shipping_country'],
        ':shipping_notes'  => $data['shipping_notes'],
      ]);

      $orderId = $this->pdo->lastInsertId();

      $itemQuery = 'INSERT INTO order_items (order_id, article, product_name, price, dept, category, slug, sizes, sets, pieces)
                    VALUES (:order_id, :article, :product_name, :price, :dept, :category, :slug, :sizes, :sets, :pieces)';
      $itemStmt = $this->pdo->prepare($itemQuery);

      foreach($items as $item){
        $sets = (int)($item['sets'] ?? 1);
        $piecesPerSet = 10;
        $itemStmt->execute([
          ':order_id'     => $orderId,
          ':article'      => $item['article'],
          ':product_name' => $item['name'],
          ':price'        => $item['price'],
          ':dept'         => $item['dept'] ?? '',
          ':category'     => $item['category'] ?? '',
          ':slug'         => $item['slug'] ?? '',
          ':sizes'        => $item['sizes'] ?? '30,32,34,36,38',
          ':sets'         => $sets,
          ':pieces'       => $sets * $piecesPerSet,
        ]);
      }

      $this->pdo->commit();
      return $orderId;
    } catch(PDOException $e){
      $this->pdo->rollBack();
      return false;
    }
  }

  public function getOrdersByUserId($userId){
    $query = 'SELECT *, order_no AS order_number, total_amount AS total, total_quantity AS total_pieces, order_status AS status FROM orders WHERE user_id=? ORDER BY created_at DESC';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getOrderByNumber($orderNumber){
    $query = 'SELECT *, order_no AS order_number, total_amount AS total, total_quantity AS total_pieces, order_status AS status FROM orders WHERE order_no=?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$orderNumber]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getOrderById($orderId){
    $query = 'SELECT *, order_no AS order_number, total_amount AS total, total_quantity AS total_pieces, order_status AS status FROM orders WHERE order_id=?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$orderId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getOrderItems($orderId){
    $query = 'SELECT * FROM order_items WHERE order_id=?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$orderId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getAllOrders(){
    $query = 'SELECT *, order_no AS order_number, total_amount AS total, total_quantity AS total_pieces, order_status AS status FROM orders ORDER BY created_at DESC';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateOrderStatus($orderId, $status){
    try {
      $query = 'UPDATE orders SET order_status=? WHERE order_id=?';
      $stmt = $this->pdo->prepare($query);
      $stmt->execute([$status, $orderId]);
      return $stmt->rowCount() >= 0;
    } catch(PDOException $e){
      return false;
    }
  }

  public function deleteOrder($orderId){
    try {
      $query = 'DELETE FROM orders WHERE order_id=?';
      $stmt = $this->pdo->prepare($query);
      $stmt->execute([$orderId]);
      return $stmt->rowCount() > 0;
    } catch(PDOException $e){
      return false;
    }
  }

  public function getUserIdByEmail($email){
    $query = 'SELECT user_id FROM users WHERE user_email=?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['user_id'] : null;
  }
}

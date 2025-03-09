<?php
namespace app\Models;
include_once(dirname(dirname(__DIR__)). "/Core/Model.php");
use Core\Model;
use PDO;
use PDOException;

class AdminModel extends Model {
  public function __construct(){
    parent::__construct();
  }

  public function login($email, $password){
    try{
      $query = "SELECT * FROM admin_users WHERE email=?";
      $stmt= $this->pdo->prepare($query);
      $stmt->execute([$email]);
      $res = $stmt->fetch();
      if($res){
        $passwordVerify = password_verify($password, $res['password']);
        if($passwordVerify){
          $token = $this->generateSaveSessionToken($res['email']);
          if($token){
            $data = [
              'email'    => $res['email'],
              'token'    => $token,
            ];
            return $data;
          } else {
            return false;
          }
        } else {
          return false;
        }
      } else {
       return false;
      }
    } catch(PDOException $e){
      return $e->getMessage();
    }
  }

  private function generateSaveSessionToken($userEmail){
    $token = bin2hex(random_bytes(16));
    $query = 'INSERT INTO sessions (token, user_email)
              values(:user_token, :user_email)
              ON DUPLICATE KEY UPDATE token=VALUES(token),user_email=VALUES(user_email)';
    $stmt= $this->pdo->prepare($query);
    $stmt->bindParam(':user_token', $token, PDO::PARAM_STR);
    $stmt->bindParam(':user_email', $userEmail, PDO::PARAM_STR);
    $res = $stmt->execute();
    return $res? $token : false;
  }

  public function getAllProducts() {
    $query = 'SELECT * FROM product LEFT JOIN images ON product.p_id=images.p_id ORDER BY product.p_id DESC';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
    $res = $stmt->fetchAll();
    return $res;
  }

  public function getProductByArticleNo($article_no){
    $query = 'SELECT * FROM product INNER JOIN images ON product.p_id=images.p_id WHERE product.article_no=?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$article_no]);
    $res = $stmt->fetchAll();
    return $res;
  }

  public function getProductsByDept($dept){
    $query = 'SELECT * FROM product INNER JOIN images ON product.p_id=images.p_id WHERE product.dept=? ORDER BY product.p_id DESC';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$dept]);
    $res = $stmt->fetchAll();
    return $res;
  }

  public function getProductsByCategory($category){
    $query = 'SELECT * FROM product INNER JOIN images ON product.p_id=images.p_id WHERE product.category=? ORDER BY product.p_id DESC';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$category]);
    $res = $stmt->fetchAll();
    return $res;
  }

  public function getProductsByDeptCategory($dept, $category){
    $query = 'SELECT * FROM product INNER JOIN images ON product.p_id=images.p_id WHERE product.dept=? AND product.category=? ORDER BY product.p_id DESC';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$dept, $category]);
    $res = $stmt->fetchAll();
    return $res;
  }

  public function productCountByDeptCategory($dept) {
    $query = 'SELECT category, COUNT(*) as count FROM product WHERE product.dept=? GROUP BY category ORDER BY count DESC';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$dept]);
    $res = $stmt->fetchAll();
    return $res;
  }

  public function deleteProductById($id) {
    $query = 'DELETE FROM product WHERE p_id=?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$id]);
    $res = $stmt->rowCount();
    if($res){
      $deleteImage = $this->deleteImagesById($id);
      if($deleteImage){
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
    return $res;
  }

  public function deleteImagesById($id) {
    $query = 'DELETE FROM images WHERE p_id=?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$id]);
    $res = $stmt->rowCount();
    return $res;
  }

  public function getLatestArticleNo() {
    $query = 'SELECT MAX(article_no) from product';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
    $res = $stmt->fetch();
    return $res['MAX(article_no)']? $res['MAX(article_no)'] : '10050';
  }

  public function updateProduct($data, $id) {
    try{
      $query = "UPDATE products SET
            price=:price,
            dept=:dept,
            category=:category,
            slug=:slug,
            p_sizes=:p_sizes,
            fitting=:fitting,
            fabric=:fabric,
            fabric_weight=:fabric_weight,
            wash_type=:wash_type,
            moq=:moq,
            piece_weight=:piece_weight,
            color=:color
            WHERE p_id =:id";
      $stmt= $this->pdo->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->bindParam(':price', $data['price'], PDO::PARAM_INT);
      $stmt->bindParam(':dept', $data['dept'], PDO::PARAM_STR);
      $stmt->bindParam(':category', $data['category'], PDO::PARAM_STR);
      $stmt->bindParam(':slug', $data['slug'], PDO::PARAM_STR);
      $stmt->bindParam(':p_sizes', $data['p_sizes'], PDO::PARAM_STR);
      $stmt->bindParam(':fitting', $data['fitting'], PDO::PARAM_STR);
      $stmt->bindParam(':fabric', $data['fabric'], PDO::PARAM_STR);
      $stmt->bindParam(':fabric_weight', $data['fabric_weight'], PDO::PARAM_STR);
      $stmt->bindParam(':wash_type', $data['wash_type'], PDO::PARAM_STR);
      $stmt->bindParam(':moq', $data['moq'], PDO::PARAM_INT);
      $stmt->bindParam(':piece_weight', $data['piece_weight'], PDO::PARAM_INT);
      $stmt->bindParam(':color', $data['color'], PDO::PARAM_STR);
      $stmt->execute();
      $res = $stmt->rowCount();
    } catch(PDOException $e){
      return $e->getMessage();
    }
    return $res;
  }

  public function updateImagePath($data) {
    switch ($data['image_type']) {
      case 'front':
        $query = $this->pdo->prepare(
          'INSERT INTO images (p_id, article_no, image_front)
          VALUES(:p_id, :article_no, :image_front)
          ON DUPLICATE KEY UPDATE
          image_front = VALUES(image_front)');
        $query->bindParam(':image_front', $data['image_front'], PDO::PARAM_STR);
        break;
    case 'back':
      $query = $this->pdo->prepare(
        'INSERT INTO images (p_id, article_no, image_back)
          VALUES(:p_id, :article_no, :image_back)
          ON DUPLICATE KEY UPDATE
          image_back= VALUES(image_back)');
      $query->bindParam(':image_back', $data['image_back'], PDO::PARAM_STR);
      break;
      case 'side':
        $query = $this->pdo->prepare(
          'INSERT INTO images (p_id, article_no, image_side)
            VALUES(:p_id, :article_no, :image_side)
            ON DUPLICATE KEY UPDATE
            image_side= VALUES(image_side)');
        $query->bindParam(':image_side', $data['image_side'], PDO::PARAM_STR);
      break;
      case 'image_other_one':
        $query = $this->pdo->prepare(
          'INSERT INTO images (p_id, article_no, image_other_one)
          VALUES(:p_id, :article_no, :image_other_one)
          ON DUPLICATE KEY UPDATE
          image_other_one= VALUES(image_other_one)');
      $query->bindParam(':image_other_one', $data['image_other_one'], PDO::PARAM_STR);
      break;
      case 'image_other_two':
        $query = $this->pdo->prepare(
          'INSERT INTO images (p_id, article_no, image_other_two)
            VALUES(:p_id, :article_no, :image_other_two)
            ON DUPLICATE KEY UPDATE
            image_other_two= VALUES(image_other_two)');
        $query->bindParam(':image_other_two', $data['image_other_two'], PDO::PARAM_STR);
        break;
        default:
        //code block
      }
    $query->bindParam(':p_id', $data['p_id']);
    $query->bindParam(':article_no', $data['article_no']);
    $res = $query->execute();
    return $res;
  }
}

?>

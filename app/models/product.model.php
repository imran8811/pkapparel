<?php

namespace app\Models;
include_once(dirname(dirname(__DIR__)). "/Core/Model.php");
use Core\Model;

class ProductModel extends Model {
  public function __construct(){
    parent::__construct();
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

  public function addProduct($data) {
    $query = "INSERT INTO product
            (
            article_no,
            price,
            dept,
            category,
            slug,
            p_sizes,
            fitting,
            fabric_type,
            fabric_stretch,
            fabric_content,
            fabric_weight,
            front_fly,
            wash_type,
            moq,
            piece_weight,
            color,
            product_name
            )
            VALUES
            (
            :article_no,
            :price,
            :dept,
            :category,
            :slug,
            :p_sizes,
            :fitting,
            :fabric_type,
            :fabric_stretch,
            :fabric_content,
            :fabric_weight,
            :front_fly,
            :wash_type,
            :moq,
            :piece_weight,
            :color,
            :product_name
            )";
    $stmt= $this->pdo->prepare($query);
    $stmt->execute($data);
    $stmt2 = $this->pdo->prepare('SELECT MAX(p_id) from product');
    $stmt2->execute();
    $res = $stmt2->fetchColumn();
    return $res;
  }

}

?>

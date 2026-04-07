<?php

namespace app\Models;
include_once(dirname(dirname(__DIR__)). "/Core/Model.php");
use Core\Model;

class ProductModel extends Model {
  public function __construct(){
    parent::__construct();
  }

  public function getAllProducts() {
    $query = 'SELECT * FROM product ORDER BY product.p_id DESC';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
    $res = $stmt->fetchAll();
    return $res;
  }

  public function getFeaturedProducts() {
    $query = 'SELECT * FROM product WHERE product.featured=? ORDER BY product.p_id DESC';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(["1"]);
    $res = $stmt->fetchAll();
    return $res;
  }

  public function getFeaturedProductsByDept($dept) {
    $query = 'SELECT * FROM product WHERE dept=? ORDER BY p_id DESC';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$dept]);
    $res = $stmt->fetchAll();
    return $res;
  }

  public function getProductByArticleNo($article_no){
    $query = 'SELECT * FROM product WHERE product.article_no=?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$article_no]);
    $res = $stmt->fetchAll();
    return $res;
  }

  public function getProductsByDept($dept){
    $query = 'SELECT * FROM product WHERE dept=? ORDER BY p_id DESC';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$dept]);
    $res = $stmt->fetchAll();
    return $res;
  }

  public function getProductsByCategory($category){
    $query = 'SELECT * FROM product WHERE product.category=? ORDER BY product.p_id DESC';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$category]);
    $res = $stmt->fetchAll();
    return $res;
  }

  public function getProductsByDeptCategory($dept, $category){
    $query = 'SELECT * FROM product WHERE product.dept=? AND product.category=? ORDER BY product.p_id DESC';
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

  public function getSizeChart($dept, $category){
    $query = 'SELECT * FROM size_charts WHERE dept=? AND category=?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$dept, $category]);
    $res = $stmt->fetchAll();
    return $res;
  }

  public function updateProduct($data, $article_no){
    $query = "UPDATE product SET
            price=:price,
            dept=:dept,
            category=:category,
            slug=:slug,
            p_sizes=:p_sizes,
            fitting=:fitting,
            fabric_type=:fabric_type,
            fabric_stretch=:fabric_stretch,
            fabric_content=:fabric_content,
            fabric_weight=:fabric_weight,
            front_fly=:front_fly,
            wash_type=:wash_type,
            moq=:moq,
            piece_weight=:piece_weight,
            color=:color,
            product_name=:product_name
            WHERE article_no=:article_no";
    $stmt = $this->pdo->prepare($query);
    $data[':article_no'] = $article_no;
    $stmt->execute($data);
    return $stmt->rowCount() >= 0;
  }

  public function duplicateProduct($article_no, $new_article_no){
    $query = 'SELECT * FROM product WHERE article_no=?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$article_no]);
    $product = $stmt->fetch();
    if(!$product) return false;

    $insertQuery = "INSERT INTO product
            (article_no, price, dept, category, slug, p_sizes, fitting,
             fabric_type, fabric_stretch, fabric_content, fabric_weight,
             front_fly, wash_type, moq, piece_weight, color, product_name)
            VALUES
            (:article_no, :price, :dept, :category, :slug, :p_sizes, :fitting,
             :fabric_type, :fabric_stretch, :fabric_content, :fabric_weight,
             :front_fly, :wash_type, :moq, :piece_weight, :color, :product_name)";
    $insertStmt = $this->pdo->prepare($insertQuery);
    $insertStmt->execute([
      ':article_no'      => $new_article_no,
      ':price'           => $product['price'],
      ':dept'            => $product['dept'],
      ':category'        => $product['category'],
      ':slug'            => $product['slug'],
      ':p_sizes'         => $product['p_sizes'],
      ':fitting'         => $product['fitting'],
      ':fabric_type'     => $product['fabric_type'],
      ':fabric_stretch'  => $product['fabric_stretch'],
      ':fabric_content'  => $product['fabric_content'],
      ':fabric_weight'   => $product['fabric_weight'],
      ':front_fly'       => $product['front_fly'],
      ':wash_type'       => $product['wash_type'],
      ':moq'             => $product['moq'],
      ':piece_weight'    => $product['piece_weight'],
      ':color'           => $product['color'],
      ':product_name'    => $product['product_name'],
    ]);
    return $insertStmt->rowCount() > 0 ? $new_article_no : false;
  }

}

?>

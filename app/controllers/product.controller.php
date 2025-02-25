<?php
namespace app\Controllers;
use Core\Controller;
use app\Models\ProductModel;

class ProductController extends Controller {
  protected $productModel;

  public function __construct(){
    $this->productModel = new ProductModel();
  }

  public function getAllProducts(){
    $getAllProducts = $this->productModel->getAllProducts();
    return $getAllProducts;
  }

  public function getProductsByDept($dept){
    $getProductsByDept = $this->productModel->getProductsByDept($dept);
    return $getProductsByDept;
  }

  public function getProductsByCategory($dept){
    $getProductsByCategory = $this->productModel->getProductsByCategory($dept);
    return $getProductsByCategory;
  }

  public function getProductsByDeptCategory($dept, $category){
    $getProductsByDeptCategory = $this->productModel->getProductsByDeptCategory($dept, $category);
    return $getProductsByDeptCategory;
  }

  public function getProductByArticleNo($article_no){
    $getProductByArticleNo = $this->productModel->getProductByArticleNo($article_no);
    return $getProductByArticleNo;
  }
}
?>

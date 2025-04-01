<?php

namespace app\Controllers;

include_once(dirname(dirname(__DIR__)) . "/Core/Controller.php");
include_once(dirname(__DIR__) . "/models/product.model.php");

use Core\Controller;
use app\Models\ProductModel;
use finfo;

class ProductController extends Controller
{
  protected $productModel;

  public function __construct()
  {
    $this->productModel = new ProductModel();
  }

  public function getAllProducts()
  {
    $getAllProducts = $this->productModel->getAllProducts();
    return $getAllProducts;
  }

  public function getFeaturedProducts()
  {
    $getFeaturedProducts = $this->productModel->getFeaturedProducts();
    return $getFeaturedProducts;
  }
  
  public function getLatestArticleNo()
  {
    $getLatestArticleNo = $this->productModel->getLatestArticleNo();
    return $getLatestArticleNo;
  }

  public function getProductsByDept($dept)
  {
    $getProductsByDept = $this->productModel->getProductsByDept($dept);
    return $getProductsByDept;
  }

  public function getProductsByCategory($dept)
  {
    $getProductsByCategory = $this->productModel->getProductsByCategory($dept);
    return $getProductsByCategory;
  }

  public function getProductsByDeptCategory($dept, $category)
  {
    $getProductsByDeptCategory = $this->productModel->getProductsByDeptCategory($dept, $category);
    return $getProductsByDeptCategory;
  }

  public function getProductByArticleNo($article_no)
  {
    $getProductByArticleNo = $this->productModel->getProductByArticleNo($article_no);
    return $getProductByArticleNo;
  }

  public function addProduct($data){
    $addProduct = $this->productModel->addProduct($data);
    if ($addProduct) {
      $res = [
        'type' => 'success',
        'p_id' => $addProduct,
        'message' => 'Product Added Successfully'
      ];
    } else {
      $res = [
        'type' => 'error',
        'message' => 'Unable to add product'
      ];
    }
    return $res;
  }

  public function productImgUpload($article_no){
    if (empty($_FILES)) {
      $filesError = '$_FILES is empty - is file_uploads set to "Off" in php.ini?';
      return $filesError;
    }
    foreach($_FILES as $file){
      if($file['tmp_name']){
        if ($file["error"] !== UPLOAD_ERR_OK) {
          switch ($file["error"]) {
            case UPLOAD_ERR_PARTIAL:
              echo 'File only partially uploaded';
              break;
            case UPLOAD_ERR_NO_FILE:
              echo 'No file was uploaded';
              break;
            case UPLOAD_ERR_EXTENSION:
              echo 'File upload stopped by a PHP extension';
              break;
            case UPLOAD_ERR_FORM_SIZE:
              echo 'File exceeds MAX_FILE_SIZE in the HTML form';
              break;
            case UPLOAD_ERR_INI_SIZE:
              echo 'File exceeds upload_max_filesize in php.ini';
              break;
            case UPLOAD_ERR_NO_TMP_DIR:
              echo 'Temporary folder not found';
              break;
            case UPLOAD_ERR_CANT_WRITE:
              echo 'Failed to write file';
              break;
            default:
              echo 'Unknown upload error';
              break;
          }
        }
        // Reject uploaded file larger than 1MB
        if ($file["size"] > 1048576){
          echo 'File too large (max 1MB)';
        }
        // Use fileinfo to get the mime type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->file($file["tmp_name"]);
        $mime_types = ["image/gif", "image/png", "image/jpeg"];

        if (! in_array($mime_type, $mime_types)) {
          echo "Invalid file type";
        }

        // Replace any characters not \w- in the original filename
        $pathinfo = pathinfo($file["name"]);
        $base = $pathinfo["filename"];
        $base = preg_replace("/[^\w-]/", "_", $base);
        $filename = $base . "." . $pathinfo["extension"];
        if (!is_dir(dirname(dirname(__DIR__)) . "/uploads/".$article_no)) {
          mkdir(dirname(dirname(__DIR__)) . "/uploads/" . $article_no, 0777, true);
        }
        $destination = dirname(dirname(__DIR__)) . "/uploads/" . $article_no . "/" . $filename;
        // // Add a numeric suffix if the file already exists
        // $i = 1;

        // while (file_exists($destination)) {
        //   $filename = $base . "($i)." . $pathinfo["extension"];
        //   $destination = __DIR__ . "/uploads/" . $filename;
        //   $i++;
        // }

        if (!move_uploaded_file($file["tmp_name"], $destination)){
          echo "Can't move uploaded file";
        }
      }

    }
    return true;
  }
}

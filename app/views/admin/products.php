<?php
  include_once("app/views/admin/admin-header.php");
  require_once("app/controllers/product.controller.php");
  use app\Controllers\ProductController;
  $productController = new ProductController();
  $getProducts = $productController->getAllProducts();
?>
<div class="mt-5 mb-5">
  <h2 class="text-center mb-3">Products</h2>
  <div class="products">
    <div class="boxes">
      <?php foreach($getProducts as $product): ?>
        <div class="box mb-5">
          <a href="<?php echo '/admin/edit-product/' . $product['article_no'] ?>" class="d-block">
            <img src="/uploads/<?php echo $product["article_no"]?>/front.jpg" alt="Product Front Image" class="w-100" height="370" />
          </a>
          <ul class="list-group">
            <li class="list-item text-capitalize"><?php echo $product["product_name"] ?></li>
            <li class="list-item"><?php echo $product["article_no"] . "-" . $product["price"] ?></li>
            <li class="list-item"><?php echo $product["category"] . "-" . $product["color"] ?></li>
            <li class="list-item"><?php echo $product["fabric_stretch"] . "-" . $product["fabric_weight"] ?></li>
          </ul>
          <div class="col-12">
            <a href="/admin/products?productDelete=1" class="btn btn-danger">Delete</button>
            <a href="/admin/add-product?action=d&article_no=<?php echo $product['article_no']?>" target="_blank">Duplicate</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php if(count($getProducts) === 0): ?>
      <div class="mt-5 mb-5">
        <h3 class="text-danger">No Product Found</h3>
      </div>
    <?php endif; ?>
  </div>
</div>
</div>

<?php include_once("app/views/admin/admin-footer.php"); ?>

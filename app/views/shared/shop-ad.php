<?php
  require_once("app/controllers/product.controller.php");
  use app\Controllers\ProductController;
  $productController = new ProductController();
  $getProducts = $productController->getFeaturedProducts();
?>

<div class="mb-3 mt-5">
  <h2 class="text-center mb-3 h3">Wholesale Shop</h2>
  <div class="row">
    <?php foreach($getProducts as $product): ?>
      <div class="col-md-3 col-12 mb-5">
        <a href="/shop/<?php echo $product['dept'] ?>" class="d-block" rel="noreferrer">
          <img
            src=<?php echo "/uploads/" . $product['article_no'] . "/" . "front.jpg" ?>
            alt=<?php echo $product['product_name'] ?>
            class="img-fluid" />
        </a>
        <a
          class="text-capitalize d-block pt-3 px-3 text-dark"
          href="/shop/<?php echo $product['dept'] ?>">
          <span><?php echo $product['article_no'] ?>-</span>
          <span><?php echo $product['product_name'] ?></span><br />
          <span class="text-danger">Price: $<?php echo $product['price'] ?></span>
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</div>

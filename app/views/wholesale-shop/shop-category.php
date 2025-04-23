<?php
  include_once("app/views/shared/header.php");
  require_once("app/controllers/product.controller.php");
  use app\Controllers\ProductController;
  $productController = new ProductController();
  $getProducts = $productController->getProductsByDeptCategory($dept, $category);
  // print_r($getProducts);
?>
<div class="mb-3">
  <div class="shop-listing col-lg-12">
    <?php
      if(isset($_GET['newUser']))
        echo '<h2 class="text-success mt-5">Business Resgistered Successfully</h2>';
    ?>
    <div class="mb-3">
      <nav aria-label="breadcrumb" class="mt-4 px-4">
        <ol class="breadcrumb">
          <?php if(isset($dept)): ?>
            <li class="breadcrumb-item">
              <a href="/wholesale-shop">Wholesale Shop</a>
            </li>
          <?php endif; ?>
          <?php if(isset($dept)): ?>
            <li class="breadcrumb-item text-capitalize">
              <a href="/wholesale-shop/<?php echo $dept ?>">
                <?php echo $dept ?>
              </a>
            </li>
          <?php endif; ?>
          <?php if(isset($category)): ?>
            <li class="breadcrumb-item text-capitalize">
              <a href="/wholesale-shop/<?php echo $dept ?>/<?php echo $category ?>">
                <?php echo $category ?>
              </a>
            </li>
          <?php endif; ?>
        </ol>
      </nav>
      <div class="products-outer">
        <div class="products">
          <h1 class="text-center mb-5 text-capitalize"><?php echo $dept . ' ' . $category ?></h1>
          <div class="boxes">
            <?php foreach($getProducts as $product): ?>
              <div class="box mb-5">
                <a href="/wholesale-shop/<?php echo $product['dept'] ?>/<?php echo $product['category'] ?>/<?php echo $product['slug'] . '-' . $product['article_no'] ?>" class="d-block" rel="noreferrer">
                  <img
                    src=<?php echo "/uploads/" . $product['article_no'] . "/" . "front.jpg" ?>
                    alt=<?php echo $product['product_name'] ?>
                    height="370"
                    class="w-100" />
                </a>
                <a
                  class="text-capitalize d-block pt-3 px-3 text-dark"
                  href="/wholesale-shop/<?php echo $product['dept'] ?>/<?php echo $product['category'] ?>/<?php echo $product['slug'] . '-' . $product['article_no'] ?>">
                  <span><?php echo $product['article_no'] ?>-</span>
                  <span><?php echo $product['product_name'] ?></span><br />
                  <span class="text-danger">Price: $<?php echo $product['price'] ?></span>
                </a>
              </div>
            <?php endforeach; ?>
          </div>
          <?php if(count($getProducts) === 0)
            echo '<h4 class="text-center text-danger mb-5 mt-5">Photoshoot in progress...</h4>'
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once("app/views/shared/footer.php"); ?>

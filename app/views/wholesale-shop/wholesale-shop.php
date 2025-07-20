<?php
  include_once("app/views/shared/header.php");
  require_once("app/controllers/product.controller.php");
  use app\Controllers\ProductController;
  $productController = new ProductController();
  $getFeaturedProductsByDept = $productController->getFeaturedProductsByDept("men");
  // $getProducts = $productController->getProductsByDeptCategory($dept, $category);
  // print_r($getProducts);
?>
<div class="container-fluid">
  <div class="shop-listing col-lg-12">
    <?php
      if(isset($_GET['newUser']))
        echo '<h2 class="text-success mt-5">Business Resgistered Successfully</h2>';
    ?>
    <div class="mb-3">
      <div class="products-outer">
        <?php if(count($getFeaturedProductsByDept) > 0): ?>
        <div class="products">
          <h2 class="section-heading">Men Jeans Pants </h2>
          <div class="boxes">
            <?php $counter=0; foreach($getFeaturedProductsByDept as $product): ?>
            <?php if($product['category'] === 'jeans-pant'): ?>
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
                <span class="text-danger"><?php echo defaultCurrency ==='Rs'? defaultCurrency . $product['price_pkr']: defaultCurrency . $product['price'] ?></span>
              </a>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
          <div class="text-end mb-5">
            <a href="/wholesale-shop/men/jeans-pant" class="btn btn-primary">See all men jeans pants</a>
          </div>
        </div>
        <div class="products">
          <h2 class="section-heading">Men Chino Pants </h2>
          <div class="boxes">
            <?php $counter=0; foreach($getFeaturedProductsByDept as $product): ?>
            <?php if($product['category'] === 'chino-pant'): ?>
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
                <span class="text-danger"><?php echo defaultCurrency ==='Rs'? defaultCurrency . $product['price_pkr']: defaultCurrency . $product['price'] ?></span>
              </a>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
          <div class="text-end mb-5">
            <a href="/wholesale-shop/chino-pant" class="btn btn-primary">See all men chino pants</a>
          </div>
        </div>
        <div class="products">
          <h2 class="section-heading">Cargo Trousers </h2>
          <div class="boxes">
            <?php $counter=0; foreach($getFeaturedProductsByDept as $product): ?>
            <?php if($product['category'] === 'cargo-trouser'): ?>
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
                <span><?php echo $product['product_name'] ?></span><br /><span class="text-danger"><?php echo defaultCurrency ==='Rs'? defaultCurrency . $product['price_pkr']: defaultCurrency . $product['price'] ?></span>
              </a>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
          <div class="text-end mb-5">
            <a href="/wholesale-shop/men/cargo-trouser" class="btn btn-primary">See all men cargo trousers</a>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
</div>

<?php include_once("app/views/shared/footer.php"); ?>

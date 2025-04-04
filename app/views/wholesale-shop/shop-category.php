<?php
  include_once("app/views/shared/header.php");
  require_once("app/controllers/product.controller.php");
  use app\Controllers\ProductController;
  $productController = new ProductController();
  $getFeaturedProductsByDept = $productController->getFeaturedProductsByDept($dept);
  // print "<pre>";
  // print_r($getFeaturedProductsByDept);
  // print "</pre>";
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
          <li class="breadcrumb-item">
            <a href="/wholesale-shop">Wholesale Shop</a>
          </li>
          <li class="breadcrumb-item text-capitalize">
            <a href="/wholesale-shop/<?php echo $dept ?>">
              <?php echo $dept ?>
            </a>
          </li>
        </ol>
      </nav>
      <div class="products-outer">
        <h1 class="text-center mb-5">Garments Wholesale Shop</h1>
        <?php if(count($getFeaturedProductsByDept) > 0): ?>
        <div class="products">
          <h2 class="section-heading">Jeans Pants </h2>
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
                <span class="text-danger">Price: $<?php echo $product['price'] ?></span>
              </a>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
          <div class="text-end">
            <a href="/wholesale-shop/<?php echo $dept . '/jeans-pant' ?>" class="btn btn-primary">See all <?php echo $dept; ?> jeans pants</a>
          </div>
        </div>
        <?php if($dept === 'men'): ?>
        <div class="products">
          <h2 class="section-heading">Chino Pants </h2>
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
                <span class="text-danger">Price: $<?php echo $product['price'] ?></span>
              </a>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
          <div class="text-end">
            <a href="/wholesale-shop/<?php echo $dept . '/chino-pant' ?>" class="btn btn-primary">See all <?php echo $dept; ?> chino pants</a>
          </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>
        <?php if(count($getFeaturedProductsByDept) === 0)
          echo '<h4 class="text-center text-danger mb-5 mt-5">No Product Found</h4>'
        ?>
      </div>
    </div>
  </div>
</div>

<?php include_once("app/views/shared/footer.php"); ?>

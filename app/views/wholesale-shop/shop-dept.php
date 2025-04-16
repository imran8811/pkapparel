<?php
  include_once("app/views/shared/header.php");
  require_once("app/controllers/product.controller.php");
  use app\Controllers\ProductController;
  $productController = new ProductController();
  $getFeaturedProducts = $productController->getFeaturedProducts();
  // print_r($getFeaturedProducts);
?>
<div class="container-fluid">
  <?php
    if(isset($_GET['newUser']))
      echo '<h2 class="text-success mt-5">Business Registered Successfully</h2>';
  ?>
  <div class="products-outer">
    <div class="products">
      <h1 class="text-center mb-5">Garments Wholesale Shop</h1>
      <h2 class="section-heading">New Men Items </h2>
      <div class="boxes">
        <?php $counter=0; foreach($getFeaturedProducts as $product): ?>
          <?php if($product['dept'] === 'men'): ?>
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
        <?php if ($product['dept']==='men' && $counter++ == 4){ break; }?>
        <?php endforeach; ?>
      </div>
      <div class="text-end mb-5">
        <a href="/wholesale-shop/men" class="btn btn-primary">See all men items</a>
      </div>
      <h2 class="section-heading">New Women Items </h2>
      <div class="boxes">
        <?php $counter=0; foreach($getFeaturedProducts as $product): ?>
          <?php if($product['dept'] === 'women'): ?>
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
          <?php if ($product['dept']==='women' && $counter++ == 4){ break; }?>
        <?php endforeach; ?>
      </div>
      <div class="text-end mb-5">
        <a href="/wholesale-shop/women" class="btn btn-primary">See all women items</a>
      </div>
      <?php if(count($getFeaturedProducts) === 0)
        echo '<h4 class="text-center text-danger mb-5 mt-5">Photoshoot in progress...</h4>'
      ?>
    </div>
  </div>
</div>

<?php include_once("app/views/shared/footer.php"); ?>

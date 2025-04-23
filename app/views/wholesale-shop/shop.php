<?php
  include_once("app/views/shared/header.php");
  require_once("app/controllers/product.controller.php");
  use app\Controllers\ProductController;
  $productController = new ProductController();
  // $getProducts = $productController->getProductsByDeptCategory($dept, $category);
  // print_r($getProducts);
?>
<div class="mb-3 pt-5">
  <?php
    if(isset($_GET['newUser']))
      echo '<h2 class="text-success mt-5">Business Resgistered Successfully</h2>';
  ?>
  <h1 class="text-center mb-5">Men Products</h1>
  <div class="main-section row mb-5">
    <div class="sub-section row p-0 bg1 col-md-6 col-12 men-jeans-pant">
      <div class="left col-6 p-0">
        <div class="shop-now-overlay">
          <h3>Jeans Pants</h3>
          <a href="/wholesale-shop/men/jeans-pant" class="btn btn-primary">Shop Now</a>
        </div>
      </div>
      <div class="right col-6 p-0 justify-content-end">
        <img src="/public/images/jeans-pant-main.jpg" class="img-fluid" alt="men jeans pants" />
      </div>
    </div>
    <div class="sub-section p-0 row bg2 col-md-6 col-12">
      <div class="left col-6 p-0">
        <div class="shop-now-overlay">
          <h3>Chino Pants</h3>
          <a href="/wholesale-shop/men/chino-pant" class="btn btn-primary">Shop Now</a>
        </div>
      </div>
      <div class="right col-6 justify-content-end p-0">
        <img src="/public/images/men-chino-pant.jpg" class="img-fluid" alt="men chino pants" />
      </div>
    </div>
    <div class="sub-section p-0 row bg3 col-md-6 col-12">
      <div class="left col-6 p-0">
        <div class="shop-now-overlay">
          <h3>Cargo Trousers</h3>
          <a href="/wholesale-shop/men/cargo-trouser" class="btn btn-primary">Shop Now</a>
        </div>
      </div>
      <div class="right col-6 justify-content-end p-0">
        <img src="/public/images/men-cargo-trouser.jpg" class="img-fluid" alt="men cargo trousers" />
      </div>
    </div>
    <div class="sub-section p-0 row bg4 col-md-6 col-12">
      <div class="left col-6 p-0">
        <div class="shop-now-overlay">
          <h3>Jeans Jackets</h3>
          <a href="/wholesale-shop/men/jeans-jacket" class="btn btn-primary">Shop Now</a>
        </div>
      </div>
      <div class="right col-6 justify-content-end p-0">
        <img src="/public/images/jeans-shirt-main.jpg" class="img-fluid" alt="men jackets" />
      </div>
    </div>
  </div>
  <h1 class="text-center mb-5">Women Products</h1>
  <div class="main-section row mb-5">
    <div class="sub-section p-0 row bg5 col-md-6 col-12">
      <div class="left col-6 p-0">
        <div class="shop-now-overlay">
          <h3>Jeans Pants</h3>
          <a href="/wholesale-shop/women/jeans-pant" class="btn btn-primary">Shop Now</a>
        </div>
      </div>
      <div class="right col-6 justify-content-end p-0">
        <img src="/public/images/women-jeans-main.jpg" class="img-fluid" alt="women jeans pants" />
      </div>
    </div>
  </div>
</div>

<?php include_once("app/views/shared/footer.php"); ?>

<?php
  include_once(__DIR__)."/shared/header.php";
  require_once("app/controllers/product.controller.php");
  use app\Controllers\ProductController;
  $productController = new ProductController();
  $getFeaturedProductsByDept = $productController->getFeaturedProductsByDept("men");
?>
<?php include_once(__DIR__)."/shared/home-slider.php"; ?>
<div class="categories-section mb-5">
  <div class="sub-cat-section">
    <div class="shop-now-overlay">
      <h3>Men</h3>
      <a href="/wholesale-shop/men" class="btn btn-primary">Shop Now</a>
    </div>
  </div>
  <div class="sub-cat-section">
    <div class="shop-now-overlay">
      <h3>Women</h3>
      <a href="/wholesale-shop/women" class="btn btn-primary">Shop Now</a>
    </div>
  </div>
  <div class="sub-cat-section">
    <div class="shop-now-overlay">
      <h3>Boys</h3>
      <a href="/wholesale-shop/boys" class="btn btn-primary">Shop Now</a>
    </div>
  </div>
  <div class="sub-cat-section">
    <div class="shop-now-overlay">
      <h3>Girls</h3>
      <a href="/wholesale-shop/girls" class="btn btn-primary">Shop Now</a>
    </div>
  </div>
</div>
<div class="mb-5 px-4">
  <div class="section-heading">Why choose us</div>
  <div class="row">
    <div class="col-md-4 mb-3">
      <strong class="sub-head">ISO Certified</strong>
      <p>We are ISO 9001:2008 certified company, certification is a useful tool to add credibility, by demonstrating that your product or service meets the expectations of your customers.</p>
    </div>
    <div class="col-md-4 mb-3">
      <strong class="sub-head">Best Prices</strong>
      <p>Our prices are unbeatable, Our FOB prices for best quality jeans pants ranges from $4 - $8 depends on buyer&apos;s styling and design requirements.</p>
    </div>
    <div class="col-md-4 mb-3">
      <strong class="sub-head">On Time Shipment</strong>
      <p>We have delivered 80% of our shipments on time, We are highly expert in our field and have time estimates of every process it takes to complete shipment.</p>
    </div>
  </div>
</div>
<?php include_once(__DIR__).'/shared/rating-reviews.php'; ?>
<?php include_once(__DIR__).'/shared/faqs.php'; ?>
<?php include_once(__DIR__).'/shared/footer.php'; ?>

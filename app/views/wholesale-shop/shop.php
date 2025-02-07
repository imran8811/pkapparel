<?php
  include_once("app/views/shared/header.php");
  require_once "app/controllers/product.controller.php";
  $productController = new ProductController();
  if(isset($dept) && isset($category)){
    $getProducts = $productController->getProductsByDeptCategory($dept, $category);
  } else if(isset($dept)){
    $getProducts = $productController->getProductsByDept($dept);
  } else {
    $getProducts = $productController->getAllProducts();
  }
  // print_r($getProducts);
?>
<div class="mb-3">
  <div class="shop-listing col-lg-12">
    <div class="mb-3">
      <nav aria-label="breadcrumb" class="mt-4 px-4">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="/wholesale-shop">Wholesale Shop</a>
          </li>
          <?php if(isset($dept)): ?>
            <li class="breadcrumb-item text-capitalize">
              <a href="/wholesale-shop/<?php echo $dept ?>">
                <?php echo $dept ?>
              </a>
            </li>
          <?php endif; ?>
          <?php if(isset($category)): ?>
            <li class="breadcrumb-item text-capitalize">
              <a href="/wholesale-shop/<?php echo $dept ?>/<?php echo $ategory ?>">
                <?php echo $category ?>
              </a>
            </li>
          <?php endif; ?>
        </ol>
      </nav>
      <div class="products-outer">
        <div class="products">
          <ul class="product-categories-pills mb-5">
            <li class="mx-2 px-3">
              <a class="text-capitalize" href="/wholesale-shop/<?php echo "men" ?>/<?php echo "jeans-pant" ?>">
                <?php echo "Jeans Pants" ?>
              </a>
            </li>
          </ul>
          <div class="boxes">
            <?php foreach($getProducts as $product): ?>
              <div class="box mb-5">
                <a href="/wholesale-shop/<?php echo $product['dept'] ?>/<?php echo $product['category'] ?>/<?php echo $product['slug'] . '-' . $product['article_no'] ?>" class="d-block" rel="noreferrer">
                  <img
                    src=<?php echo $product['image_front'] ?>
                    alt=<?php echo $product['product_name'] ?>
                    height="370"
                    class="w-100" />
                </a>
                <a
                  class="text-capitalize d-block pt-3 px-3 text-dark"
                  href="/wholesale-shop/<?php echo $product['dept'] ?>/<?php echo $product['category'] ?>/<?php echo $product['slug'] . '-' . $product['article_no'] ?>">
                  <span><?php echo $product['article_no'] ?>-</span>
                  <span><?php echo $product['product_name'] ?></span><br />
                  <span class="text-danger">Price: <?php echo $product['price'] ?></span>
                </a>
              </div>
            <?php endforeach ?>
          </div>
          <?php if(count($getProducts) === 0)
            echo '<h4 class="text-center text-danger mb-5 mt-5">Products coming soon...</h4>'
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once("app/views/shared/footer.php"); ?>

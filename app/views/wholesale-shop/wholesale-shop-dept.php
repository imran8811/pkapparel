<?php
  include_once("app/views/shared/header.php");
  require_once("app/controllers/product.controller.php");
  require_once("app/controllers/review.controller.php");
  use app\Controllers\ProductController;
  use app\Controllers\ReviewController;
  $productController = new ProductController();
  $reviewController = new ReviewController();
  $allDeptProducts = $productController->getProductsByDept($dept);
  $allPIds = array_column($allDeptProducts, 'p_id');
  $reviewCounts = $reviewController->getReviewCountsForProducts($allPIds);
  $categoryGroups = [];
  foreach($allDeptProducts as $p){
    $categoryGroups[$p['category']][] = $p;
  }
?>
<div class="page-content">
  <div class="container-fluid px-4">
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/wholesale-shop">Shop</a></li>
        <li class="breadcrumb-item active text-capitalize"><?php echo htmlspecialchars($dept); ?></li>
      </ol>
    </nav>
    <h1 class="text-capitalize mb-4"><?php echo htmlspecialchars($dept); ?></h1>

    <?php foreach($categoryGroups as $catName => $products): ?>
    <div class="shop-section mb-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="section-heading mb-0 text-capitalize"><?php echo htmlspecialchars(str_replace('-', ' ', $catName)); ?></h2>
        <a href="/wholesale-shop/<?php echo htmlspecialchars($dept); ?>/<?php echo htmlspecialchars($catName); ?>" class="btn btn-outline-primary btn-sm">View All <i class="fas fa-arrow-right ms-1"></i></a>
      </div>
      <div class="swiper shopCarousel-<?php echo htmlspecialchars($dept . '-' . $catName); ?>">
        <div class="swiper-wrapper">
          <?php foreach(array_slice($products, 0, 10) as $product): ?>
          <div class="swiper-slide">
            <div class="product-card">
              <a href="/wholesale-shop/<?php echo htmlspecialchars($product['dept']); ?>/<?php echo htmlspecialchars($product['category']); ?>/<?php echo htmlspecialchars($product['slug'] . '-' . $product['article_no']); ?>" class="product-card-img-link">
                <img src="/uploads/<?php echo htmlspecialchars($product['article_no']); ?>/front.jpg" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="product-card-img" loading="lazy" />
              </a>
              <div class="product-card-body">
                <a href="/wholesale-shop/<?php echo htmlspecialchars($product['dept']); ?>/<?php echo htmlspecialchars($product['category']); ?>/<?php echo htmlspecialchars($product['slug'] . '-' . $product['article_no']); ?>" class="product-card-title text-capitalize">
                  <?php echo htmlspecialchars($product['product_name']); ?>
                </a>
                <div class="product-card-rating">
                  <i class="fas fa-comment"></i>
                  <span class="rating-count">(<?php echo isset($reviewCounts[$product['p_id']]) ? $reviewCounts[$product['p_id']] : 0; ?> reviews)</span>
                </div>
                <div class="product-card-price">
                  <span class="price-current">$<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></span>
                </div>
                <?php if(!empty($product['p_sizes'])): ?>
                <div class="product-card-sizes">
                  <?php foreach(explode(',', $product['p_sizes']) as $size): ?>
                    <span class="size-badge"><?php echo htmlspecialchars(trim($size)); ?></span>
                  <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <button class="btn btn-primary btn-sm btn-add-cart w-100 mt-2"
                  data-article="<?php echo htmlspecialchars($product['article_no']); ?>"
                  data-name="<?php echo htmlspecialchars($product['product_name']); ?>"
                  data-price="<?php echo htmlspecialchars($product['price']); ?>"
                  data-dept="<?php echo htmlspecialchars($product['dept']); ?>"
                  data-category="<?php echo htmlspecialchars($product['category']); ?>"
                  data-slug="<?php echo htmlspecialchars($product['slug']); ?>"
                  data-sizes="<?php echo htmlspecialchars($product['p_sizes']); ?>">
                  <i class="fas fa-cart-plus me-1"></i> Add to Cart
                </button>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
    </div>
    <?php endforeach; ?>

    <?php if(empty($categoryGroups)): ?>
      <h4 class="text-center text-danger my-5">No products found for <?php echo htmlspecialchars($dept); ?></h4>
    <?php endif; ?>
  </div>
</div>

<!-- Bundle Add to Cart Modal -->
<div class="modal fade" id="sizeSelectModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <form method="POST" action="/cart/add">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="article" id="modalArticle" />
        <input type="hidden" name="sizes" id="modalSizes" />
        <input type="hidden" name="price" id="modalPrice" />
        <div class="modal-header">
          <h5 class="modal-title">Add Sets to Cart</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label class="fw-bold mb-1 d-block">Available Sizes:</label>
            <div id="sizeOptions" class="d-flex flex-wrap gap-1 justify-content-center"></div>
          </div>
          <div class="alert alert-info py-2 mb-2 small">
            <i class="fas fa-box me-1"></i> <strong>1 Set = 10 Pieces</strong> (2 pcs per size)
          </div>
          <div class="mb-0">
            <label class="fw-bold mb-1" for="modalSetQty">Number of Sets:</label>
            <div class="d-flex align-items-center gap-2 justify-content-center">
              <button type="button" class="btn btn-outline-secondary btn-sm" id="modalQtyMinus">-</button>
              <input type="number" id="modalSetQty" name="quantity" value="1" min="1" max="999" class="form-control text-center" style="width:70px;" />
              <button type="button" class="btn btn-outline-secondary btn-sm" id="modalQtyPlus">+</button>
            </div>
            <small class="text-muted d-block text-center mt-1" id="modalPiecesInfo">1 set = 10 pieces</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include_once("app/views/shared/footer.php"); ?>

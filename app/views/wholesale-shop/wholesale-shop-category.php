<?php
  include_once("app/views/shared/header.php");
  require_once("app/controllers/product.controller.php");
  use app\Controllers\ProductController;
  $productController = new ProductController();
  $getProducts = $productController->getProductsByDeptCategory($dept, $category);
?>
<div class="page-content">
  <div class="container-fluid px-4">
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/wholesale-shop">Shop</a></li>
        <li class="breadcrumb-item text-capitalize"><a href="/wholesale-shop/<?php echo htmlspecialchars($dept); ?>"><?php echo htmlspecialchars($dept); ?></a></li>
        <li class="breadcrumb-item active text-capitalize"><?php echo htmlspecialchars(str_replace('-', ' ', $category)); ?></li>
      </ol>
    </nav>
    <h1 class="text-capitalize mb-4"><?php echo htmlspecialchars($dept . ' ' . str_replace('-', ' ', $category)); ?></h1>

    <?php if(count($getProducts) > 0): ?>
    <div class="row">
      <?php foreach($getProducts as $product): ?>
      <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
        <div class="product-card">
          <a href="/wholesale-shop/<?php echo htmlspecialchars($product['dept']); ?>/<?php echo htmlspecialchars($product['category']); ?>/<?php echo htmlspecialchars($product['slug'] . '-' . $product['article_no']); ?>" class="product-card-img-link">
            <img src="/uploads/<?php echo htmlspecialchars($product['article_no']); ?>/front.jpg" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="product-card-img" loading="lazy" />
          </a>
          <div class="product-card-body">
            <a href="/wholesale-shop/<?php echo htmlspecialchars($product['dept']); ?>/<?php echo htmlspecialchars($product['category']); ?>/<?php echo htmlspecialchars($product['slug'] . '-' . $product['article_no']); ?>" class="product-card-title text-capitalize">
              <?php echo htmlspecialchars($product['product_name']); ?>
            </a>
            <div class="product-card-rating">
              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
              <span class="rating-count">(4.5)</span>
            </div>
            <div class="product-card-price">
              <span class="price-current">PKR <?php echo htmlspecialchars($product['price_pkr']); ?></span>
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
              data-price="<?php echo htmlspecialchars($product['price_pkr']); ?>"
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
    <?php else: ?>
      <h4 class="text-center text-danger my-5">No products found</h4>
    <?php endif; ?>
  </div>
</div>

<!-- Bundle Add to Cart Modal -->
<div class="modal fade" id="sizeSelectModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
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
            <input type="number" id="modalSetQty" value="1" min="1" max="999" class="form-control text-center" style="width:70px;" />
            <button type="button" class="btn btn-outline-secondary btn-sm" id="modalQtyPlus">+</button>
          </div>
          <small class="text-muted d-block text-center mt-1" id="modalPiecesInfo">1 set = 10 pieces</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn-sm" id="confirmAddCart">Add to Cart</button>
      </div>
    </div>
  </div>
</div>

<?php include_once("app/views/shared/footer.php"); ?>

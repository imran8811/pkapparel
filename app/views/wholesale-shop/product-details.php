<?php
  include_once("app/views/shared/header.php");
  require_once "app/controllers/product.controller.php";
  use app\Controllers\ProductController;
  $productController = new ProductController();
  $article_no = explode("-", $name);
  $article_no = end($article_no);
  $getProductByArticleNo = $productController->getProductByArticleNo($article_no);
  $getSizeChart = $productController->getSizeChart($dept, $category);
?>
<div class="page-content">
  <div class="container-fluid px-4">
  <?php foreach($getProductByArticleNo as $productDetails): ?>
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/wholesale-shop">Shop</a></li>
        <li class="breadcrumb-item text-capitalize"><a href="/wholesale-shop/<?php echo htmlspecialchars($productDetails['dept']); ?>"><?php echo htmlspecialchars($productDetails['dept']); ?></a></li>
        <li class="breadcrumb-item text-capitalize"><a href="/wholesale-shop/<?php echo htmlspecialchars($productDetails['dept']); ?>/<?php echo htmlspecialchars($productDetails['category']); ?>"><?php echo htmlspecialchars(str_replace('-', ' ', $productDetails['category'])); ?></a></li>
        <li class="breadcrumb-item active"><?php echo htmlspecialchars($productDetails['article_no']); ?></li>
      </ol>
    </nav>

    <div class="row">
      <!-- Product Images -->
      <div class="col-md-6 mb-4">
        <div class="swiper productGallery">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <img src="/uploads/<?php echo htmlspecialchars($productDetails['article_no']); ?>/front.jpg" alt="<?php echo htmlspecialchars($productDetails['product_name']); ?>"/>
            </div>
            <div class="swiper-slide">
              <img src="/uploads/<?php echo htmlspecialchars($productDetails['article_no']); ?>/back.jpg" alt="<?php echo htmlspecialchars($productDetails['product_name']); ?>"/>
            </div>
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
        <div class="swiper productThumbs">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <img src="/uploads/<?php echo htmlspecialchars($productDetails['article_no']); ?>/front.jpg" alt="<?php echo htmlspecialchars($productDetails['product_name']); ?>"/>
            </div>
            <div class="swiper-slide">
              <img src="/uploads/<?php echo htmlspecialchars($productDetails['article_no']); ?>/back.jpg" alt="<?php echo htmlspecialchars($productDetails['product_name']); ?>"/>
            </div>
          </div>
        </div>
      </div>

      <!-- Product Info -->
      <div class="col-md-6">
        <h1 class="mb-2 text-capitalize"><?php echo htmlspecialchars($productDetails['product_name']); ?></h1>

        <div class="product-detail-rating mb-3">
          <i class="fas fa-star text-warning"></i>
          <i class="fas fa-star text-warning"></i>
          <i class="fas fa-star text-warning"></i>
          <i class="fas fa-star text-warning"></i>
          <i class="fas fa-star-half-alt text-warning"></i>
          <span class="ms-2 text-muted">(4.5 / 5 — 12 reviews)</span>
        </div>

        <h3 class="text-danger mb-3">PKR <?php echo htmlspecialchars($productDetails['price_pkr']); ?></h3>

        <!-- Available Sizes -->
        <?php if(!empty($productDetails['p_sizes'])): ?>
        <div class="mb-3">
          <label class="fw-bold mb-2 d-block">Available Sizes:</label>
          <div class="d-flex flex-wrap gap-2" id="detailSizeOptions">
            <?php foreach(explode(',', $productDetails['p_sizes']) as $size): ?>
              <span class="badge bg-secondary fs-6"><?php echo htmlspecialchars(trim($size)); ?></span>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- Bundle Info -->
        <div class="alert alert-info py-2 mb-3">
          <i class="fas fa-box me-1"></i>
          <strong>1 Set = 10 Pieces</strong> — 2 pcs each of sizes
          <?php if(!empty($productDetails['p_sizes'])): ?>
            <?php echo htmlspecialchars($productDetails['p_sizes']); ?>
          <?php else: ?>
            30, 32, 34, 36, 38
          <?php endif; ?>
        </div>

        <!-- Number of Sets -->
        <div class="mb-3">
          <label class="fw-bold mb-2" for="qty">Number of Sets:</label>
          <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-outline-secondary btn-sm" id="qtyMinus">-</button>
            <input type="number" id="qty" value="1" min="1" max="999" class="form-control text-center" style="width:70px;" />
            <button type="button" class="btn btn-outline-secondary btn-sm" id="qtyPlus">+</button>
          </div>
          <small class="text-muted mt-1 d-block" id="qtyPiecesInfo">1 set = 10 pieces</small>
        </div>

        <!-- Add to Cart -->
        <form method="POST" action="/cart/add" class="d-flex gap-2 mb-4" id="detailCartForm">
          <input type="hidden" name="article" value="<?php echo htmlspecialchars($productDetails['article_no']); ?>" />
          <input type="hidden" name="sizes" value="<?php echo htmlspecialchars($productDetails['p_sizes']); ?>" />
          <input type="hidden" name="price" value="<?php echo htmlspecialchars($productDetails['price_pkr']); ?>" />
          <input type="hidden" name="quantity" value="1" id="detailQtyHidden" />
          <button type="submit" class="btn btn-primary btn-lg" id="detailAddCart">
            <i class="fas fa-cart-plus me-1"></i> Add to Cart
          </button>
          <button type="submit" name="redirect" value="/checkout" class="btn btn-outline-success btn-lg">
            <i class="fas fa-bolt me-1"></i> Buy Now
          </button>
        </form>

        <hr />

        <!-- Product Specs -->
        <h5 class="mb-3">Product Details</h5>
        <table class="table table-sm table-striped">
          <tr><td class="fw-bold" style="width:40%">Article No.</td><td><?php echo htmlspecialchars($productDetails['article_no']); ?></td></tr>
          <tr><td class="fw-bold">Fabric</td><td><?php echo htmlspecialchars($productDetails['fabric_type'].'/'.$productDetails['fabric_content'].'/'.$productDetails['fabric_weight']); ?></td></tr>
          <tr><td class="fw-bold">Color(s)</td><td class="text-capitalize"><?php echo htmlspecialchars($productDetails['color']); ?></td></tr>
          <tr><td class="fw-bold">Wash Type</td><td><?php echo htmlspecialchars($productDetails['wash_type']); ?></td></tr>
          <tr><td class="fw-bold">Category</td><td class="text-capitalize"><?php echo htmlspecialchars($productDetails['category']); ?></td></tr>
          <tr><td class="fw-bold">Front Fly</td><td class="text-capitalize"><?php echo htmlspecialchars($productDetails['front_fly']); ?></td></tr>
          <tr><td class="fw-bold">MOQ</td><td><?php echo htmlspecialchars($productDetails['moq']); ?> Pieces</td></tr>
          <tr><td class="fw-bold">Delivery</td><td>30 days</td></tr>
          <tr><td class="fw-bold">Weight</td><td><?php echo htmlspecialchars($productDetails['piece_weight']); ?> grams</td></tr>
        </table>

        <div class="mt-3">
          <button class="btn btn-link p-0" id="btnSizeChartModal"><i class="fas fa-ruler me-1"></i> View Size Chart</button>
        </div>
      </div>
    </div>

    <!-- Size Chart Modal -->
    <div class="modal fade" id="sizeChartModal">
      <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-capitalize"><?php echo htmlspecialchars($dept . ' ' . $category); ?> Size Chart <span class="text-danger">(Inches)</span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <?php if(count($getSizeChart) > 0): ?>
            <table class="table table-bordered">
              <?php foreach($getSizeChart as $sizeChart): ?>
              <thead class="table-light">
                <tr>
                  <th>Size</th>
                  <?php foreach(explode(',', $sizeChart['size']) as $s): ?>
                    <th><?php echo htmlspecialchars($s); ?></th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                <tr><th>Waist</th><?php foreach(explode(',', $sizeChart['waist']) as $v){ echo '<td>'.htmlspecialchars($v).'</td>'; } ?></tr>
                <tr><th>Hip</th><?php foreach(explode(',', $sizeChart['hip']) as $v){ echo '<td>'.htmlspecialchars($v).'</td>'; } ?></tr>
                <tr><th>Thigh</th><?php foreach(explode(',', $sizeChart['thigh']) as $v){ echo '<td>'.htmlspecialchars($v).'</td>'; } ?></tr>
                <tr><th>Front Rise</th><?php foreach(explode(',', $sizeChart['front_rise']) as $v){ echo '<td>'.htmlspecialchars($v).'</td>'; } ?></tr>
                <tr><th>Back Rise</th><?php foreach(explode(',', $sizeChart['back_rise']) as $v){ echo '<td>'.htmlspecialchars($v).'</td>'; } ?></tr>
                <tr><th>Knee</th><?php foreach(explode(',', $sizeChart['knee']) as $v){ echo '<td>'.htmlspecialchars($v).'</td>'; } ?></tr>
                <tr><th>Leg Opening</th><?php foreach(explode(',', $sizeChart['leg_opening']) as $v){ echo '<td>'.htmlspecialchars($v).'</td>'; } ?></tr>
              </tbody>
              <?php endforeach; ?>
            </table>
            <?php else: ?>
              <p class="text-center text-danger">No size chart available</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
</div>
<?php include_once("app/views/shared/footer.php"); ?>

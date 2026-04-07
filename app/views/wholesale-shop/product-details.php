<?php
  include_once("app/views/shared/header.php");
  require_once "app/controllers/product.controller.php";
  require_once "app/controllers/review.controller.php";
  require_once "app/csrf.php";
  use app\Controllers\ProductController;
  use app\Controllers\ReviewController;
  $productController = new ProductController();
  $reviewController = new ReviewController();
  $article_no = explode("-", $name);
  $article_no = end($article_no);
  $getProductByArticleNo = $productController->getProductByArticleNo($article_no);
  $getSizeChart = $productController->getSizeChart($dept, $category);

  $reviewMessage = '';
  $reviewMessageType = '';

  $sessionExist = isset($_SESSION['user']) && $_SESSION['user'] !== '';
  $currentUserId = null;
  if($sessionExist){
    $currentUserId = $reviewController->getUserIdByEmail($_SESSION['user_email']);
  }

  // Handle review submission
  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_submit'])){
    if(!$sessionExist){
      $reviewMessage = 'Please login to submit a review.';
      $reviewMessageType = 'warning';
    } elseif(!csrf_verify()){
      $reviewMessage = 'Invalid form submission, please try again.';
      $reviewMessageType = 'danger';
    } else {
      $reviewText = trim($_POST['review_text'] ?? '');
      $rating = intval($_POST['rating'] ?? 5);
      if(empty($reviewText) || strlen($reviewText) < 5){
        $reviewMessage = 'Review must be at least 5 characters.';
        $reviewMessageType = 'danger';
      } elseif(strlen($reviewText) > 1000){
        $reviewMessage = 'Review must be under 1000 characters.';
        $reviewMessageType = 'danger';
      } elseif(!empty($getProductByArticleNo) && $reviewController->hasUserReviewed($currentUserId, $getProductByArticleNo[0]['p_id'])){
        $reviewMessage = 'You have already reviewed this product. You can edit your existing review.';
        $reviewMessageType = 'warning';
      } else {
        if(!empty($getProductByArticleNo)){
          $pId = $getProductByArticleNo[0]['p_id'];
          $added = $reviewController->addReview($currentUserId, $pId, $reviewText, $rating);
          if($added){
            $reviewMessage = 'Review submitted successfully!';
            $reviewMessageType = 'success';
          } else {
            $reviewMessage = 'Failed to submit review.';
            $reviewMessageType = 'danger';
          }
        }
      }
    }
  }

  // Handle review edit
  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_edit'])){
    if(!$sessionExist){
      $reviewMessage = 'Please login.';
      $reviewMessageType = 'warning';
    } elseif(!csrf_verify()){
      $reviewMessage = 'Invalid form submission.';
      $reviewMessageType = 'danger';
    } else {
      $editReviewId = intval($_POST['review_id'] ?? 0);
      $editText = trim($_POST['review_text'] ?? '');
      $editRating = intval($_POST['rating'] ?? 5);
      if(empty($editText) || strlen($editText) < 5){
        $reviewMessage = 'Review must be at least 5 characters.';
        $reviewMessageType = 'danger';
      } else {
        $updated = $reviewController->updateReview($editReviewId, $currentUserId, $editText, $editRating);
        if($updated){
          $reviewMessage = 'Review updated successfully!';
          $reviewMessageType = 'success';
        } else {
          $reviewMessage = 'Failed to update review.';
          $reviewMessageType = 'danger';
        }
      }
    }
  }

  // Handle review delete
  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_delete'])){
    if(!$sessionExist || !csrf_verify()){
      $reviewMessage = 'Invalid request.';
      $reviewMessageType = 'danger';
    } else {
      $deleteReviewId = intval($_POST['review_id'] ?? 0);
      $deleted = $reviewController->deleteReviewByUser($deleteReviewId, $currentUserId);
      if($deleted){
        $reviewMessage = 'Review deleted.';
        $reviewMessageType = 'success';
      } else {
        $reviewMessage = 'Failed to delete review.';
        $reviewMessageType = 'danger';
      }
    }
  }
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

        <?php
          $productReviews = $reviewController->getReviewsByProductId($productDetails['p_id']);
          $reviewCount = count($productReviews);
          $avgRating = 0;
          $userAlreadyReviewed = false;
          if($reviewCount > 0){
            $totalRating = 0;
            foreach($productReviews as $r){
              $totalRating += $r['rating'];
              if($currentUserId && $r['user_id'] == $currentUserId) $userAlreadyReviewed = true;
            }
            $avgRating = round($totalRating / $reviewCount, 1);
          }
        ?>
        <div class="product-detail-rating mb-3">
          <?php if($reviewCount > 0): ?>
            <?php for($i = 1; $i <= 5; $i++): ?>
              <?php if($i <= floor($avgRating)): ?>
                <i class="fas fa-star text-warning"></i>
              <?php elseif($i - $avgRating < 1 && $i - $avgRating > 0): ?>
                <i class="fas fa-star-half-alt text-warning"></i>
              <?php else: ?>
                <i class="far fa-star text-warning"></i>
              <?php endif; ?>
            <?php endfor; ?>
            <span class="ms-2 text-muted">(<?php echo $avgRating; ?> / 5 — <?php echo $reviewCount; ?> review<?php echo $reviewCount !== 1 ? 's' : ''; ?>)</span>
          <?php else: ?>
            <i class="far fa-star text-muted"></i>
            <span class="ms-2 text-muted">No reviews yet</span>
          <?php endif; ?>
        </div>

        <h3 class="text-danger mb-3">$<?php echo htmlspecialchars(number_format($productDetails['price'], 2)); ?></h3>

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

        <!-- Number of Sets -->
        <div class="mb-3">
          <label class="fw-bold mb-2" for="qty">Number of Sets:</label>
          <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-outline-secondary btn-sm" id="qtyMinus">-</button>
            <input type="number" id="qty" value="1" min="1" max="999" class="form-control text-center" style="width:70px;" />
            <button type="button" class="btn btn-outline-secondary btn-sm" id="qtyPlus">+</button>
          </div>
          <small class="text-muted mt-1 d-block" id="qtyPiecesInfo">1 set = 2 pieces of each size</small>
        </div>

        <!-- Add to Cart -->
        <form method="POST" action="/cart/add" class="d-flex gap-2 mb-4" id="detailCartForm">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="article" value="<?php echo htmlspecialchars($productDetails['article_no']); ?>" />
          <input type="hidden" name="sizes" value="<?php echo htmlspecialchars($productDetails['p_sizes']); ?>" />
          <input type="hidden" name="price" value="<?php echo htmlspecialchars($productDetails['price']); ?>" />
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

    <!-- Customer Reviews Section -->
    <div class="row mt-5">
      <div class="col-12">
        <h4 class="mb-4"><i class="fas fa-comments me-2"></i>Customer Reviews (<?php echo $reviewCount; ?>)</h4>

        <?php if($reviewMessage): ?>
          <div class="alert alert-<?php echo $reviewMessageType; ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($reviewMessage); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <!-- Review Form -->
        <?php if($sessionExist && !$userAlreadyReviewed): ?>
        <div class="card mb-4">
          <div class="card-body">
            <h6 class="card-title">Write a Review</h6>
            <form method="POST">
              <?php echo csrf_field(); ?>
              <div class="mb-3">
                <!-- <label class="form-label">Your Rating</label> -->
                <div class="star-rating-input" data-target="rating-new">
                  <?php for($i = 1; $i <= 5; $i++): ?>
                    <i class="far fa-star star-pick" data-value="<?php echo $i; ?>"></i>
                  <?php endfor; ?>
                </div>
                <input type="hidden" name="rating" id="rating-new" value="5">
              </div>
              <div class="mb-3">
                <textarea name="review_text" class="form-control" rows="3" placeholder="Share your experience with this product..." required minlength="5" maxlength="1000"></textarea>
              </div>
              <button type="submit" name="review_submit" value="1" class="btn btn-primary">
                <i class="fas fa-paper-plane me-1"></i> Submit Review
              </button>
            </form>
          </div>
        </div>
        <?php elseif($sessionExist && $userAlreadyReviewed): ?>
        <div class="alert alert-info border mb-4">
          <i class="fas fa-info-circle me-1"></i> You have already reviewed this product. You can edit or delete your review below.
        </div>
        <?php else: ?>
        <div class="alert alert-light border mb-4">
          <a href="/login" class="text-primary">Login</a> to write a review.
        </div>
        <?php endif; ?>

        <!-- Reviews List -->
        <?php if($reviewCount > 0): ?>
          <?php foreach($productReviews as $review): ?>
          <div class="card mb-3">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                  <strong><i class="fas fa-user-circle me-1"></i> <?php echo htmlspecialchars($review['business_name']); ?></strong>
                  <span class="ms-2 text-warning">
                    <?php
                      $rVal = intval($review['rating'] ?? 0);
                      for($i = 1; $i <= 5; $i++){
                        echo $i <= $rVal ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                      }
                    ?>
                  </span>
                </div>
                <small class="text-muted"><?php echo htmlspecialchars(date('M d, Y', strtotime($review['created_at']))); ?></small>
              </div>

              <!-- Display mode -->
              <div class="review-display-<?php echo $review['review_id']; ?>">
                <p class="mb-2"><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                <?php if($sessionExist && $currentUserId == $review['user_id']): ?>
                <div class="d-flex gap-2">
                  <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleEditReview(<?php echo $review['review_id']; ?>, <?php echo $rVal; ?>)">
                    <i class="fas fa-edit me-1"></i>Edit
                  </button>
                  <form method="POST" class="d-inline" onsubmit="return confirm('Delete this review?')">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="review_id" value="<?php echo $review['review_id']; ?>">
                    <button type="submit" name="review_delete" value="1" class="btn btn-sm btn-outline-danger">
                      <i class="fas fa-trash me-1"></i>Delete
                    </button>
                  </form>
                </div>
                <?php endif; ?>
              </div>

              <!-- Edit mode (hidden by default) -->
              <?php if($sessionExist && $currentUserId == $review['user_id']): ?>
              <div class="review-edit-<?php echo $review['review_id']; ?>" style="display:none;">
                <form method="POST">
                  <?php echo csrf_field(); ?>
                  <input type="hidden" name="review_id" value="<?php echo $review['review_id']; ?>">
                  <div class="mb-2">
                    <div class="star-rating-input" data-target="rating-edit-<?php echo $review['review_id']; ?>">
                      <?php for($i = 1; $i <= 5; $i++): ?>
                        <i class="<?php echo $i <= $rVal ? 'fas' : 'far'; ?> fa-star star-pick" data-value="<?php echo $i; ?>"></i>
                      <?php endfor; ?>
                    </div>
                    <input type="hidden" name="rating" id="rating-edit-<?php echo $review['review_id']; ?>" value="<?php echo $rVal; ?>">
                  </div>
                  <div class="mb-2">
                    <textarea name="review_text" class="form-control" rows="3" required minlength="5" maxlength="1000"><?php echo htmlspecialchars($review['review_text']); ?></textarea>
                  </div>
                  <div class="d-flex gap-2">
                    <button type="submit" name="review_edit" value="1" class="btn btn-sm btn-primary">
                      <i class="fas fa-save me-1"></i>Save
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleEditReview(<?php echo $review['review_id']; ?>)">Cancel</button>
                  </div>
                </form>
              </div>
              <?php endif; ?>

            </div>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-muted">No reviews yet. Be the first to review this product!</p>
        <?php endif; ?>
      </div>
    </div>

  <?php endforeach; ?>
  </div>
</div>
<script>var PIECES_PER_SET = 2;</script>
<style>
  .star-rating-input { font-size: 1.4rem; cursor: pointer; }
  .star-rating-input .star-pick { color: #ffc107; transition: color 0.15s; }
  .star-rating-input .star-pick:hover { color: #e0a800; }
</style>
<script>
// Star rating picker
document.querySelectorAll('.star-rating-input').forEach(function(container){
  var targetId = container.getAttribute('data-target');
  var stars = container.querySelectorAll('.star-pick');
  function setStars(val){
    stars.forEach(function(s){
      var v = parseInt(s.getAttribute('data-value'));
      s.className = (v <= val ? 'fas' : 'far') + ' fa-star star-pick';
    });
    document.getElementById(targetId).value = val;
  }
  stars.forEach(function(s){
    s.addEventListener('click', function(){ setStars(parseInt(this.getAttribute('data-value'))); });
    s.addEventListener('mouseenter', function(){
      var val = parseInt(this.getAttribute('data-value'));
      stars.forEach(function(st){ st.className = (parseInt(st.getAttribute('data-value')) <= val ? 'fas' : 'far') + ' fa-star star-pick'; });
    });
  });
  container.addEventListener('mouseleave', function(){ setStars(parseInt(document.getElementById(targetId).value)); });
  // Init: highlight stars for existing value
  setStars(parseInt(document.getElementById(targetId).value));
});

// Toggle edit/display for a review
function toggleEditReview(reviewId){
  var display = document.querySelector('.review-display-' + reviewId);
  var edit = document.querySelector('.review-edit-' + reviewId);
  if(edit.style.display === 'none'){
    edit.style.display = 'block';
    display.style.display = 'none';
  } else {
    edit.style.display = 'none';
    display.style.display = 'block';
  }
}
</script>
<?php include_once("app/views/shared/footer.php"); ?>

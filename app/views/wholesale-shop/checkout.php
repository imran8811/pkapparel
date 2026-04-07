<?php
  if(!isset($_SESSION)){ session_start(); }
  require_once("app/controllers/order.controller.php");
  require_once("app/controllers/cart.controller.php");
  require_once("app/csrf.php");
  use app\Controllers\OrderController;
  use app\Controllers\CartController;
  $orderCtrl = new OrderController();
  $cartCtrl = new CartController();

  $sessionExist = isset($_SESSION['user']) && $_SESSION['user'] !== '';
  $prefillName = $sessionExist && isset($_SESSION['business_name']) ? htmlspecialchars($_SESSION['business_name']) : '';
  $prefillEmail = $sessionExist && isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : '';
  $prefillCode = $sessionExist && isset($_SESSION['country_code']) ? htmlspecialchars($_SESSION['country_code']) : '';
  $prefillPhone = $sessionExist && isset($_SESSION['contact_no']) ? htmlspecialchars($_SESSION['contact_no']) : '';

  $userId = null;
  $cartItems = [];
  if($sessionExist && isset($_SESSION['user_email'])){
    $userId = $cartCtrl->getUserIdByEmail($_SESSION['user_email']);
    if($userId){
      $cartItems = $cartCtrl->getCartItems($userId);
    }
  }

  $piecesPerSet = 10;

  // Handle order submission via POST
  $checkoutError = '';
  if($_SERVER['REQUEST_METHOD'] === 'POST' && $userId && count($cartItems) > 0){
    if(!csrf_verify()){
      $checkoutError = 'Invalid form submission, please try again.';
    } else {
    $shName    = trim($_POST['shFullName'] ?? '');
    $shEmail   = trim(strtolower($_POST['shEmail'] ?? ''));
    $shCode    = trim($_POST['shCountryCode'] ?? '');
    $shPhone   = trim($_POST['shPhone'] ?? '');
    $shAddress = trim($_POST['shAddress'] ?? '');
    $shCity    = trim($_POST['shCity'] ?? '');
    $shState   = trim($_POST['shState'] ?? '');
    $shCountry = trim($_POST['shCountry'] ?? '');
    $shNotes   = trim($_POST['shNotes'] ?? '');

    if(empty($shName) || strlen($shName) < 2 || strlen($shName) > 100 || !preg_match('/^[a-zA-Z0-9\s\.\-\&\']+$/', $shName)){
      $checkoutError = 'Please enter a valid full name (2-100 characters).';
    } elseif(!filter_var($shEmail, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/', $shEmail)){
      $checkoutError = 'Please enter a valid email address.';
    } elseif(!preg_match('/^\+\d{1,4}$/', $shCode)){
      $checkoutError = 'Invalid country code.';
    } elseif(!preg_match('/^\d{6,15}$/', $shPhone)){
      $checkoutError = 'Phone number must be 6-15 digits.';
    } elseif(empty($shAddress) || strlen($shAddress) < 5 || strlen($shAddress) > 500){
      $checkoutError = 'Please enter a valid address (5-500 characters).';
    } elseif(empty($shCity) || strlen($shCity) < 2 || strlen($shCity) > 100){
      $checkoutError = 'Please enter a valid city.';
    } elseif(empty($shCountry) || strlen($shCountry) < 2 || strlen($shCountry) > 100){
      $checkoutError = 'Please enter a valid country.';
    } else {
    $total = 0;
    $totalPieces = 0;
    $orderItems = [];
    foreach($cartItems as $ci){
      $sets = (int)$ci['quantity'];
      $pieces = $sets * $piecesPerSet;
      $total += (float)$ci['cart_amount'] * $pieces;
      $totalPieces += $pieces;
      $orderItems[] = [
        'article' => $ci['article_no'],
        'name'    => $ci['product_name'],
        'price'   => $ci['cart_amount'],
        'dept'    => $ci['dept'],
        'category'=> $ci['category'],
        'slug'    => $ci['slug'],
        'sizes'   => $ci['cart_sizes'],
        'sets'    => $sets,
      ];
    }

    $orderNumber = 'PK-' . time() . rand(100, 999);
    $orderData = [
      'order_number'    => $orderNumber,
      'user_id'         => $userId,
      'total'           => $total,
      'total_pieces'    => $totalPieces,
      'shipping_name'   => htmlspecialchars($shName, ENT_QUOTES, 'UTF-8'),
      'shipping_email'  => filter_var($shEmail, FILTER_SANITIZE_EMAIL),
      'shipping_phone'  => htmlspecialchars($shCode . $shPhone, ENT_QUOTES, 'UTF-8'),
      'shipping_address'=> htmlspecialchars($shAddress, ENT_QUOTES, 'UTF-8'),
      'shipping_city'   => htmlspecialchars($shCity, ENT_QUOTES, 'UTF-8'),
      'shipping_state'  => htmlspecialchars($shState, ENT_QUOTES, 'UTF-8'),
      'shipping_country'=> htmlspecialchars($shCountry, ENT_QUOTES, 'UTF-8'),
      'shipping_notes'  => htmlspecialchars($shNotes, ENT_QUOTES, 'UTF-8'),
      'status'          => 'pending',
    ];

    $orderId = $orderCtrl->createOrder($orderData, $orderItems);
    if($orderId){
      $cartCtrl->clearCart($userId);
      $_SESSION['last_order_number'] = $orderNumber;
      header('Location: /order-placed');
      exit;
    }
    }
    }
  }

  // Calculate totals for display
  $total = 0;
  foreach($cartItems as $ci){
    $total += (float)$ci['cart_amount'] * (int)$ci['quantity'] * $piecesPerSet;
  }

  include_once("app/views/shared/header.php");
?>
<div class="page-content">
  <div class="container-fluid px-4">
    <h1 class="mb-4"><i class="fas fa-credit-card me-2"></i>Checkout</h1>

    <?php if(empty($cartItems)): ?>
    <div class="text-center py-5">
      <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
      <h4 class="text-muted">Your cart is empty</h4>
      <a href="/" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
    <?php else: ?>
    <div class="row">
      <!-- Shipping & Billing -->
      <div class="col-lg-7 mb-4">
        <?php if(!$sessionExist): ?>
        <div class="alert alert-info">
          Already have an account? <a href="/login">Login</a> for faster checkout.
        </div>
        <?php endif; ?>

        <div class="card mb-4">
          <div class="card-body">
            <h5 class="card-title mb-3">Shipping Information</h5>
            <?php if(!empty($checkoutError)): ?>
              <div class="alert alert-danger"><?php echo htmlspecialchars($checkoutError); ?></div>
            <?php endif; ?>
            <form id="checkoutForm" method="POST" action="/checkout">
              <?php echo csrf_field(); ?>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label" for="shFullName">Full Name *</label>
                  <input type="text" class="form-control" id="shFullName" name="shFullName" value="<?php echo $prefillName; ?>" required minlength="2" maxlength="100" />
                  <div class="invalid-feedback">Full name is required</div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label" for="shEmail">Email *</label>
                  <input type="email" class="form-control" id="shEmail" name="shEmail" value="<?php echo $prefillEmail; ?>" required maxlength="254" />
                  <div class="invalid-feedback">Valid email is required</div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="form-label" for="shCountryCode">Country Code *</label>
                  <input type="text" class="form-control" id="shCountryCode" name="shCountryCode" placeholder="+92" value="<?php echo $prefillCode; ?>" required pattern="\+\d{1,4}" maxlength="5" />
                  <div class="invalid-feedback">Required</div>
                </div>
                <div class="col-md-8 mb-3">
                  <label class="form-label" for="shPhone">Phone *</label>
                  <input type="tel" class="form-control" id="shPhone" name="shPhone" value="<?php echo $prefillPhone; ?>" required pattern="\d{6,15}" maxlength="15" />
                  <div class="invalid-feedback">Phone number is required</div>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label" for="shAddress">Address *</label>
                <textarea class="form-control" id="shAddress" name="shAddress" rows="2" required minlength="5" maxlength="500"></textarea>
                  <div class="invalid-feedback">Address is required</div>
              </div>
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="form-label" for="shCity">City *</label>
                  <input type="text" class="form-control" id="shCity" name="shCity" required minlength="2" maxlength="100" />
                  <div class="invalid-feedback">City is required</div>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label" for="shState">State / Province</label>
                  <input type="text" class="form-control" id="shState" name="shState" maxlength="100" />
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label" for="shCountry">Country *</label>
                  <input type="text" class="form-control" id="shCountry" name="shCountry" required minlength="2" maxlength="100" />
                  <div class="invalid-feedback">Country is required</div>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label" for="shNotes">Order Notes (optional)</label>
                <textarea class="form-control" id="shNotes" name="shNotes" rows="2" placeholder="Special instructions for your order" maxlength="1000"></textarea>
              </div>
              <button type="submit" class="btn btn-primary w-100 btn-lg d-lg-none mt-2">
                <i class="fas fa-check me-1"></i> Place Order
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Order Summary -->
      <div class="col-lg-5">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-3">Order Summary</h5>
            <?php foreach($cartItems as $ci):
              $sets = (int)$ci['quantity'];
              $pieces = $sets * $piecesPerSet;
              $sub = (float)$ci['cart_amount'] * $pieces;
            ?>
            <div class="checkout-item">
              <img src="/uploads/<?php echo htmlspecialchars($ci['article_no']); ?>/front.jpg" alt="<?php echo htmlspecialchars($ci['product_name']); ?>" />
              <div class="checkout-item-info">
                <strong class="text-capitalize"><?php echo htmlspecialchars($ci['product_name']); ?></strong>
                <small>Sizes: <?php echo htmlspecialchars(str_replace(',', ', ', $ci['cart_sizes'])); ?> | <?php echo $sets; ?> set(s) = <?php echo $pieces; ?> pcs</small>
              </div>
              <span class="fw-bold">$<?php echo number_format($sub / 320, 2); ?></span>
            </div>
            <?php endforeach; ?>
            <hr />
            <div class="d-flex justify-content-between mb-2">
              <span>Subtotal</span>
              <span>$<?php echo number_format($total / 320, 2); ?></span>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span>Shipping</span>
              <span class="text-success">Free</span>
            </div>
            <hr />
            <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
              <span>Total</span>
              <span class="text-danger">$<?php echo number_format($total / 320, 2); ?></span>
            </div>
            <button type="submit" form="checkoutForm" class="btn btn-primary w-100 btn-lg d-none d-lg-block">
              <i class="fas fa-check me-1"></i> Place Order
            </button>
            <a href="/cart" class="btn btn-outline-secondary w-100 mt-2"><i class="fas fa-arrow-left me-1"></i> Back to Cart</a>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div>
<?php include_once("app/views/shared/footer.php"); ?>

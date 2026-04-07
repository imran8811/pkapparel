<?php
  if(!isset($_SESSION)){ session_start(); }
  require_once("app/controllers/cart.controller.php");
  require_once("app/csrf.php");
  use app\Controllers\CartController;
  $cartCtrl = new CartController();

  $sessionExist = isset($_SESSION['user']) && $_SESSION['user'] !== '';
  $cartItems = [];
  $userId = null;
  if($sessionExist && isset($_SESSION['user_email'])){
    $userId = $cartCtrl->getUserIdByEmail($_SESSION['user_email']);
    if($userId){
      $cartItems = $cartCtrl->getCartItems($userId);
    }
  }

  $piecesPerSet = 10;
  $total = 0;
  $totalSets = 0;
  foreach($cartItems as $item){
    $sets = (int)$item['quantity'];
    $pieces = $sets * $piecesPerSet;
    $subtotal = (float)$item['cart_amount'] * $pieces;
    $total += $subtotal;
    $totalSets += $sets;
  }

  include_once("app/views/shared/header.php");
?>
<div class="page-content">
  <div class="container-fluid px-4">
    <h1 class="mb-4"><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h1>

    <?php if(empty($cartItems)): ?>
    <div class="text-center py-5">
      <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
      <h4 class="text-muted">Your cart is empty</h4>
      <a href="/" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
    <?php else: ?>
    <div class="row">
      <!-- Cart Items -->
      <div class="col-lg-8 mb-4">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th style="width:80px">Image</th>
                <th>Product</th>
                <th>Sizes</th>
                <th style="width:100px">Price/Set</th>
                <th style="width:160px">Sets</th>
                <th style="width:80px">Pieces</th>
                <th style="width:100px">Subtotal</th>
                <th style="width:50px"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($cartItems as $item):
                $sets = (int)$item['quantity'];
                $pieces = $sets * $piecesPerSet;
                $subtotal = (float)$item['cart_amount'] * $pieces;
              ?>
              <tr>
                <td><img src="/uploads/<?php echo htmlspecialchars($item['article_no']); ?>/front.jpg" alt="<?php echo htmlspecialchars($item['product_name']); ?>" /></td>
                <td><a href="/wholesale-shop/<?php echo htmlspecialchars($item['dept']); ?>/<?php echo htmlspecialchars($item['category']); ?>/<?php echo htmlspecialchars($item['slug'] . '-' . $item['article_no']); ?>" class="text-capitalize"><?php echo htmlspecialchars($item['product_name']); ?></a></td>
                <td><small><?php echo htmlspecialchars(str_replace(',', ', ', $item['cart_sizes'])); ?></small></td>
                <td>$<?php echo number_format($item['cart_amount'] / 320, 2); ?></td>
                <td>
                  <form method="POST" action="/cart" class="d-flex align-items-center gap-1">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="action" value="update" />
                    <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>" />
                    <button type="submit" name="quantity" value="<?php echo max(1, $sets - 1); ?>" class="btn btn-sm btn-outline-secondary">-</button>
                    <input type="number" class="form-control form-control-sm text-center" value="<?php echo $sets; ?>" min="1" style="width:60px;" onchange="this.form.querySelector('[name=quantity]').value=this.value;this.form.submit();" />
                    <button type="submit" name="quantity" value="<?php echo $sets + 1; ?>" class="btn btn-sm btn-outline-secondary">+</button>
                  </form>
                </td>
                <td><?php echo $pieces; ?></td>
                <td class="fw-bold">$<?php echo number_format($subtotal / 320, 2); ?></td>
                <td>
                  <form method="POST" action="/cart" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="action" value="remove" />
                    <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>" />
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-between mt-3">
          <a href="/" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Continue Shopping</a>
          <form method="POST" action="/cart" class="d-inline">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="action" value="clear" />
            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Clear all items from cart?')"><i class="fas fa-trash me-1"></i> Clear Cart</button>
          </form>
        </div>
      </div>

      <!-- Order Summary -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-3">Order Summary</h5>
            <div class="d-flex justify-content-between mb-2">
              <span>Subtotal (<?php echo $totalSets; ?> sets)</span>
              <span>$<?php echo number_format($total / 320, 2); ?></span>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span>Shipping</span>
              <span class="text-success">Calculated at checkout</span>
            </div>
            <hr />
            <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
              <span>Total</span>
              <span class="text-danger">PKR <?php echo number_format($total); ?></span>
            </div>
            <a href="/checkout" class="btn btn-primary w-100 btn-lg"><i class="fas fa-lock me-1"></i> Proceed to Checkout</a>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div>
<?php include_once("app/views/shared/footer.php"); ?>

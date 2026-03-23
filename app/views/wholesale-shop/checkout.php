<?php
  include_once("app/views/shared/header.php");
  $sessionExist = isset($_SESSION['user']) && $_SESSION['user'] !== '';
?>
<div class="page-content">
  <div class="container-fluid px-4">
    <h1 class="mb-4"><i class="fas fa-credit-card me-2"></i>Checkout</h1>

    <div id="checkoutEmpty" class="text-center py-5 d-none">
      <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
      <h4 class="text-muted">Your cart is empty</h4>
      <a href="/wholesale-shop" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>

    <div id="checkoutContent" class="d-none">
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
              <form id="checkoutForm" novalidate>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label" for="shFullName">Full Name *</label>
                    <input type="text" class="form-control" id="shFullName" required />
                    <div class="invalid-feedback">Full name is required</div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label" for="shEmail">Email *</label>
                    <input type="email" class="form-control" id="shEmail" required />
                    <div class="invalid-feedback">Valid email is required</div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label class="form-label" for="shCountryCode">Country Code *</label>
                    <input type="text" class="form-control" id="shCountryCode" placeholder="+92" required />
                    <div class="invalid-feedback">Required</div>
                  </div>
                  <div class="col-md-8 mb-3">
                    <label class="form-label" for="shPhone">Phone *</label>
                    <input type="tel" class="form-control" id="shPhone" required />
                    <div class="invalid-feedback">Phone number is required</div>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="shAddress">Address *</label>
                  <textarea class="form-control" id="shAddress" rows="2" required></textarea>
                  <div class="invalid-feedback">Address is required</div>
                </div>
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label class="form-label" for="shCity">City *</label>
                    <input type="text" class="form-control" id="shCity" required />
                    <div class="invalid-feedback">City is required</div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label" for="shState">State / Province</label>
                    <input type="text" class="form-control" id="shState" />
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label" for="shCountry">Country *</label>
                    <input type="text" class="form-control" id="shCountry" required />
                    <div class="invalid-feedback">Country is required</div>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="shNotes">Order Notes (optional)</label>
                  <textarea class="form-control" id="shNotes" rows="2" placeholder="Special instructions for your order"></textarea>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-5">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-3">Order Summary</h5>
              <div id="checkoutItems"></div>
              <hr />
              <div class="d-flex justify-content-between mb-2">
                <span>Subtotal</span>
                <span id="chkSubtotal">PKR 0</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Shipping</span>
                <span id="chkShipping" class="text-success">Free</span>
              </div>
              <hr />
              <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                <span>Total</span>
                <span id="chkTotal" class="text-danger">PKR 0</span>
              </div>
              <button type="button" class="btn btn-primary w-100 btn-lg" id="placeOrderBtn">
                <i class="fas fa-check me-1"></i> Place Order
              </button>
              <a href="/cart" class="btn btn-outline-secondary w-100 mt-2"><i class="fas fa-arrow-left me-1"></i> Back to Cart</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once("app/views/shared/footer.php"); ?>

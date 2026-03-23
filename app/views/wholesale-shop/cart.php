<?php include_once("app/views/shared/header.php"); ?>
<div class="page-content">
  <div class="container-fluid px-4">
    <h1 class="mb-4"><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h1>

    <div id="cartEmpty" class="text-center py-5 d-none">
      <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
      <h4 class="text-muted">Your cart is empty</h4>
      <a href="/wholesale-shop" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>

    <div id="cartContent" class="d-none">
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
                  <th style="width:130px">Sets</th>
                  <th style="width:80px">Pieces</th>
                  <th style="width:100px">Subtotal</th>
                  <th style="width:50px"></th>
                </tr>
              </thead>
              <tbody id="cartTableBody"></tbody>
            </table>
          </div>
          <div class="d-flex justify-content-between mt-3">
            <a href="/wholesale-shop" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Continue Shopping</a>
            <button class="btn btn-outline-danger" id="clearCartBtn"><i class="fas fa-trash me-1"></i> Clear Cart</button>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-3">Order Summary</h5>
              <div class="d-flex justify-content-between mb-2">
                <span>Subtotal (<span id="summaryCount">0</span> sets)</span>
                <span id="summarySubtotal">PKR 0</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Shipping</span>
                <span class="text-success">Calculated at checkout</span>
              </div>
              <hr />
              <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                <span>Total</span>
                <span id="summaryTotal" class="text-danger">PKR 0</span>
              </div>
              <a href="/checkout" class="btn btn-primary w-100 btn-lg"><i class="fas fa-lock me-1"></i> Proceed to Checkout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once("app/views/shared/footer.php"); ?>

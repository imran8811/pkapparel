<?php include_once("app/views/shared/header.php"); ?>
<div class="page-content">
  <div class="container-fluid px-4">
    <h1 class="mb-4"><i class="fas fa-list me-2"></i>My Orders</h1>

    <div id="ordersEmpty" class="text-center py-5 d-none">
      <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
      <h4 class="text-muted">No orders yet</h4>
      <a href="/wholesale-shop" class="btn btn-primary mt-3">Start Shopping</a>
    </div>

    <div id="ordersContent" class="d-none">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th>Order ID</th>
              <th>Date</th>
              <th>Items</th>
              <th>Total</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="ordersTableBody"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Order Detail Modal -->
<div class="modal fade" id="orderDetailModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Order Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="orderDetailBody"></div>
    </div>
  </div>
</div>
<?php include_once("app/views/shared/footer.php"); ?>
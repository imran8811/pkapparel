<?php include_once("app/views/shared/header.php"); ?>
<div class="page-content">
  <div class="container-fluid px-4">
    <div class="text-center py-5">
      <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
      <h1 class="mb-3">Order Placed Successfully!</h1>
      <p class="text-muted fs-5 mb-2">Thank you for your order.</p>
      <p class="text-muted mb-1">Order ID: <strong id="placedOrderId">—</strong></p>
      <p class="text-muted mb-4">We will contact you shortly to confirm your order details and shipping.</p>
      <div class="d-flex justify-content-center gap-3">
        <a href="/wholesale-shop" class="btn btn-primary btn-lg"><i class="fas fa-shopping-bag me-1"></i> Continue Shopping</a>
        <a href="/orders" class="btn btn-outline-secondary btn-lg"><i class="fas fa-list me-1"></i> View Orders</a>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    var orderId = localStorage.getItem('pk_last_order_id');
    if(orderId){
      document.getElementById('placedOrderId').textContent = orderId;
    }
  });
</script>
<?php include_once("app/views/shared/footer.php"); ?>
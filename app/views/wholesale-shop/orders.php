<?php
  if(!isset($_SESSION)){ session_start(); }
  require_once("app/controllers/order.controller.php");
  use app\Controllers\OrderController;
  $orderCtrl = new OrderController();

  $sessionExist = isset($_SESSION['user']) && $_SESSION['user'] !== '';
  $orders = [];
  if($sessionExist && isset($_SESSION['user_email'])){
    $userId = $orderCtrl->getUserIdByEmail($_SESSION['user_email']);
    if($userId){
      $orders = $orderCtrl->getOrdersByUserId($userId);
    }
  }

  include_once("app/views/shared/header.php");
?>
<div class="page-content">
  <div class="container-fluid px-4">
    <h1 class="mb-4"><i class="fas fa-list me-2"></i>My Orders</h1>

    <?php if(empty($orders)): ?>
    <div class="text-center py-5">
      <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
      <h4 class="text-muted">No orders yet</h4>
      <a href="/" class="btn btn-primary mt-3">Start Shopping</a>
    </div>
    <?php else: ?>
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
        <tbody>
          <?php foreach($orders as $order):
            $items = $orderCtrl->getOrderItems($order['order_id']);
            $totalSets = 0;
            $totalPieces = 0;
            foreach($items as $item){
              $totalSets += (int)$item['sets'];
              $totalPieces += (int)$item['pieces'];
            }
          ?>
          <tr>
            <td><strong><?php echo htmlspecialchars($order['order_number']); ?></strong></td>
            <td><?php echo date('Y-m-d', strtotime($order['created_at'])); ?></td>
            <td><?php echo $totalSets; ?> set(s) / <?php echo $totalPieces; ?> pcs</td>
            <td class="fw-bold">$<?php echo number_format($order['total'] / 320, 2); ?></td>
            <td>
              <span class="badge <?php
                switch($order['status']){
                  case 'pending': echo 'bg-warning text-dark'; break;
                  case 'confirmed': echo 'bg-info'; break;
                  case 'shipped': echo 'bg-primary'; break;
                  case 'delivered': echo 'bg-success'; break;
                  case 'cancelled': echo 'bg-danger'; break;
                  default: echo 'bg-secondary';
                }
              ?>"><?php echo ucfirst(htmlspecialchars($order['status'])); ?></span>
            </td>
            <td>
              <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal<?php echo $order['order_id']; ?>">Details</button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Order Detail Modals -->
    <?php foreach($orders as $order):
      $items = $orderCtrl->getOrderItems($order['order_id']);
    ?>
    <div class="modal fade" id="orderModal<?php echo $order['order_id']; ?>" tabindex="-1">
      <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Order Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['order_number']); ?></p>
            <p><strong>Date:</strong> <?php echo date('Y-m-d', strtotime($order['created_at'])); ?></p>
            <p><strong>Status:</strong> <span class="badge <?php
              switch($order['status']){
                case 'pending': echo 'bg-warning text-dark'; break;
                case 'confirmed': echo 'bg-info'; break;
                case 'shipped': echo 'bg-primary'; break;
                case 'delivered': echo 'bg-success'; break;
                case 'cancelled': echo 'bg-danger'; break;
                default: echo 'bg-secondary';
              }
            ?>"><?php echo ucfirst(htmlspecialchars($order['status'])); ?></span></p>
            <hr />
            <h6>Shipping</h6>
            <p>
              <?php echo htmlspecialchars($order['shipping_name']); ?><br/>
              <?php echo htmlspecialchars($order['shipping_address']); ?><br/>
              <?php echo htmlspecialchars($order['shipping_city']); ?><?php echo $order['shipping_state'] ? ', ' . htmlspecialchars($order['shipping_state']) : ''; ?>, <?php echo htmlspecialchars($order['shipping_country']); ?><br/>
              <?php echo htmlspecialchars($order['shipping_phone']); ?><br/>
              <?php echo htmlspecialchars($order['shipping_email']); ?>
            </p>
            <?php if($order['shipping_notes']): ?>
            <p><strong>Notes:</strong> <?php echo htmlspecialchars($order['shipping_notes']); ?></p>
            <?php endif; ?>
            <hr />
            <h6>Items</h6>
            <table class="table table-sm">
              <thead>
                <tr><th>Product</th><th>Sizes</th><th>Sets</th><th>Pieces</th><th>Price</th></tr>
              </thead>
              <tbody>
                <?php foreach($items as $item): ?>
                <tr>
                  <td class="text-capitalize"><?php echo htmlspecialchars($item['product_name']); ?></td>
                  <td><?php echo htmlspecialchars(str_replace(',', ', ', $item['sizes'])); ?></td>
                  <td><?php echo $item['sets']; ?></td>
                  <td><?php echo $item['pieces']; ?></td>
                  <td>$<?php echo number_format(($item['price'] * $item['pieces']) / 320, 2); ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div class="text-end fw-bold fs-5">Total: $<?php echo number_format($order['total'] / 320, 2); ?></div>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
<?php include_once("app/views/shared/footer.php"); ?>
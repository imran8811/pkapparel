<?php
    include_once("header.php");
    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
    }
    $profile = new Profile();
    $get_user_orders = $profile->get_user_orders();
?>
<div class="page-accounts clearfix">
   <?php include_once("user-sidebar.php"); ?>
    <div class="acc-content">
        <h1>Orders</h1>
        <div class="inner-wrap">
            <div class="order-details">
                <?php if ($get_user_orders) { ?>
                <?php foreach($get_user_orders as $order): ?>
                <div class="orders-det-list">
                    <table>
                    <tbody>
                       <tr>
                           <td>Order#:</td>
                           <td><?php echo $order['order_id']; ?></td>
                       </tr>
                        <tr>
                            <td>Order Date:</td>
                            <td><?php $date = strtotime($order['added_at']); echo date("d/m/Y", $date); ?></td>
                        </tr>
                        <tr>
                            <td>Size:</td><td><?php echo $order['size']; ?></td>
                        </tr>
                        <tr>
                            <td>Payment:</td><td><?php echo $order['payment_method']; ?></td>
                        </tr>
                        <tr>
                            <td>Shipping:</td><td><?php echo $order['shipping_cost']; ?></td>
                        </tr>
                        <tr>
                            <td>Order Amount:</td><td><?php echo $order['total_amount']; ?></td>
                        </tr>
                        <tr>
                            <td>Status:</td><td><?php echo $order['order_status']; ?></td>
                        </tr>
                       <tr>
                           <td>Address:</td>
                           <td><?php echo $order['address']; ?>, <?php echo $order['add_continue']; ?></td>
                       </tr>
                    </tbody>
                    </table>
                    <a href="<?php echo $base_url; ?>details.php?p=<?php echo $order['p_id']; ?>" target="_blank" class="view-product">View Product</a>
                </div>
                <?php endforeach; ?>
                <?php } else {
                    echo "<h2 class='notice margin-top-40'>No orders found</h2>";
                } ?>
            </div>
        </div>
    </div>
</div>
<?php include_once("footer.php"); ?>


<?php
	include_once("./init.php");
	$cart = new Cart();
	if(isset($_SESSION['sess_id']) ){
		$cart_items = $cart->get_cart_items();
	} else {
		$cart_items = array("items" => "0");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="Jeans Manufacturers"/>
  <meta name="description" content="PK Apparel specializes in export-quality denim jeans, and have been top Jeans Manufacturers for years with its clients all over the world. Place your order now!" />
  <meta name="google-site-verification" content="tq6NZzCuCj2a7kvdssFcuBKb8z0BdAjdUhS4e_IuiNY" />
  <title>Cart | PK Apparel</title>
  <link rel="icon" href="./assets/images/favicon.png" type="image/png">
  <link type="text/css" rel="stylesheet" href="./assets/css/style.css">
  <link type="text/css" rel="stylesheet" href="./assets/css/style-wholesale.css">
</head>
<body>
<div class="wrapper">
  <?php include_once ('./header-menu.php'); ?>
  <div class="main">
    <div class="page-cart">
      <div class="crumb-area">
        <ul class="breadcrumb">
          <li><a href="<?php echo $base_url; ?>">Home</a>&nbsp;&rightarrow;</li>
          <li>Cart</li>
        </ul>
      </div>
	    <?php if(!empty($cart_items)){ ?>
        <h2 class="page-head">View Cart</h2>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <td class="w-5">#</td>
                <td class="w-35">Details</td>
                <td class="w-10">Edit</td>
                <td class="w-30">Size/Quantity</td>
                <td class="w-10">Price</td>
                <td class="w-10">Total</td>
              </tr>
            </thead>
            <tbody>
              <?php foreach($cart_items as $key => $row): ?>
                <tr>
                  <td><?php echo $key+1 ?></td>
                  <td class="td-details">
                    <div class="details-wrap">
                      <div class="image-wrap">
                        <img src="<?php echo $row['image_front'] ?>" alt="product image">
                      </div>
                      <div class="details-text">
                        <p class="desc-text"><?php echo $row['p_desc']?></p>
                      </div>
                    </div>
                  </td>
                  <td class="td-edit">
                    <a href="#" data-id="<?php echo $row['p_id']; ?>"  class="link-remove" title="Remove Item"><i class="fa fa-trash-o"></i></a>
                    <a href="<?php echo $base_url ?>edit-cart.php?p=<?php echo $row['p_id']; ?>" data-id="<?php echo $row['p_id']; ?>"  title="Edit Item"><i class="fa fa-edit"></i></a>
                  </td>
                  <td>
                    <ul class="sizes-list clearfix">
                      <?php
                      $sizes = explode(",", $row['sizes']);
                      for($i=0; $i < count($sizes); $i++){
                        echo "<li>" . $sizes[$i]  .  "</li>";
                      }
                      ?>
                    </ul>
                    <ul class="sizes-list clearfix">
                      <?php
                        $qty = explode(",", $row['qty']);
                        for($i=0; $i < count($qty); $i++){
                            echo "<li>" . $qty[$i]  .  "</li>";
                        }
                      ?>
                    </ul>
                  </td>
                  <td class="item-price"><?php echo $row['item_price']?></td>
                  <td class="item-total"><?php $qty_vals = explode(",", $row['qty']); echo $row['item_price'] * array_sum($qty_vals); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
          </table>
          <div class="final-amount">
            <strong>Total: </strong>
            <strong class="amt-w-shipping"></strong>
          </div>
          <div class="cont-checkout">
            <a href="<?php echo $base_url;?>/checkout.php" class="btn-submit btn-checkout">Checkout</a>
          </div>
        </div>
	<?php } else { ?>
		<h2 class="notice">There is no item in cart</h2>
	<?php } ?>
</div>
  </div>
</div>
<?php include_once("./footer.php") ?>
<script src="./assets/js/jquery-3.3.1.js"></script>
<script>
	calculateCartSum();
	$(".item-qty").change(function(){
		calculateCartSum();
	});
	function calculateCartSum(){
		var total_amount = 0;
		var elm_cart = $('.page-cart tbody tr');
		$.each(elm_cart, function(){
			var item_total = parseInt($(this).find(".item-total").text());
			total_amount += item_total;
		});
		$(".amt-w-shipping").text(total_amount);
	}
</script>
</body>
</html>

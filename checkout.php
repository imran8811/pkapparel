<?php
	include_once ("./init.php");
	$cart = new Cart();
	$user = new User();
	$misc = new Misc();
	$profile = new Profile();
    $get_cities = $misc->get_cities();
    if(isset($_SESSION['sess_id'])){
      $count_cart_items = $cart->count_cart_items();
      $get_cart_items = $cart->get_cart_items();
    }
	if(isset($_SESSION['user_id'])){
		$is_logged = $user->get_logged_user_info($_SESSION['user_id']);
		$get_addresses = $profile->get_user_addresses($_SESSION['user_id']);
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
  <title>Expert Jeans Manufacturers and wholesale dealers of export-quality Denim | PK Apparel</title>
  <link rel="icon" href="./assets/images/favicon.png" type="image/png">
  <link type="text/css" rel="stylesheet" href="./assets/css/style.css">
  <link type="text/css" rel="stylesheet" href="./assets/css/style-wholesale.css">
</head>
<body>
<div class="wrapper">
  <?php include_once ('./header-menu.php'); ?>
  <div class="main">
<div class="page-checkout">
	<div class="checkout-inner">
		<h3 class="check-head">Checkout</h3>
		<?php if($count_cart_items > 0) { ?>
		<div class="section-login">
			<h3 class="sect-head">Login / Register</h3>
			<div class="inner-section">
				<?php if($_SESSION['user_type'] === "guest"){ ?>
					<div class="checkout-login clearfix">
						<div class="user-login">
							<h3 class="check-head">Sign in</h3>
							<form action="#" method="post" id="checkout-login-form">
								<div class="input-wrap">
									<input type="text" placeholder="Email" name="email" class="chk-email">
								</div>
								<div class="input-wrap">
									<input type="password" placeholder="Password" name="pass" class="chk-pass">
								</div>
                <span class='msg-error hidden'></span>
								<input type="submit" class="btn-submit" value="Sign in" name="user_login">
							</form>
              <span class="loader"></span>
						</div>
						<div class="user-register">
							<h3 class="check-head">New to Lahori Jeans?</h3>
							<a href="<?php echo $base_url; ?>/register.php" class="btn-submit">Join Us</a>
						</div>
					</div>
				<?php } else { ?>
					<?php foreach($is_logged as $row): ?>
					<div class="user-info">
						<span class="user-name"><?php echo $row['full_name'] ?></span><br>
						<span class="user-email"><?php echo $row['user_email'] ?></span>
					</div>
					<?php endforeach; ?>
				<?php } ?>
			</div>
		</div>
		<div class="section-address">
			<h3 class="sect-head">Shipping &nbsp;Address</h3>
			<div class="inner-section">
        <?php if(!isset($_SESSION['user_id'])){ ?>
          <div class="checkout-overlay"></div>
        <?php } ?>
				<div class="checkout-address">
					<div class="addresses">
						<?php if($_SESSION['user_type'] === "guest"){ ?>
							<h3 class="notice">Login to see shipping address</h3>
						<?php } else { ?>
							<?php foreach($get_addresses as $address): ?>
								<div class="single-add <?php if($address['add_status'] === '1'): echo "selected"; endif; ?>" data-id="<?php echo $address['address_id']; ?>">
									<a href="#" class="add-outer">
										<p><?php echo $address['address']; ?>, <?php echo $address['add_continue']; ?></p>
										<p><?php echo $address['ad_city']; ?></p>
									</a>
								</div>
							<?php endforeach; ?>
							<div class="single-add">
								<a href="#add" class="add-outer" rel="modal:open">Add New Address</a>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
<!--		<div class="section-accessory">-->
<!--			<h3 class="sect-head">Accessory &nbsp;<span class="text-small">( Brand Labels, Buttons, Hang tags etc )</span></h3>-->
<!--			<div class="inner-section">-->
<!--                --><?php //if(!isset($_SESSION['user_id'])){ ?>
<!--                    <div class="checkout-overlay"></div>-->
<!--                --><?php //} ?>
<!--				<ul class="radio-list clearfix">-->
<!--					<li>-->
<!--						<input type="radio" id="acc-any" value="any" name="accessory" checked><label for="acc-any"> Any</label>-->
<!--					</li>-->
<!--					<li>-->
<!--						<input type="radio" id="acc-buyer" value="custom" name="accessory"><label for="acc-buyer"> Custom</label>-->
<!--					</li>-->
<!--				</ul>-->
<!--			</div>-->
<!--		</div>-->
		<div class="section-shipping">
			<h3 class="sect-head">Shipping &nbsp;Options</h3>
			<div class="inner-section">
        <?php if(!isset($_SESSION['user_id'])){ ?>
            <div class="checkout-overlay"></div>
        <?php } ?>
				<ul class="radio-list clearfix">
					<li>
						<input type="radio" id="bus-cargo" value="bus" name="cargo" checked><label for="bus-cargo"> Bus Cargo</label>
					</li>
					<li>
						<input type="radio" id="train-cargo" value="train" name="cargo"><label for="train-cargo"> Train Cargo</label>
					</li>
					<li>
						<input type="radio" id="nccs-cargo" value="nccs" name="cargo"><label for="nccs-cargo"> NCCS Cargo</label>
					</li>
					<li>
						<input type="radio" id="tcs-courier" value="tcs" name="cargo"><label for="tcs-courier"> TCS Courier</label>
					</li>
					<li>
						<input type="radio" id="dhl-courier" value="dhl" name="cargo"><label for="dhl-courier"> DHL Courier</label>
					</li>
					<li>
						<input type="radio" id="leopard-courier" value="leopard" name="cargo"><label for="leopard-courier"> Leopard Courier</label>
					</li>
					<li>
						<input type="radio" id="mp-courier" value="mnp" name="cargo"><label for="mp-courier"> M&P Courier</label>
					</li>
				</ul>
			</div>
		</div>
		<div class="section-cartitems">
			<h3 class="sect-head">Cart &nbsp;Details</h3>
			<div class="inner-section">
        <?php if(!isset($_SESSION['user_id'])){ ?>
          <div class="checkout-overlay"></div>
        <?php } ?>
				<div class="checkout-summary clearfix">
					<table>
						<thead>
						<tr>
							<td class="w-5">#</td>
							<td class="w-40">Item</td>
							<td class="w-10">Size/Quantity</td>
							<td class="w-10">Amount</td>
						</tr>
						</thead>
						<tbody>
						<?php foreach($get_cart_items as $key => $item): ?>
							<tr data-cartitem="<?php echo $item['p_id']; ?>">
								<td><?php echo $key+1; ?></td>
								<td>
									<div class="item-outer">
										<div class="img-area">
											<img src="<?php echo $item['image_front']; ?>" alt="<?php echo $item['p_name']; ?>">
										</div>
										<div class="item-details">
											<strong class="title"><?php echo $item['p_desc']; ?></strong>
										</div>
									</div>
								</td>
								<td class="item-qty">
                  <ul class="sizes-list clearfix">
                    <?php
                    $sizes = explode(",", $item['sizes']);
                    for($i=0; $i < count($sizes); $i++){
                        echo "<li>" . $sizes[$i]  .  "</li>";
                    }
                    ?>
                  </ul>
                  <ul class="sizes-list j-calcqty clearfix">
                    <?php
                    $qty = explode(",", $item['qty']);
                    for($i=0; $i < count($qty); $i++){
                        echo "<li>" . $qty[$i]  .  "</li>";
                    }
                    ?>
                  </ul>
								</td>
								<td class="item-amount"><?php echo $item['item_price']; ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="checkout-confirm clearfix">
					<h2>Total Amount: <span class="pro-price"> 0</span></h2>
				</div>
			</div>
		</div>
		<div class="section-payment">
			<h3 class="sect-head">Payment &nbsp;Options</h3>
			<div class="inner-section">
        <?php if(!isset($_SESSION['user_id'])){ ?>
            <div class="checkout-overlay"></div>
        <?php } ?>
				<ul class="radio-list clearfix">
					<li>
						<input type="radio" id="bank-transfer" value="bank" name="payment" checked>
						<label for="bank-transfer"> Bank Transfer</label>
					</li>
					<li>
						<input type="radio" id="pay-easypaisa" value="mobile" name="payment">
						<label for="pay-easypaisa"> Mobile (easypaisa, jazzcash etc)</label>
					</li>
<!--					<li>-->
<!--						<input type="radio" id="pay-cards" name="payment">-->
<!--						<label for="pay-cards"> Debit/Credit Card</label>-->
<!--					</li>-->
				</ul>
			</div>
		</div>
		<div class="input-wrap clearfix">
			<a href="#" class="btn-submit j-confirm-order">Confirm Order</a>
		</div>
		<?php }  else {
			echo "<h2 class='notice'>No Item in cart</h2>";
		} ?>
	</div>
	<div id="add" style="display:none;" class="add-address">
		<p class="req-fields">All field required</p>
		<form action="#" class="form-addaddress">
			<div class="input-wrap">
				<label for="n-address">Address</label>
				<input type="text" id="n-address" name="n_address" class="add-input">
			</div>
			<div class="input-wrap">
				<label for="add-continue">Address Continue</label>
				<input type="text" id="add-continue" name="add_continue" class="add-cont-input">
			</div>
      <div class="input-wrap">
        <select class="add-cities">
          <option>Select City</option>
          <?php foreach($get_cities as $city): ?>
            <option value="<?php echo $city['city_name']; ?>"><?php echo $city['city_name']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
			<div class="input-wrap clearfix">
				<input type="submit" value="Add" class="btn-submit">
			</div>
		</form>
	</div>
</div>
  </div>
</div>
<?php include_once ("./footer.php");?>
<script src="./assets/js/jquery-3.5.1.js"></script>
<?php include_once ("./assets/js/checkoutjs.php");?>
</body>
</html>
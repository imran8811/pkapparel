<?php
	include_once("./init.php");
	$p_id           = $_GET['p'];
	$JeansPants     = new JeansPants();
	$cart           = new Cart();
	$get_cart_item_details = $cart->get_cart_item_details($p_id);
	$proceed_cart = true;
	foreach($get_cart_item_details as $c_cart){
		if(empty($c_cart['p_id'])){
			$proceed_cart = false;
		};
	};
//	echo "<pre>";
//	print_r($get_cart_item_details);
//	echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="Jeans pants Manufacturers, Jeans pants Wholesalers, Jeans Pants suppliers"/>
	<meta name="description" content="PK Apparel Specializes in jeans pants manufacturing and wholesale, jeans Jackets wholesale, Jeans Shirt and all other denim products. We stand behind all of the products that we handle and we are the company that stand behind the quality and performance of the products they build"/>
	<meta name="google-site-verification" content="tq6NZzCuCj2a7kvdssFcuBKb8z0BdAjdUhS4e_IuiNY" />
	<title>Jeans Manufacturer and Wholesale - Jeans Pants Jeans Jackets</title>
	<link rel="icon" href="./assets/images/favicon.png" type="image/png">
	<link type="text/css" rel="stylesheet" href="./assets/css/style.css">
	<link type="text/css" rel="stylesheet" href="./assets/css/style-wholesale.css">
</head>
<body>
<div class="wrapper">
	<?php include_once('./header-menu.php'); ?>
	<div class="main">
<div class="page-editcart clearfix">
	<div class="crumb-area">
		<ul class="breadcrumb">
			<li><a href="<?php echo $base_url; ?>">Home</a>&nbsp;&rightarrow;</li>
			<li><a href="<?php echo $base_url; ?>cart.php">Cart</a>&nbsp;&rightarrow;</li>
			<li>Edit Cart </li>
		</ul>
	</div>
	<?php if($proceed_cart) { ?>
	<?php foreach($get_cart_item_details as $details): ?>
	<form action="#">
		<div class="details-inner clearfix">
			<div class="gallery-area">
				<img src="<?php echo $details['image_front']; ?>" alt="Image Front">
			</div>
			<div class="details-area">
				<div class="title-area">
					<span class="style-no">PK-<?php echo $details['p_id']; ?></span>
					<span class="color-name"><?php echo $details['color']; ?></span>
					<span class="price">Rs. <span class="pro-price"><?php echo $details['item_price']; ?></span></span>
				</div>
				<div class="qty-selection">
					<div class="sizes-wrap">
						<p>Sizes</p>
						<ul class="cart-sizes">
							<?php
								$get_stock  = $JeansPants->get_stock($details['p_id']);
								foreach($get_stock as $stock): ?>
								<li><?php echo $stock['size_name']; ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
					<div class="qty-wrap">
						<p>Qty</p>
						<ul class="cart-qty">
							<?php foreach($get_stock as $stock): ?>
								<li>
									<select data-id="<?php echo $stock['size_name']; ?>">
										<option value="0">0 Pcs</option>
										<?php
											$current_stock =  $stock['stock'];
											$current_stock < 5 ? $min_qty = $current_stock: $min_qty = 5;
											$det_qty = explode(",", $details['qty']);
											$det_sizes = explode(",", $details['sizes']);
//											foreach($det_sizes as $det_size){
//												if($stock['size_name'] == $det_size){
//													$size_match = $det_size;
//													break;
//												}
//											}
											for($i = $min_qty; $i < $current_stock+1; $i++) {
//												foreach($det_qty as $dq) { ?>
<!--													--><?php //if($i == $dq) {
//														break;
//													}
//												} ?>
												<option>
													<?php echo $i ?>
												</option>
											<?php }
										?>
									</select>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<div class="notice-list">
						<div class="total-sum">
							Pcs = <strong class="t-pcs">0</strong>
						</div>
						<div class="total-sum">
							Amount = <strong class="t-amount">0</strong>
						</div>
					</div>
				</div>
				<input type="submit" value="Update" class="btn-submit update-cart">
			</div>
		</div>
	</form>
	<?php endforeach; ?>
	<?php } else { ?>
		<h2 class="notice">No item in cart</h2>
	<?php } ?>
</div>
  </div>
</div>
<?php include_once("footer.php"); ?>
<script src="./assets/js/jquery-3.5.1.min.js"></script>
<script>
	calculateTotal();
	$(".update-cart").on("click", function(e){
		e.preventDefault();
		var cart_validated = validateCart();
		if(cart_validated){
			var size_qty = {};
			$(".cart-qty select").each(function(index){
				var get_size = $(this).find("option:selected").val();
				var size = $(this).data("id");
				if(get_size > 0){
					size_qty[size] = $(this).find("option:selected").val();
				}
			});
			$.ajax({
				type:"POST",
				url: "<?php echo $base_url; ?>/api.php",
				data: {
					p_id: '<?php echo $p_id ?>',
					sizes_qty : size_qty,
					update_cart: 1
				},
				success: function(data){
					$(".total-cart").html(data);
					$.alert({
						title: "Success",
						content: 'Cart Updated',
						type: 'green',
						boxWidth: '30%',
						useBootstrap: false,
						animation: 'zoom',
						animationSpeed: 200,
						onClose: function(){
							location.reload();
						}
					});
				}
			})
		}
	});

	function validateCart(){
		var qty_check = 0;
		$(".cart-qty select option:selected").each(function(){
			if($(this).val() > 0){
				qty_check++
			}
		});
		if(qty_check == 0){
			alert("You have not selected pcs");
			return false;
		} else if(qty_check == 1){
			alert("Buy at least 2 sizes");
			return false;
		} else {
			return true;
		}
	}

	$(".cart-qty select").change(function(){
		calculateTotal();
	});

	function calculateTotal(){
		var total_qty = 0;
		$(".cart-qty select").each(function(){
			total_qty += parseInt($(this).find("option:selected").val()) || 0;
		});
		$(".notice-list .t-pcs").text(total_qty);
		var proPrice = parseInt($(".title-area .pro-price").text()) * total_qty;
		$(".notice-list .t-amount").text(proPrice);
	}
</script>
</body>
</html>
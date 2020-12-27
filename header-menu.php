<?php 
  require_once("./init.php");
	$cart = new Cart();
	if(isset($_SESSION['sess_id'])){
		$count_cart_items = $cart->count_cart_items();
	} else {
		$count_cart_items = 0;
	}
	if($count_cart_items > 0){
		$get_cart_items = $cart->get_cart_items();
	}
  print_r($_SESSION);
  $base_url = $_SERVER['HTTP_HOST'] === 'localhost:8080'? 'http://localhost:8080/pkwebnew' : 'https://www.pkapparel.com' 
?>
<header>
  <div class="holder clearfix">
    <div class="head-contact clearfix">
      <div class="clearfix">
        <a href="<?php echo $base_url; ?>" class="logo">
          <img src="<?php echo $base_url; ?>/assets/images/logo.jpg" alt="logo" width="200" title="PK Apparel Home">
        </a>
        <nav id="nav" class="open-close">
          <a href="" class="opener">Menu</a>
          <ul class="navigation">
            <li><a href="<?php echo $base_url; ?>">Home</a></li>
            <li><a href="<?php echo $base_url; ?>/about.php">About us</a></li>
            <li><a href="<?php echo $base_url; ?>/factory.php">Factory</a></li>
            <li><a href="<?php echo $base_url; ?>/men/jeans-pants.php">Jeans Pants</a></li>
            <li><a href="<?php echo $base_url; ?>/men/jeans-shirts.php">Jeans Shirts</a></li>
            <li><a href="<?php echo $base_url; ?>/blog.php">Blog</a></li>
            <li><a href="<?php echo $base_url; ?>/contact.php">Contact us</a></li>
          </ul>
        </nav>
        <ul class="whatsapp-inquiry">
          <li>Whatsapp for inquiries</li>
          <li><a href="https://wa.me/923000911000">+923 000-911-000</a></li>
        </ul>
        <ul class="topbar-links">
        <?php if(!User::is_logged()) { ?>
          <li><a href="login.php"> Sign in </a> </li>
          <li><a href="register.php"> Register </a></li>
          <?php } else { ?>
            <li class="username-link">
              <a href="<?php echo $base_url; ?>acc-info.php">
              <?php
                if(isset($_SESSION['user_id'])){
                  echo $_SESSION['full_name'];
                }
              ?>
              <i class="fa fa-caret-down"></i>
              </a>
              <ul class="profile-dropdown">
                  <li><a href="orders.php">Orders</a></li>
                  <li><a href="acc-info.php">Account settings</a></li>
                  <li><a href="logout.php">Logout</a></li>
              </ul>
            </li>
		        <?php } ?>
              <li class="link-cart">
                <a href="cart.php"><i class="fa fa-cart-arrow-down"></i> Cart (<span class="total-cart" style="color: red"><?php echo $count_cart_items; ?></span>)</a>
                <div class="cart-hover">
				        <?php if($count_cart_items > 0) { ?>
                  <div class="outer-wrap">
						        <?php foreach($get_cart_items as $row): ?>
                        <div class='cart-wrap'>
                            <div class='img-area'>
                                <img src="<?php echo $row["image_front"]; ?>" alt='product image'>
                            </div>
                            <div class='cart-details'>
                              <div class="sizes-wrap">
                                <span class="text">Sizes:</span>
                                <ul class='sizes-list'>
                                  <?php
                                    $sizes = explode(",", $row['sizes']);
                                    for($i=0; $i < count($sizes); $i++){
                                      echo "<li>" . $sizes[$i]  .  "</li>";
                                    }
                                  ?>
                                </ul>
                            </div>
                            <div class="sizes-wrap">
                              <span class="text">Qty:</span>
                              <ul class='sizes-list'>
                                <?php
                                  $qty = explode(",", $row['qty']);
                                  for($i=0; $i < count($qty); $i++){
                                      echo "<li>" . $qty[$i]  .  "</li>";
                                  }
                                ?>
                              </ul>
                            </div>
                        </div>
                        <div class='qty-amount'>
                          <span class='qty'><?php echo array_sum(explode(",",$row["qty"])) ?></span> X
                          <span class='unit-amount'><?php echo $row["item_price"] ?></span>
                          <a href="<?php echo $base_url; ?>/edit-cart.php?p=<?php echo $row['p_id']; ?>" class='btn-edit'>Edit</a>
                          <a href='#' data-id="<?php echo $row['p_id']; ?>" class='btn-remove'>Remove</a>
                        </div>
                    </div>
						        <?php endforeach; ?>
                    </div>
                    <div class="cart-outer">
                      <div class="amount-wrap clearfix">
                        <a href="#" class="empty-cart">Empty Cart</a>
                        <strong>Total Amount: <span class="total-amount">0</span></strong>
                      </div>
                      <ul class="hover-links clearfix">
                        <li><a href="cart.php">View Cart</a></li>
                        <li class="btn-checkout"><a href="checkout.php">Checkout</a></li>
                      </ul>
                    </div>
				        <?php } else {
					        echo "<h3 class='no-item-cart'>No Item in cart</h3>";
				        } ?>
                    </div>
                </li>
            </ul>
      </div>
    </div>
    <nav class="main-menu">
      <ul>
        <li><a href="<?php echo $base_url; ?>/about.php">About us</a></li>
        <li><a href="<?php echo $base_url; ?>/factory.php">Factory</a></li>
        <li><a href="<?php echo $base_url; ?>/men/jeans-pants.php">Jeans Pants</a></li>
        <li><a href="<?php echo $base_url; ?>/men/jeans-shirts.php">Jeans Shirts</a></li>
        <li><a href="<?php echo $base_url; ?>/blog.php">Blog</a></li>
        <li><a href="<?php echo $base_url; ?>/contact.php">Contact us</a></li>
      </ul>
    </nav>
  </div><!--end of header holder-->
</header>

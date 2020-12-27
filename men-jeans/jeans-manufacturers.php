<?php
	require_once("../init.php");
	$base_url = $_SERVER['HTTP_HOST'] === 'localhost:8080'? 'http://localhost:8080/pkwebnew' : 'https://www.pkapparel.com';
  $cart = new Cart();
  $JeansPants	= new JeansPants();
  $misc = new Misc();
  $get_jeans_pants 		= $JeansPants->get_all_pants();
	if(isset($_SESSION['sess_id'])){
		$count_cart_items = $cart->count_cart_items();
	} else {
		$count_cart_items = 0;
	}
	if($count_cart_items > 0){
		$get_cart_items = $cart->get_cart_items();
	}
    print_r($_SESSION);
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
  <link rel="icon" href="../assets/images/favicon.png" type="image/png">
  <link type="text/css" rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="wrapper">
  <?php include_once ('../header-menu.php'); ?>
  <div class="landing-heading">
    <img src="../assets/images/men-jeans-heading.jpg" alt="jeans manufacturers">
    <div class="main">
      <div class="text-area">
        <h1>Jeans Manufacturers</h1>
        <p>The question arise who is going to counter all those hurdles and win their customer's hearts? <br>There are many ways to be successful, have a look at some of them: </p>
      </div>
    </div>
  </div>
  <div class="main">
    <h3 class="section-heading">Wholesale Available Stock</h3>
    <ul class="men-product-list">
      <?php foreach($get_jeans_pants as $jeans_pant): ?>
      <li>
        <a href="../product-details.php?p=<?php echo $jeans_pant['p_id']; ?>" class='inner-manufacture'>
          <img src="../<?php echo $jeans_pant['image_front'];?>" alt="jeans pants">
          <span class="product-category">PK-<?php echo $jeans_pant['p_id']; ?></span>
        </a>
      </li>
      <?php endforeach; ?>
      <!-- <li>
        <a href="/men/jeans-pants.php" class='inner-manufacture'>
          <img src="../assets/images/jeans-pant-main.jpg" alt="Jeans Jackets">
          <span class="product-category">PK-10052</span>
        </a>
      </li>
      <li>
        <a href="/men/jeans-pants.php" class='inner-manufacture'>
          <img src="../assets/images/jeans-pant-main.jpg" alt="jeans shirts">
          <span class="product-category">PK-10053</span>
        </a>
      </li>
      <li>
        <a href="/men/jeans-pants.php" class='inner-manufacture'>
          <img src="../assets/images/jeans-pant-main.jpg" alt="jeans shorts">
          <span class="product-category">PK-10054</span>
        </a>
      </li>
      <li>
        <a href="/men/jeans-pants.php" class='inner-manufacture'>
          <img src="../assets/images/jeans-pant-main.jpg" alt="jeans pants">
          <span class="product-category">PK-10055</span>
        </a>
      </li>
      <li>
        <a href="/men/jeans-pants.php" class='inner-manufacture'>
          <img src="../assets/images/jeans-pant-main.jpg" alt="Jeans Jackets">
          <span class="product-category">PK-10056</span>
        </a>
      </li>
      <li>
        <a href="/men/jeans-pants.php" class='inner-manufacture'>
          <img src="../assets/images/jeans-pant-main.jpg" alt="jeans shirts">
          <span class="product-category">PK-10057</span>
        </a>
      </li>
      <li>
        <a href="/men/jeans-pants.php" class='inner-manufacture'>
          <img src="../assets/images/jeans-pant-main.jpg" alt="jeans shorts">
          <span class="product-category">PK-10058</span>
        </a>
      </li> -->
    </ul>
    <div class="main-outer">
      <h3 class="section-heading">Rating & Reviews</h3>
      <ul class="rating-wrap-outer">
        <li>
          <div class="inner-rating inner-manufacture">
            <p>We orders 500 women jackets, delivery was on time and quality was also good, we repeated our order</p>
            <div class="rating-wrap">
              <ul class="star-rating">
                <li class="star"></li>
                <li class="star"></li>
                <li class="star"></li>
                <li class="star"></li>
                <li class="star"></li>
              </ul>
              <p class="reviewer-info">
                <span class="reviewer-name">Brand Owner</span>, 
                <span class="reviewer-name">USA</span>
              </p>
            </div>
          </div>
        </li>
        <li>
          <div class="inner-rating inner-manufacture">
            <p>Pants quality was awesome but shipment was 2 weeks late, had not much good expeience but will try them again</p>
            <div class="rating-wrap">
              <ul class="star-rating">
                <li class="star"></li>
                <li class="star"></li>
              </ul>
              <p class="reviewer-info">
                <span class="reviewer-name">Wholesaler</span>, 
                <span class="reviewer-name">UK</span>
              </p>
            </div>
          </div>
        </li>
        <li>
          <div class="inner-rating inner-manufacture">
            <p>Awesome quality better than China, Pakistani jeans have real denim looks and price is also cheap, regular client of PK apparel</p>
            <div class="rating-wrap">
              <ul class="star-rating">
                <li class="star"></li>
                <li class="star"></li>
                <li class="star"></li>
                <li class="star"></li>
                <li class="star"></li>
              </ul>
              <p class="reviewer-info">
                <span class="reviewer-name">Store Owner</span>, 
                <span class="reviewer-name">Germany</span>
              </p>
            </div>
          </div>
        </li>
        <li>
          <div class="inner-rating inner-manufacture">
            <p>Communication is bit slow but overall expeience of denim quality and on time delivery is good, anyway liked them</p>
            <div class="rating-wrap">
              <ul class="star-rating">
                <li class="star"></li>
                <li class="star"></li>
                <li class="star"></li>
                <li class="star"></li>
              </ul>
              <p class="reviewer-info">
                <span class="reviewer-name">Amazon Retailer</span>, 
                <span class="reviewer-name">UK</span>
              </p>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="main-outer">
      <h3 class="section-heading">Questions - FAQs</h3>
      <ul class="faqs-list" itemscope="" itemtype="https://schema.org/FAQPage">
        <li itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
          <h3 itemprop="name">What is your MOQ for available stock?</h3>
        </li>
        <li itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
          <p itemprop="text">There is no MOQ for availabe stock, you can even buy 1 set of each style or color</p>
        </li>
        <li itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
          <h3 itemprop="name">What is your MOQ for custom order</h3>
        </li>
        <li itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
          <p itemprop="text">For custom design order our MOQ is 100 pieces per style per color</p>
        </li>
        <li itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
          <h3 itemprop="name">Do you entertain sampling requests?</h3>
        </li>
        <li itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
          <p itemprop="text">
            <strong>For availabe stock:</strong>, 
            we deliver sample of any size from loose set/bundle <br> 
            <strong>For custom orders</strong>, 
            we make sample in availabe fitting, fabric and color <br>
            custom samples are only made after order confirmation <br>
            all samples are paid, we do not provide free samples
          </p>
        </li>
        <li itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
          <h3 itemprop="name">Are you manufacturer, wholesaler or trader?</h3>
        </li>
        <li itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
          <p itemprop="text">We have our own manufacturing unit with capacity of 3000 pieces per day</p>
        </li>
        <li itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
          <h3 itemprop="name">What is your delivery time?</h3>
        </li>
        <li itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
          <p itemprop="text">Our delivery time is 3 week after order confirmation</p>
        </li>
        <li itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
          <h3 itemprop="name">What shipping modes you are working?</h3>
        </li>
        <li itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
          <p itemprop="text">Ex-factory, FOB, CIF etc</p>
        </li>
      </ul>
    </div>
    <div class="main-outer">
    <h3 class="section-heading">Other information</h3>
      <div class="landing-content">
        <div class="content-wrap">
          <div class="right">
            <img src="../assets/images/jeans-denim-cargopant-manufacturer-and-wholesaler.jpg" alt="jeans manufacturers">
          </div>
          <div class="left">
            <p>Did you know around 69% of US entrepreneurs start their business from home? The digital world is whole new, its own kind of planet where people instead of carrying out raids on their opponents’ warehouses, wage war with marketing tactics. </p>
            <p>The best one wins! </p>
            <p>Now, it should be clarified that who is the best one? What it takes to be considered best one? </p>
            <p>Jeans is one of the sub-types of apparel industry and is considered as necessary item of our wardrobe. If you are one of the <strong>Jeans Manufacturers</strong>, then you may relate to a lot of things that this article holds for you.</p>
          </div>
        </div>
        <div class="content-wrap">
          <div class="right">
            <p>We know how much important jeans is for our clothing. We wear it almost every day, at work, home, party, educational institutes and whatnot! When such thing is in so much demand, it is natural to have competition among the manufacturers. </p>
            <p>The question arise ‘who is going to counter all those hurdles and win their customers’ hearts?’ There are many ways to be successful, have a look at some of them: </p>
            <ul>
              <li>A.	Make sure the material of your jeans is pure and up-to-date. </li>
              <li>B.	Your marketing campaigns are relatable and engaging. </li>
              <li>C.	Know market trends all the time.  </li>
              <li>D.	Hire competent individuals who are passionate about their job. </li>
              <li>E.	Customer care should be available 24/7 to cater to the queries of consumers. </li>
              <li>F.	Come up with discount options and sale every now and then to attract new customers and retain the old ones. </li>
            </ul>
          </div>
          <div class="left">
            <img src="../assets/images/jeans-denim-cargopant-manufacturer-and-wholesaler.jpg" alt="jeans manufacturers">
          </div>
        </div>
        <div class="content-wrap">
          <div class="right">
            <img src="../assets/images/jeans-denim-cargopant-manufacturer-and-wholesaler.jpg" alt="jeans manufacturers">
          </div>
          <div class="left">
            <p>One thing should always stay there – put your customer first and see how quickly things changes in your favor. </p>
            <p>Where there is to-do list, there is also what not to do. </p>
            <ul>
              <li>I.	Never disrespect your customer.</li>
              <li>II.	Do not go for incompetent team. </li>
              <li>III.	Do not stray away from your goal. </li>
              <li>IV.	Do not spend too much without a proper planning.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once ('../footer.php'); ?>
</div>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-71901684-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-71901684-1');
</script>
</body>
</html>
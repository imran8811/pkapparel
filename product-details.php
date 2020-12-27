<?php
  require_once("./init.php");
	$base_url = $_SERVER['HTTP_HOST'] === 'localhost:8080'? 'http://localhost:8080/pkwebnew' : 'https://www.pkapparel.com';
  $p_id           = $_GET['p'];
	$JeansPants     = new JeansPants();
	$misc           = new Misc();
	$pro_details    = $JeansPants->get_product_details($p_id);
	$get_stock      = $JeansPants->get_stock($p_id);
//	session_destroy();
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
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
  <link type="text/css" rel="stylesheet" href="./assets/css/jquery-confirm.css">
  <link type="text/css" rel="stylesheet" href="./assets/css/style.css">
  <link type="text/css" rel="stylesheet" href="./assets/css/style-wholesale.css">
</head>
<body>
<div class="wrapper">
  <?php include_once ('./header-menu.php'); ?>
  <div class="main">
    <div class="page-details clearfix">
      <div class="crumb-area">
        <ul class="breadcrumb">
          <li><a href="<?php echo $base_url; ?>">Home</a>&nbsp;&rightarrow;</li>
          <li><a href="<?php echo $base_url; ?>">Mens</a>&nbsp;&rightarrow;</li>
          <li><a href="<?php echo $base_url; ?>">Jeans Pants</a>&nbsp;&rightarrow;</li>
          <li>Style# <?php echo $p_id; ?></li>
        </ul>
      </div>
      <?php foreach($pro_details as $details): ?>
        <div class="details-inner clearfix">
          <div class="gallery-area">
            <div class="swiper-container gallery-top">
              <div class="swiper-wrapper">
                <div class="swiper-slide" style="background-image:url(./assets/images/jeans-denim-shorts-manufacturer-and-wholesaler.jpg)"></div>
                <div class="swiper-slide" style="background-image:url(./assets/images/jeans-denim-shorts-manufacturer-and-wholesaler.jpg)"></div>
                <div class="swiper-slide" style="background-image:url(./assets/images/jeans-denim-shorts-manufacturer-and-wholesaler.jpg)"></div>
                <div class="swiper-slide" style="background-image:url(./assets/images/jeans-denim-shorts-manufacturer-and-wholesaler.jpg)"></div>
              </div>
              <!-- Add Arrows -->
              <div class="swiper-button-next swiper-button-white"></div>
              <div class="swiper-button-prev swiper-button-white"></div>
            </div>
            <div class="swiper-container gallery-thumbs">
              <div class="swiper-wrapper">
                <div class="swiper-slide" style="background-image:url(./assets/images/jeans-denim-shorts-manufacturer-and-wholesaler.jpg)"></div>
                <div class="swiper-slide" style="background-image:url(./assets/images/jeans-denim-shorts-manufacturer-and-wholesaler.jpg)"></div>
                <div class="swiper-slide" style="background-image:url(./assets/images/jeans-denim-shorts-manufacturer-and-wholesaler.jpg)"></div>
                <div class="swiper-slide" style="background-image:url(./assets/images/jeans-denim-shorts-manufacturer-and-wholesaler.jpg)"></div>
              </div>
            </div>
          </div>
            <div class="details-area">
              <div class="title-area">
                <strong class="style-no">Style#: <?php echo $details['p_id']; ?></strong>
                <strong class="color-name"><?php echo $details['colors']; ?></strong>
                <strong class="price">Rs. <span class="pro-price"> <?php echo $details['item_price']; ?></span></strong>
              </div>
              <div class="wrap clearfix">
                <div class="qty-selection">
                  <div class="left">
                    <div class="sizes-wrap">
                      <p>Sizes</p>
                      <ul class="cart-sizes">
                        <?php foreach($get_stock as $stock): ?>
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
                              for($i=$min_qty; $i < $stock['stock']+1; $i++){
                                echo "<option value=" . $i . ">" . $i .  "</option>";
                              }
                            ?>
                          </select>
                        </li>
                        <?php endforeach; ?>
                        </ul>
                      </div>
                    </div>
                      <div class="right">
                        <div class="fab-det">
                          <h3>Fabric</h3>
                          <ul>
                          <?php $fabDetails = explode(",", $details['fabric']);
                            for($i=0; $i < count($fabDetails); $i++){
                              echo "<li>$fabDetails[$i]</li>";
                            }
                          ?>
                          </ul>
                        </div>
                        <div class="wash-det">
                          <h3>Washing</h3>
                          <ul>
                            <?php $washDetails = explode(",", $details['washing']);
                            for($i=0; $i < count($washDetails); $i++){
                              echo "<li>$washDetails[$i]</li>";
                            }
                            ?>
                          </ul>
                        </div>
                      </div>
                      <div class="notice-list">
                        <div class="total-sum">Pcs = <strong class="t-pcs">0</strong></div>
                        <div class="total-sum">Amount = <strong class="t-amount">0</strong></div>
                      </div>
                    </div>
                </div>
                <div class="cart-wrap clearfix">
                  <a href="#" class="btn-submit add-cart">Add to Cart</a>
                </div>
            </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php include_once ('./footer.php'); ?>
</div>
<script src="./assets/js/jquery-3.5.1.js"></script>
<script type="text/javascript" src="./assets/js/confirm.min.js"></script>
<script type="text/javascript" src="./assets/js/modal.js"></script>
<?php include_once("./assets/js/productDetailsjs.php"); ?>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
  var galleryThumbs = new Swiper('.gallery-thumbs', {
      spaceBetween: 10,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesVisibility: true,
      watchSlidesProgress: true,
    });
  var galleryTop = new Swiper('.gallery-top', {
    spaceBetween: 10,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    thumbs: {
      swiper: galleryThumbs
    }
  });
</script>
<div id="reviews" style="display: none;">
  <ul class="review-list">
    <?php foreach($get_reviews as $review): ?>
      <li>
        <p><?php echo $review["review_text"] ?></p>
        <ul>
          <li>Ratings:</li>
          <li>User: <strong><?php echo $review["full_name"] ?></strong></li>
        </ul>
      </li>
    <?php endforeach; ?>
  </ul>
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
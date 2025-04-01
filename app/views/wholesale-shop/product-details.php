<?php
  include_once("app/views/shared/header.php");
  require_once "app/controllers/product.controller.php";
  use app\Controllers\ProductController;
  $productController = new ProductController();
  $article_no = explode("-", $name);
  $article_no = end($article_no);
  $getProductByArticleNo = $productController->getProductByArticleNo($article_no);
  // print_r($getProductByArticleNo);
  $images = ['front', 'back']
?>
<style>
  .swiper {
      width: 100%;
      height: 100%;
    }

    .swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .swiper-slide img {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .swiper {
      width: 100%;
      height: 300px;
      margin-left: auto;
      margin-right: auto;
    }

    .swiper-slide {
      background-size: cover;
      background-position: center;
    }

    .productGallery {
      height: 80%;
      width: 100%;
    }

    .productThumbs {
      height: 20%;
      box-sizing: border-box;
      padding: 10px 0;
    }

    .productThumbs .swiper-slide {
      width: 25%;
      height: 100%;
      opacity: 0.4;
    }

    .productThumbs .swiper-slide-thumb-active {
      opacity: 1;
    }

    .swiper-slide img {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
</style>
<div class="mb-5 page-content">
  <?php foreach($getProductByArticleNo as $productDetails): ?>
  <div class="mb-5">
    <nav aria-label="breadcrumb" class="mb-5 px-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/wholesale-shop">Wholesale Shop</a></li>
        <li class="breadcrumb-item text-capitalize">
          <a href="/wholesale-shop/<?php echo $productDetails['dept'] ?>"><?php echo $productDetails['dept'] ?></a>
        </li>
        <li class="breadcrumb-item text-capitalize">
          <a href="/wholesale-shop/<?php echo $productDetails['dept'] ?>/<?php echo $productDetails['category'] ?>"><?php echo $productDetails['category'] ?></a>
        </li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $productDetails['article_no'] ?></li>
      </ol>
    </nav>
    <div class="row px-3">
      <div class="col-md-6 mb-4">
        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper productGallery">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <img
                src="<?php echo '/uploads/' . $productDetails['article_no'] . '/front.jpg' ?>"
                alt="<?php echo $productDetails['product_name'] ?>"/>
            </div>
            <div class="swiper-slide">
              <img
                src="<?php echo '/uploads/' . $productDetails['article_no'] . '/back.jpg' ?>"
                alt="<?php echo $productDetails['product_name'] ?>"/>
            </div>
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
        <div thumbsSlider="" class="swiper productThumbs">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <img
                src="<?php echo '/uploads/' . $productDetails['article_no'] . '/front.jpg' ?>"
                alt="<?php echo $productDetails['product_name'] ?>"/>
            </div>
            <div class="swiper-slide">
              <img
                src="<?php echo '/uploads/' . $productDetails['article_no'] . '/back.jpg' ?>"
                alt="<?php echo $productDetails['product_name'] ?>"/>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <h1 class="mb-3 border-bottom text-capitalize"><?php echo $productDetails['product_name'] ?></h1>
        <ul class="mb-5 p-0">
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3">Article No.</span>
            <span class="col-6 col-md-8 col-lg-9"><?php echo $productDetails['article_no'] ?></span>
          </li>
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3">Fabric Details</span>
            <span class="col-6 col-md-8 col-lg-9"><?php echo $productDetails['fabric_type'].'/'.$productDetails['fabric_content']. '/' . $productDetails['fabric_weight'] ?></span>
          </li>
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3">Color(s)</span>
            <span class="col-6 col-md-8 col-lg-9 text-capitalize"><?php echo $productDetails['color'] ?></span>
          </li>
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3">Waist Sizes</span>
            <span class="col-6 col-md-8 col-lg-9"><?php echo $productDetails['p_sizes'] ?></span>
          </li>
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3">Wash Type</span>
            <span class="col-6 col-md-8 col-lg-9"><?php echo $productDetails['wash_type'] ?></span>
          </li>
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3">Category</span>
            <span class="col-6  col-md-8 col-lg-9 text-capitalize"><?php echo $productDetails['category'] ?></span>
          </li>
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3">Front Fly</span>
            <span class="col-6  col-md-8 col-lg-9 text-capitalize"><?php echo $productDetails['front_fly'] ?></span>
          </li>
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3">Delivery</span>
            <span class="col-6 col-md-8 col-lg-9">30 days</span>
          </li>
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3">MOQ</span>
            <span class="col-6 col-md-8 col-lg-9"><?php echo $productDetails['moq'] ?> Pieces</span>
          </li>
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3">Price</span>
            <span class="col-6 col-md-8 col-lg-9 text-danger">USD<?php echo $productDetails['price'] ?> Ex-W</span>
          </li>
        </ul>
        <h4 class="mb-4">Packing / Shipping</h4>
        <ul class="px-0 pb-3 mb-3 border-bottom">
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3">Weight per piece:</span>
            <span class="col-6 col-md-4 col-lg-3"><?php echo $productDetails['piece_weight'] ?>grams</span>
          </li>
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3">Packing Assortment</span>
            <span class="col-6 col-md-4 col-lg-3">Size wise</span>
          </li>
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3"></span>
            <span class="col-6 col-md-4 col-lg-3">10 pieces in Blister</span>
          </li>
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3"></span>
            <span class="col-6 col-md-4 col-lg-3">6 blister in single carton</span>
          </li>
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3">Carton Dimensions:</span>
            <span class="col-6 col-md-4 col-lg-3">24&quot; x 24&quot; x 40&quot;</span>
          </li>
          <li class="row mb-2">
            <span class="col-6 col-md-4 col-lg-3">Shipping:</span>
            <span class="col-6 col-md-4 col-lg-3">By Air/Sea</span>
          </li>
        </ul>
        <div class="add-cart-wrap d-flex justify-content-end">
          <!-- <button class="btn btn-primary" id="btnOrderNow">Order Now</Button> -->
          <a href="/login" class="btn btn-primary">Order Now </a>
        </div>
      </div>
    </div>
    <div class="modal fade" id="orderNowModal" tabindex="-1" aria-labelledby="orderNowModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="" method="post">
              <ul class="p-0">
                <li class="row mb-2">
                  <div class="col-6">
                    <input type="number" class="form-control" placeholder="Size" />
                  </div>
                  <div class="col-6">
                    <input type="number" class="col-9 form-control" placeholder="Quantity" />
                  </div>
                </li>
                <li class="row mb-2">
                  <div class="col-6">
                    <input type="number" class="form-control" placeholder="Size" />
                  </div>
                  <div class="col-6">
                    <input type="number" class="col-9 form-control" placeholder="Quantity" />
                  </div>
                </li>
                <li class="row mb-2">
                  <div class="col-6">
                    <input type="number" class="form-control" placeholder="Size" />
                  </div>
                  <div class="col-6">
                    <input type="number" class="col-9 form-control" placeholder="Quantity" />
                  </div>
                </li>
                <li class="row mb-2">
                  <div class="col-6">
                    <input type="number" class="form-control" placeholder="Size" />
                  </div>
                  <div class="col-6">
                    <input type="number" class="col-9 form-control" placeholder="Quantity" />
                  </div>
                </li>
              </ul>
              <div class="order-instructions mb-3">
                <textarea
                  rows={5}
                  placeholder="Instructions"
                  class="form-control">
                </textarea>
              </div>
              <div class="order-uploads mb-3">
                <div>
                  <small>Upload documents (custom design, measurement chart etc.) to any online storage and share a below</small>
                </div>
                <div class="col-12 mb-3">
                  <input type="text" placeholder="optional" class="form-control"/>
                </div>
              </div>
              <div class="row">
                <div class="col-12 text-center">
                  <h4>Total Amount: ${totalAmount}</h4>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Place Order</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php endforeach ?>
</div>
<?php include_once("app/views/shared/footer.php"); ?>

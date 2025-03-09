<?php
  include_once __DIR__ ."/admin-header.php";
  require_once dirname(dirname(__DIR__)) . '/controllers/product.controller.php';
  use app\Controllers\ProductController;
  $productController = new ProductController();
  $latestArticleNo = $productController->getLatestArticleNo() + 1;
  $dept             = isset($_POST['dept'])? $_POST['dept'] : '';
  $category         = isset($_POST['category'])? $_POST['category'] : '';
  $article_no       = isset($_POST['article_no'])? $_POST['article_no'] : '';
  $p_sizes          = isset($_POST['p_sizes'])? $_POST['p_sizes'] : '';
  $color            = isset($_POST['color'])? $_POST['color'] : '';
  $fitting          = isset($_POST['fitting'])? $_POST['fitting'] : '';
  $fabric_type      = isset($_POST['fabric_type'])? $_POST['fabric_type'] : '';
  $fabric_stretch   = isset($_POST['fabric_stretch'])? $_POST['fabric_stretch'] : '';
  $fabric_weight    = isset($_POST['fabric_weight'])? $_POST['fabric_weight'] : '';
  $fabric_content   = isset($_POST['fabric_content'])? $_POST['fabric_content'] : '';
  $front_fly        = isset($_POST['front_fly'])? $_POST['front_fly'] : '';
  $wash_type        = isset($_POST['wash_type'])? $_POST['wash_type'] : '';
  $moq              = isset($_POST['moq'])? $_POST['moq'] : '';
  $price            = isset($_POST['price'])? $_POST['price'] : '';
  $piece_weight     = isset($_POST['piece_weight'])? $_POST['piece_weight'] : '';
  $slug             = $dept . "-" . $color . "-" . $fabric_stretch . "-" . $category;
  $product_name     = $dept . " " . $color . " " . $fabric_stretch . " " . $category;
  $data = [
    "dept"            => $dept,
    "category"        => $category,
    "article_no"      => $article_no,
    "p_sizes"         => $p_sizes,
    "color"           => $color,
    "slug"            => $slug,
    "fitting"         => $fitting,
    "fabric_type"     => $fabric_type,
    "fabric_stretch"  => $fabric_stretch,
    "fabric_weight"   => $fabric_weight,
    "fabric_content"  => $fabric_content,
    "front_fly"       => $front_fly,
    "wash_type"       => $wash_type,
    "moq"             => $moq,
    "price"           => $price,
    "piece_weight"    => $piece_weight,
    "product_name"    => $product_name,
  ];
  if(isset($_GET['addProduct']) && !empty($_POST['price'])){
    $addProduct = $productController->addProduct($data);
    if($addProduct['type'] === 'success'){
      $uploadImages = $productController->productImgUpload($article_no);
    }
  }
?>
<div class="container-fluid mt-5 mb-5">
  <div class="row justify-content-center">
    <form action="/admin/add-product?addProduct=1" method="post" enctype="multipart/form-data">
      <div class="row mb-3">
          <?php
          if(isset($addProduct['message']))
            echo '<h2 class="text-success">Product Added Successfully</h2>';
          ?>
        <h2 class="text-center mb-5">Add Product</h2>
        <div class="col-4">
          <label for="dept">Dept.</label>
          <select id="dept" name="dept" class="select-input">
            <option value="men">Men</option>
            <option value="women">Women</option>
            <option value="boys">Boys</option>
            <option value="girls">Girls</option>
          </select>
          <?php
          if(isset($_POST['dept']) && empty($_POST['dept']))
            echo '<p class="text-danger text-small">Required</p>';
          ?>
        </div>
        <div class="col-4 mb-3">
          <label for="category">Category</label>
          <select id="category" name="category" class="select-input">
            <option value="jeans-pant">Jeans Pant</option>
            <option value="chino-pant">Chino Pant</option>
            <option value="cargo-trouser">Cargo Trouser</option>
            <option value="biker-jeans">Biker Jeans</option>
          </select>
          <?php
          if(isset($_POST['category']) && empty($_POST['category']))
            echo '<p class="text-danger text-small">Required</p>';
          ?>
        </div>
        <div class="col-4 mb-3">
          <label for="article-no">Article No.</label>
          <input type="text" id="article-no" name="article_no" value="<?php echo $latestArticleNo; ?>" class="form-control" />
        </div>
        <div class="col-4">
          <label for="sizes">Sizes</label>
          <input type="text" id="sizes" name="p_sizes" class="form-control" />
          <?php
          if(isset($_POST['p_sizes']) && empty($_POST['p_sizes']))
            echo '<p class="text-danger text-small">Required</p>';
          ?>
        </div>
        <div class="col-4 mb-3">
          <label for="color">Color</label>
          <input type="text" id="color" name="color" class="form-control" />
          <?php
          if(isset($_POST['color']) && empty($_POST['color']))
            echo '<p class="text-danger text-small">Required</p>';
          ?>
        </div>
        <div class="col-4 mb-3">
          <label for="fitting">Fitting</label>
          <select id="fitting" name="fitting" class="select-input">
            <option value="slim">Slim</option>
            <option value="straight">Straight</option>
            <option value="skinny">Skinny</option>
            <option value="regular">Regular</option>
            <option value="ankle">Ankle</option>
          </select>
          <?php
          if(isset($_POST['fitting']) && empty($_POST['fitting']))
            echo '<p class="text-danger text-small">Required</p>';
          ?>
        </div>
        <div class="col-4 mb-3">
          <label for="fabric-type">Fabric Type</label>
          <input type="text" id="fabric-type" name="fabric_type" class="form-control" />
          <?php
          if(isset($_POST['fabric_type']) && empty($_POST['fabric_type']))
            echo '<p class="text-danger text-small">Required</p>';
          ?>
        </div>
        <div class="col-4 mb-3">
          <label for="fabric-stretch">Stretchable</label>
          <select id="fabric-stretch" name="fabric_stretch" class="select-input">
            <option value="stretch">Stretch</option>
            <option value="non-stretch">Non-stretch</option>
          </select>
          <?php
          if(isset($_POST['fabric_stretch']) && empty($_POST['fabric_stretch']))
            echo '<p class="text-danger text-small">Required</p>';
          ?>
        </div>
        <div class="col-4 mb-3">
          <label for="fabric-weight">Fabric Weight</label>
          <input type="text" id="fabric-weight" name="fabric_weight" class="form-control" />
          <?php
          if(isset($_POST['fabric_weight']) && empty($_POST['fabric_weight']))
            echo '<p class="text-danger text-small">Required</p>';
          ?>
        </div>
        <div class="col-4 mb-3">
          <label for="fabric-content">Fabric Content</label>
          <input type="text" id="fabric-content" name="fabric_content" class="form-control" />
          <?php
          if(isset($_POST['fabric_content']) && empty($_POST['fabric_content']))
            echo '<p class="text-danger text-small">Required</p>';
          ?>
        </div>
        <div class="col-4 mb-3">
          <label for="front-fly">Front Fly</label>
          <select id="front-fly" name="front_fly" class="select-input">
            <option value="zipper">Zipper</option>
            <option value="button">Button</option>
          </select>
          <?php
          if(isset($_POST['front_fly']) && empty($_POST['front_fly']))
            echo '<p class="text-danger text-small">Required</p>';
          ?>
        </div>
        <div class="col-4 mb-3">
          <label for="wash-type">Wash Type</label>
          <input type="text" id="wash-type" name="wash_type" class="form-control" />
          <?php
          if(isset($_POST['wash_type']) && empty($_POST['wash_type']))
            echo '<p class="text-danger text-small">Required</p>';
          ?>
        </div>
        <div class="col-4 mb-3">
          <label for="moq">MOQ</label>
          <input type="text" id="moq" name="moq" class="form-control" />
          <?php
          if(isset($_POST['moq']) && empty($_POST['moq']))
            echo '<p class="text-danger text-small">Required</p>';
          ?>
        </div>
        <div class="col-4 mb-3">
          <label for="price">Price</label>
          <input type="text" id="price" name="price" class="form-control" />
          <?php
          if(isset($_POST['price']) && empty($_POST['price']))
            echo '<p class="text-danger text-small">Required</p>';
          ?>
        </div>
        <div class="col-4 mb-3">
          <label for="piece-weight">Weight per piece</label>
          <input type="text" id="piece-weight" name="piece_weight" class="form-control" />
          <?php
          if(isset($_POST['piece_weight']) && empty($_POST['piece_weight']))
            echo '<p class="text-danger text-small">Required</p>';
          ?>
        </div>
        <div class="col-4 mb-5">
          <label for="frontImg">Front Image</label>
          <input type="file" id="frontImg" name="frontImg" class="form-control" />
        </div>
        <div class="col-4">
          <label for="backImg">Back Image</label>
          <input type="file" id="backImg" name="backImg" class="form-control" />
        </div>
        <div class="col-4">
          <label for="other1Img">Other 1</label>
          <input type="file" id="otheriImg" name="otheriImg" class="form-control" />
        </div>
        <div class="col-4 mb-3">
          <label for="other2Img">Other 2</label>
          <input type="file" id="other2Img" name="other2Img" class="form-control" />
        </div>
        <div class="col-4">
          <label for="other3Img">Other 3</label>
          <input type="file" id="other3Img" name="other3Img" class="form-control" />
        </div>
        <div class="d-grid gap-2 pt-4">
          <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php include_once __DIR__ ."/admin-footer.php"; ?>

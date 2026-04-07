<?php
  if(!isset($_SESSION)) session_start();
  if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])){
    header("Location: /admin/login");
    exit;
  }
  include_once __DIR__ ."/admin-header.php";
  require_once dirname(dirname(__DIR__)) . '/controllers/product.controller.php';
  require_once dirname(dirname(dirname(__DIR__))) . '/app/csrf.php';
  use app\Controllers\ProductController;
  $productController = new ProductController();

  $message = '';
  $messageType = '';

  // Get product by article number from route param
  $products = $productController->getProductByArticleNo($articleNo);
  if(empty($products)){
    echo '<div class="container mt-5"><h3 class="text-danger">Product not found</h3><a href="/admin/products" class="btn btn-primary mt-3">Back to Products</a></div>';
    include_once __DIR__ ."/admin-footer.php";
    exit();
  }
  $product = $products[0];

  // Handle form submission
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!csrf_verify()){
      $message = 'Invalid form submission, please try again.';
      $messageType = 'danger';
    } else {
      $dept           = trim($_POST['dept'] ?? '');
      $category       = trim($_POST['category'] ?? '');
      $p_sizes        = trim($_POST['p_sizes'] ?? '');
      $color          = trim($_POST['color'] ?? '');
      $fitting        = trim($_POST['fitting'] ?? '');
      $fabric_type    = trim($_POST['fabric_type'] ?? '');
      $fabric_stretch = trim($_POST['fabric_stretch'] ?? '');
      $fabric_weight  = trim($_POST['fabric_weight'] ?? '');
      $fabric_content = trim($_POST['fabric_content'] ?? '');
      $front_fly      = trim($_POST['front_fly'] ?? '');
      $wash_type      = trim($_POST['wash_type'] ?? '');
      $moq            = trim($_POST['moq'] ?? '');
      $price          = trim($_POST['price'] ?? '');
      $piece_weight   = trim($_POST['piece_weight'] ?? '');
      $product_name   = trim($_POST['product_name'] ?? '');
      $slug           = $dept . "-" . $color . "-" . $fabric_stretch . "-" . $category;

      $data = [
        ':price'           => $price,
        ':dept'            => $dept,
        ':category'        => $category,
        ':slug'            => $slug,
        ':p_sizes'         => $p_sizes,
        ':fitting'         => $fitting,
        ':fabric_type'     => $fabric_type,
        ':fabric_stretch'  => $fabric_stretch,
        ':fabric_content'  => $fabric_content,
        ':fabric_weight'   => $fabric_weight,
        ':front_fly'       => $front_fly,
        ':wash_type'       => $wash_type,
        ':moq'             => $moq,
        ':piece_weight'    => $piece_weight,
        ':color'           => $color,
        ':product_name'    => $product_name,
      ];

      $result = $productController->updateProduct($data, $articleNo);

      // Handle image uploads if any files were selected
      $hasFiles = false;
      foreach($_FILES as $file){
        if(!empty($file['tmp_name'])) { $hasFiles = true; break; }
      }
      if($hasFiles){
        $productController->productImgUpload($articleNo);
      }

      if($result['type'] === 'success'){
        $message = 'Product updated successfully';
        $messageType = 'success';
        // Refresh product data
        $products = $productController->getProductByArticleNo($articleNo);
        $product = $products[0];
      } else {
        $message = $result['message'];
        $messageType = 'danger';
      }
    }
  }
?>
<div class="container-fluid mt-5 mb-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-edit me-2"></i>Edit Product</h2>
        <a href="/admin/products" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back to Products</a>
      </div>

      <?php if($message): ?>
        <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
          <?php echo htmlspecialchars($message); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Current Images -->
      <div class="card mb-4">
        <div class="card-header"><strong>Current Images</strong></div>
        <div class="card-body d-flex flex-wrap gap-3">
          <?php
            $imgDir = dirname(dirname(dirname(__DIR__))) . '/uploads/' . $product['article_no'];
            if(is_dir($imgDir)){
              $images = array_diff(scandir($imgDir), ['.', '..']);
              foreach($images as $img):
          ?>
            <div class="text-center">
              <img src="/uploads/<?php echo htmlspecialchars($product['article_no'] . '/' . $img); ?>"
                   alt="<?php echo htmlspecialchars($img); ?>"
                   style="width:120px;height:120px;object-fit:cover;border-radius:4px;border:1px solid #ddd;" />
              <small class="d-block mt-1 text-muted"><?php echo htmlspecialchars($img); ?></small>
            </div>
          <?php endforeach; } else { ?>
            <p class="text-muted">No images found</p>
          <?php } ?>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <form action="/admin/edit-product/<?php echo htmlspecialchars($articleNo); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row mb-3">
              <div class="col-4 mb-3">
                <label for="dept">Dept.</label>
                <select id="dept" name="dept" class="select-input">
                  <option value="men" <?php echo $product['dept'] === 'men' ? 'selected' : ''; ?>>Men</option>
                  <option value="women" <?php echo $product['dept'] === 'women' ? 'selected' : ''; ?>>Women</option>
                  <option value="boys" <?php echo $product['dept'] === 'boys' ? 'selected' : ''; ?>>Boys</option>
                  <option value="girls" <?php echo $product['dept'] === 'girls' ? 'selected' : ''; ?>>Girls</option>
                </select>
              </div>
              <div class="col-4 mb-3">
                <label for="category">Category</label>
                <select id="category" name="category" class="select-input">
                  <option value="jeans-pant" <?php echo $product['category'] === 'jeans-pant' ? 'selected' : ''; ?>>Jeans Pant</option>
                  <option value="chino-pant" <?php echo $product['category'] === 'chino-pant' ? 'selected' : ''; ?>>Chino Pant</option>
                  <option value="cargo-trouser" <?php echo $product['category'] === 'cargo-trouser' ? 'selected' : ''; ?>>Cargo Trouser</option>
                  <option value="biker-jeans" <?php echo $product['category'] === 'biker-jeans' ? 'selected' : ''; ?>>Biker Jeans</option>
                  <option value="maxy" <?php echo $product['category'] === 'maxy' ? 'selected' : ''; ?>>Maxy</option>
                </select>
              </div>
              <div class="col-4 mb-3">
                <label for="article-no">Article No.</label>
                <input type="text" id="article-no" value="<?php echo htmlspecialchars($product['article_no']); ?>" class="form-control" disabled />
              </div>
              <div class="col-4 mb-3">
                <label for="product-name">Product Name</label>
                <input type="text" id="product-name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" class="form-control" />
              </div>
              <div class="col-4 mb-3">
                <label for="sizes">Sizes</label>
                <input type="text" id="sizes" name="p_sizes" value="<?php echo htmlspecialchars($product['p_sizes']); ?>" class="form-control" />
              </div>
              <div class="col-4 mb-3">
                <label for="color">Color</label>
                <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($product['color']); ?>" class="form-control" />
              </div>
              <div class="col-4 mb-3">
                <label for="fitting">Fitting</label>
                <select id="fitting" name="fitting" class="select-input">
                  <option value="slim" <?php echo $product['fitting'] === 'slim' ? 'selected' : ''; ?>>Slim</option>
                  <option value="straight" <?php echo $product['fitting'] === 'straight' ? 'selected' : ''; ?>>Straight</option>
                  <option value="skinny" <?php echo $product['fitting'] === 'skinny' ? 'selected' : ''; ?>>Skinny</option>
                  <option value="regular" <?php echo $product['fitting'] === 'regular' ? 'selected' : ''; ?>>Regular</option>
                  <option value="ankle" <?php echo $product['fitting'] === 'ankle' ? 'selected' : ''; ?>>Ankle</option>
                  <option value="baggy" <?php echo $product['fitting'] === 'baggy' ? 'selected' : ''; ?>>Baggy</option>
                </select>
              </div>
              <div class="col-4 mb-3">
                <label for="fabric-type">Fabric Type</label>
                <input type="text" id="fabric-type" name="fabric_type" value="<?php echo htmlspecialchars($product['fabric_type']); ?>" class="form-control" />
              </div>
              <div class="col-4 mb-3">
                <label for="fabric-stretch">Stretchable</label>
                <select id="fabric-stretch" name="fabric_stretch" class="select-input">
                  <option value="stretch" <?php echo $product['fabric_stretch'] === 'stretch' ? 'selected' : ''; ?>>Stretch</option>
                  <option value="non-stretch" <?php echo $product['fabric_stretch'] === 'non-stretch' ? 'selected' : ''; ?>>Non-stretch</option>
                </select>
              </div>
              <div class="col-4 mb-3">
                <label for="fabric-weight">Fabric Weight</label>
                <input type="text" id="fabric-weight" name="fabric_weight" value="<?php echo htmlspecialchars($product['fabric_weight']); ?>" class="form-control" />
              </div>
              <div class="col-4 mb-3">
                <label for="fabric-content">Fabric Content</label>
                <input type="text" id="fabric-content" name="fabric_content" value="<?php echo htmlspecialchars($product['fabric_content']); ?>" class="form-control" />
              </div>
              <div class="col-4 mb-3">
                <label for="front-fly">Front Fly</label>
                <select id="front-fly" name="front_fly" class="select-input">
                  <option value="zipper" <?php echo $product['front_fly'] === 'zipper' ? 'selected' : ''; ?>>Zipper</option>
                  <option value="button" <?php echo $product['front_fly'] === 'button' ? 'selected' : ''; ?>>Button</option>
                </select>
              </div>
              <div class="col-4 mb-3">
                <label for="wash-type">Wash Type</label>
                <input type="text" id="wash-type" name="wash_type" value="<?php echo htmlspecialchars($product['wash_type']); ?>" class="form-control" />
              </div>
              <div class="col-4 mb-3">
                <label for="moq">MOQ</label>
                <input type="text" id="moq" name="moq" value="<?php echo htmlspecialchars($product['moq']); ?>" class="form-control" />
              </div>
              <div class="col-4 mb-3">
                <label for="price">Price</label>
                <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" class="form-control" />
              </div>
              <div class="col-4 mb-3">
                <label for="piece-weight">Weight per piece</label>
                <input type="text" id="piece-weight" name="piece_weight" value="<?php echo htmlspecialchars($product['piece_weight']); ?>" class="form-control" />
              </div>

              <!-- Image uploads to replace existing -->
              <h5 class="mt-4 mb-3">Upload New Images <small class="text-muted">(leave empty to keep current)</small></h5>
              <div class="col-4 mb-3">
                <label for="frontImg">Front Image</label>
                <input type="file" id="frontImg" name="front" class="form-control" accept="image/*" />
              </div>
              <div class="col-4 mb-3">
                <label for="backImg">Back Image</label>
                <input type="file" id="backImg" name="back" class="form-control" accept="image/*" />
              </div>
              <div class="col-4 mb-3">
                <label for="other1Img">Other 1</label>
                <input type="file" id="other1Img" name="other1" class="form-control" accept="image/*" />
              </div>
              <div class="col-4 mb-3">
                <label for="other2Img">Other 2</label>
                <input type="file" id="other2Img" name="other2" class="form-control" accept="image/*" />
              </div>
              <div class="col-4 mb-3">
                <label for="other3Img">Other 3</label>
                <input type="file" id="other3Img" name="other3" class="form-control" accept="image/*" />
              </div>

              <div class="d-grid gap-2 pt-4">
                <button type="submit" class="btn btn-primary btn-block">Update Product</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once __DIR__ ."/admin-footer.php"; ?>

<?php
  if(!isset($_SESSION)) session_start();
  if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])){
    header("Location: /admin/login");
    exit;
  }
  include_once("app/views/admin/admin-header.php");
  require_once("app/controllers/product.controller.php");
  use app\Controllers\ProductController;
  $productController = new ProductController();

  $message = '';
  $messageType = '';

  // Handle delete
  if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
    $deleteId = intval($_GET['delete']);
    $deleted = $productController->deleteProduct($deleteId);
    if($deleted){
      $message = 'Product deleted successfully';
      $messageType = 'success';
    } else {
      $message = 'Failed to delete product';
      $messageType = 'danger';
    }
  }

  // Handle duplicate
  if(isset($_GET['duplicate']) && is_numeric($_GET['duplicate'])){
    $duplicateArticle = intval($_GET['duplicate']);
    $duplicated = $productController->duplicateProduct($duplicateArticle);
    if($duplicated['type'] === 'success'){
      $message = 'Product duplicated successfully (New Article: ' . htmlspecialchars($duplicated['new_article_no']) . ')';
      $messageType = 'success';
    } else {
      $message = 'Failed to duplicate product';
      $messageType = 'danger';
    }
  }

  $getProducts = $productController->getAllProducts();
?>
<div class="container-fluid mt-5 mb-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-boxes me-2"></i>Manage Products</h2>
    <a href="/admin/add-product" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Add Product</a>
  </div>

  <?php if($message): ?>
    <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
      <?php echo $message; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if(count($getProducts) > 0): ?>
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Image</th>
          <th>Product Name</th>
          <th>Article No</th>
          <th>Price</th>
          <th>Dept</th>
          <th>Category</th>
          <th>Color</th>
          <th>Fabric</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($getProducts as $i => $product): ?>
        <tr>
          <td><?php echo $i + 1; ?></td>
          <td>
            <img
              src="/uploads/<?php echo htmlspecialchars($product['article_no']); ?>/front.jpg"
              alt="<?php echo htmlspecialchars($product['product_name']); ?>"
              class="product-thumb"
              style="width:60px;height:60px;object-fit:cover;cursor:pointer;border-radius:4px;"
              onclick="showImageModal(this.src, '<?php echo htmlspecialchars($product['product_name']); ?>')"
              onerror="this.src='/public/images/jeans-denim-shorts-manufacturer-and-wholesaler.jfif'"
            />
          </td>
          <td class="text-capitalize"><?php echo htmlspecialchars($product['product_name']); ?></td>
          <td><?php echo htmlspecialchars($product['article_no']); ?></td>
          <td><?php echo htmlspecialchars($product['price']); ?></td>
          <td class="text-capitalize"><?php echo htmlspecialchars($product['dept']); ?></td>
          <td class="text-capitalize"><?php echo htmlspecialchars($product['category']); ?></td>
          <td class="text-capitalize"><?php echo htmlspecialchars($product['color']); ?></td>
          <td><?php echo htmlspecialchars($product['fabric_stretch'] . ' / ' . $product['fabric_weight']); ?></td>
          <td class="text-center" style="white-space:nowrap;">
            <a href="/admin/edit-product/<?php echo $product['article_no']; ?>" class="btn btn-sm btn-outline-primary me-1" title="Edit">
              <i class="fas fa-edit"></i>
            </a>
            <a href="/admin/products?duplicate=<?php echo $product['article_no']; ?>" class="btn btn-sm btn-outline-info me-1" title="Duplicate" onclick="return confirm('Duplicate this product?')">
              <i class="fas fa-copy"></i>
            </a>
            <a href="/admin/products?delete=<?php echo $product['p_id']; ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this product?')">
              <i class="fas fa-trash"></i>
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <p class="text-muted">Total products: <?php echo count($getProducts); ?></p>
  <?php else: ?>
    <div class="text-center mt-5">
      <h4 class="text-danger">No products found</h4>
    </div>
  <?php endif; ?>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Product Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modalImage" src="" alt="Product Image" class="img-fluid" style="max-height:70vh;" />
      </div>
    </div>
  </div>
</div>

<script>
function showImageModal(src, title) {
  document.getElementById('modalImage').src = src;
  document.getElementById('imageModalLabel').textContent = title || 'Product Image';
  var modal = new bootstrap.Modal(document.getElementById('imageModal'));
  modal.show();
}
</script>

<?php include_once("app/views/admin/admin-footer.php"); ?>

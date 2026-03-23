<?php
  session_start();
  if(!isset($_SESSION['admin'])){
    header("Location: /admin/login");
    exit();
  }
  include_once("app/views/admin/admin-header.php");
  require_once("app/controllers/admin.controller.php");
  use app\Controllers\AdminController;
  $adminController = new AdminController();

  $message = '';
  $messageType = '';
  $user = $adminController->getUserById($userId);

  if(!$user){
    echo '<div class="container mt-5"><h3 class="text-danger">User not found</h3><a href="/admin/users" class="btn btn-primary mt-3">Back to Users</a></div>';
    include_once("app/views/admin/admin-footer.php");
    exit();
  }

  // Handle form submission
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = [
      'user_id'       => intval($userId),
      'business_name' => trim($_POST['business_name'] ?? ''),
      'business_type' => trim($_POST['business_type'] ?? ''),
      'user_email'    => trim($_POST['user_email'] ?? ''),
      'country_code'  => trim($_POST['country_code'] ?? ''),
      'contact_no'    => trim($_POST['contact_no'] ?? ''),
      'status'        => trim($_POST['status'] ?? 'active'),
    ];

    if(empty($data['business_name']) || empty($data['user_email'])){
      $message = 'Business name and email are required';
      $messageType = 'danger';
    } else {
      $updated = $adminController->updateUser($data);
      if($updated){
        $message = 'User updated successfully';
        $messageType = 'success';
        $user = $adminController->getUserById($userId);
      } else {
        $message = 'Failed to update user';
        $messageType = 'danger';
      }
    }
  }
?>
<div class="container mt-5 mb-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-user-edit me-2"></i>Edit User</h2>
        <a href="/admin/users" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back to Users</a>
      </div>

      <?php if($message): ?>
        <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
          <?php echo htmlspecialchars($message); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <div class="card">
        <div class="card-body">
          <form method="POST">
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label" for="business_name">Business Name *</label>
                <input type="text" class="form-control" id="business_name" name="business_name" value="<?php echo htmlspecialchars($user['business_name']); ?>" required />
              </div>
              <div class="col-md-6">
                <label class="form-label" for="business_type">Business Type</label>
                <input type="text" class="form-control" id="business_type" name="business_type" value="<?php echo htmlspecialchars($user['business_type']); ?>" />
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label" for="user_email">Email *</label>
              <input type="email" class="form-control" id="user_email" name="user_email" value="<?php echo htmlspecialchars($user['user_email']); ?>" required />
            </div>
            <div class="row mb-3">
              <div class="col-md-4">
                <label class="form-label" for="country_code">Country Code</label>
                <input type="text" class="form-control" id="country_code" name="country_code" value="<?php echo htmlspecialchars($user['country_code']); ?>" />
              </div>
              <div class="col-md-8">
                <label class="form-label" for="contact_no">Contact No</label>
                <input type="text" class="form-control" id="contact_no" name="contact_no" value="<?php echo htmlspecialchars($user['contact_no']); ?>" />
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label" for="status">Status</label>
              <select class="form-select" id="status" name="status">
                <option value="active" <?php echo $user['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?php echo $user['status'] !== 'active' ? 'selected' : ''; ?>>Inactive</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label text-muted">Joined: <?php echo htmlspecialchars($user['joined_at']); ?></label>
            </div>
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Changes</button>
              <a href="/admin/users" class="btn btn-outline-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once("app/views/admin/admin-footer.php"); ?>

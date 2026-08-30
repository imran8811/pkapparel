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

  // Handle delete
  if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
    $deleteId = intval($_GET['delete']);
    $deleted = $adminController->deleteUser($deleteId);
    if($deleted){
      $message = 'User deleted successfully';
      $messageType = 'success';
    } else {
      $message = 'Failed to delete user';
      $messageType = 'danger';
    }
  }

  // Handle status toggle
  if(isset($_GET['toggleStatus']) && is_numeric($_GET['toggleStatus']) && isset($_GET['newStatus'])){
    $toggleId = intval($_GET['toggleStatus']);
    $newStatus = $_GET['newStatus'] === 'active' ? 'active' : 'inactive';
    $updated = $adminController->updateUserStatus($toggleId, $newStatus);
    if($updated){
      $message = 'User status updated';
      $messageType = 'success';
    } else {
      $message = 'Failed to update status';
      $messageType = 'danger';
    }
  }

  $users = $adminController->getAllUsers();
?>
<div class="container mt-5 mb-5">
  <h2 class="text-center mb-4"><i class="fas fa-users me-2"></i>Manage Users</h2>

  <?php if($message): ?>
    <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
      <?php echo htmlspecialchars($message); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if(count($users) > 0): ?>
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Business Name</th>
          <th>Type</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Joined</th>
          <th>Status</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($users as $i => $user): ?>
        <tr>
          <td><?php echo $i + 1; ?></td>
          <td><?php echo htmlspecialchars($user['business_name']); ?></td>
          <td><?php echo htmlspecialchars($user['business_type']); ?></td>
          <td><?php echo htmlspecialchars($user['user_email']); ?></td>
          <td><?php echo htmlspecialchars($user['country_code'] . ' ' . $user['contact_no']); ?></td>
          <td><?php echo htmlspecialchars($user['joined_at']); ?></td>
          <td>
            <?php if($user['status'] === 'active'): ?>
              <span class="badge bg-success">Active</span>
            <?php else: ?>
              <span class="badge bg-secondary">Inactive</span>
            <?php endif; ?>
          </td>
          <td class="text-center">
            <a href="/admin/edit-user/<?php echo $user['user_id']; ?>" class="btn btn-sm btn-outline-primary me-1" title="Edit">
              <i class="fas fa-edit"></i>
            </a>
            <?php if($user['status'] === 'active'): ?>
              <a href="/admin/users?toggleStatus=<?php echo $user['user_id']; ?>&newStatus=inactive" class="btn btn-sm btn-outline-warning me-1" title="Deactivate" onclick="return confirm('Deactivate this user?')">
                <i class="fas fa-ban"></i>
              </a>
            <?php else: ?>
              <a href="/admin/users?toggleStatus=<?php echo $user['user_id']; ?>&newStatus=active" class="btn btn-sm btn-outline-success me-1" title="Activate" onclick="return confirm('Activate this user?')">
                <i class="fas fa-check"></i>
              </a>
            <?php endif; ?>
            <a href="/admin/users?delete=<?php echo $user['user_id']; ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
              <i class="fas fa-trash"></i>
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <p class="text-muted">Total users: <?php echo count($users); ?></p>
  <?php else: ?>
    <div class="text-center mt-5">
      <h4 class="text-danger">No users found</h4>
    </div>
  <?php endif; ?>
</div>

<?php include_once("app/views/admin/admin-footer.php"); ?>

<?php
  include_once("app/views/shared/header.php");
  require_once dirname(dirname(__DIR__)) . '/controllers/auth.controller.php';
  require_once dirname(dirname(dirname(__DIR__))) . '/app/csrf.php';
  use app\Controllers\AuthController;
  $authController = new AuthController();

  $linkToken = $_GET['token'] ?? null;
  $linkExpired = false;
  $resetPasswordSuccess = false;
  $resetError = '';

  if($linkToken) {
    $checkLinkValidity = $authController->linkValidity($linkToken);
    if($checkLinkValidity['type'] === 'success') {
      $user_password = isset($_POST['user_password'])? $_POST['user_password'] : '';
      $confirm_password = isset($_POST['confirm_password'])? $_POST['confirm_password'] : '';
      if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($user_password)){
        if(!csrf_verify()){
          $resetError = 'Invalid form submission, please try again.';
        } elseif($user_password !== $confirm_password){
          $resetError = 'Passwords do not match.';
        } elseif(strlen($user_password) < 8 || !preg_match('/[A-Za-z]/', $user_password) || !preg_match('/[0-9]/', $user_password)){
          $resetError = 'Password must be at least 8 characters with letters and numbers.';
        } else {
          $data = [
            "user_email"    => $checkLinkValidity['user_email'],
            "user_password" => $user_password
          ];
          $resetPassword = $authController->resetPassword($data);
          if($resetPassword['type'] === 'success'){
            $resetPasswordSuccess = true;
          } else {
            $resetError = $resetPassword['message'];
          }
        }
      }
    } else {
      $linkExpired = true;
    }
  } else {
    $linkExpired = true;
  }

?>
<div class="page-content">
  <div class="row justify-content-center px-3">
    <h2 class="mb-4 text-center">Reset Password</h2>
    <?php
      if($linkExpired)
      echo '<div class="mb-3 text-center">
        <p class="text-danger">Reset password link expired / invalid link.</p>
      </div>';
    ?>
    <?php
      if($resetPasswordSuccess)
      echo '<div class="mb-3 text-center">
        <p><strong class="text-success">Password has been reset, <a href="/login">login now</a></strong></p>
      </div>';
    ?>
    <?php if(!empty($resetError)): ?>
      <div class="mb-3 text-center">
        <p class="text-danger"><?php echo htmlspecialchars($resetError); ?></p>
      </div>
    <?php endif; ?>

    <?php if(!$linkExpired && !$resetPasswordSuccess): ?>
    <form class="col-lg-5 col-md-6 col-12" method="post" action="/reset-password?token=<?php echo htmlspecialchars($linkToken); ?>">
      <?php echo csrf_field(); ?>
      <div class="mb-4">
        <input type="password" placeholder="Password" name="user_password" class="form-control" />
      </div>
      <div class="mb-4">
        <input type="password" placeholder="Confirm Password" name="confirm_password" class="form-control" />
      </div>
      <div class="row mb-3">
        <div class="col-12 text-end">
          <button type="submit" class="btn btn-primary col-4">Submit</button>
        </div>
      </div>
    </form>
    <?php endif; ?>
  </div>
</div>
<?php include_once("app/views/shared/footer.php"); ?>

<?php
  include_once("app/views/shared/header.php");
  require_once dirname(dirname(__DIR__)) . '/controllers/auth.controller.php';
  use app\Controllers\AuthController;
  $authController = new AuthController();

  $linkToken = isset($_GET['token']);
  $checkLinkValidity = $authController->linkValidity($linkToken);
  if($checkLinkValidity) {
    $user_password = isset($_POST['user_password'])? $_POST['user_password'] : '';
    if(isset($_GET['resetPassword']) && isset($user_password) && !empty($user_password)){
      $data = [
        "user_password" => $user_password
      ];
      $resetPassword = $authController->resetPassword($data);
      if(isset($resetPassword['type']) === 'success'){
        $_POST['resetPasswordSuccess'] = true;
      }
    }
  }else {
    $_POST['linkExpired'] = true;
  }

?>
<div class="page-content">
  <div class="row justify-content-center px-3">
    <h2 class="mb-4 text-center">Reset Password</h2>
    <?php
      if(isset($_POST['linkExpired']))
        echo '<div class="mb-3 text-center">
          <p class="text-danger">Reset password link expired / invalid link.</p>
        </div>';
    ?>
    <?php
      if(isset($_POST['resetPasswordSuccess']))
      echo '<div class="mb-3 text-center">
        <p><strong class="text-success">Password has been reset, <a href="/login">login now</a></strong></p>
      </div>';
    ?>

    <form class="col-lg-5 col-md-6 col-12" method="post" action="/reset-password?resetPassword=1">
      <div class="mb-4">
        <input type="password" placeholder="Password" name="user_password" class="form-control" />
      </div>
      <div class="mb-4">
        <input type="password" placeholder="Confirm Password" class="form-control" />
        <!-- <span class="text-small text-danger">Confirm password mismatch</span> -->
      </div>
      <div class="row mb-3">
        <div class="col-12 text-end">
          <button type="submit" class="btn btn-primary col-4">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php include_once("app/views/shared/footer.php"); ?>

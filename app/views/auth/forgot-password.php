<?php
  include_once("app/views/shared/header.php");
  require_once dirname(dirname(__DIR__)) . '/controllers/auth.controller.php';
  require_once dirname(dirname(dirname(__DIR__))) . '/app/csrf.php';
  use app\Controllers\AuthController;
  $authController = new AuthController();

  $user_email = isset($_POST['user_email'])? trim(strtolower($_POST['user_email'])) : '';

  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($user_email) && !empty($user_email)){
    if(!csrf_verify()){
      $_POST['formError'] = 'Invalid form submission, please try again.';
    } elseif(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
      $_POST['formError'] = 'Please enter a valid email address.';
    } else {
      $data = [
        "user_email" => $user_email,
      ];
      $forgotPassword = $authController->forgotPassword($data);
      if($forgotPassword['type'] === 'error'){
        $_POST['userNotFound'] = true;
      } else {
        $_POST['emailSent'] = true;
      }
    }
  }
?>
<div class='page-content'>
  <div class='row justify-content-center px-3'>
    <h2 class='mb-4 text-center'>Forgot Password</h2>
    <?php
      if(isset($_POST['formError']))
        echo '<div class="mb-3 text-center">
          <p class="text-danger">'.htmlspecialchars($_POST['formError']).'</p>
        </div>';
    ?>
    <?php
      if(isset($_POST['userNotFound']))
        echo '<div class="mb-3 text-center">
          <p class="text-danger">User doesn&apos;t Exist!</p>
        </div>';
    ?>
    <?php
      if(isset($_POST['emailSent']))
        echo '<div class="mb-3 text-center">
        <p class="text-success"><strong>Password reset email sent, check your inbox.</strong></p>
      </div>';
    ?>
    <form class="col-lg-5 col-md-6 col-12" method="post" action="/forgot-password">
      <?php echo csrf_field(); ?>
      <div class="mb-4">
        <input type="email" placeholder="Enter email" name="user_email" class="form-control" required maxlength="254" />
        <?php
          if(isset($_POST['user_email']) && empty($_POST['user_email']))
            echo '<p class="text-danger text-small">Required</p>';
        ?>
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

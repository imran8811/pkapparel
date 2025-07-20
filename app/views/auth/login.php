<?php
  include_once("app/views/shared/header.php");
  require_once dirname(dirname(__DIR__)) . '/controllers/auth.controller.php';
  use app\Controllers\AuthController;
  $authController = new AuthController();

  $user_email = isset($_POST['user_email'])? $_POST['user_email'] : '';
  $user_password = isset($_POST['user_password'])? $_POST['user_password'] : '';

  if(isset($_GET['userLogin']) && isset($user_email) && !empty($user_email) && isset($user_password) && !empty($user_password)){
    $data = [
      "user_email" => $user_email,
      "user_password" => $user_password
    ];
    $userLogin = $authController->login($data);
    if($userLogin['type'] === 'error'){
      $_POST['invalidCredentials'] = true;
    } else {
      session_start();
      $_SESSION['user'] = $userLogin['data']['token'];
      header("Location: /shop");
    }
  }
?>
<div class="page-content">
  <div class="row justify-content-center px-3">
    <h2 class="mb-4 text-center">User Login</h2>
    <?php
      if(isset($_POST['invalidCredentials']))
        echo '<div class="mb-3 text-center">
          <p class="text-danger">Invalid Username/Password</p>
        </div>';
    ?>
    <form class="col-lg-5 col-md-6 col-12" method="post" action="/login?userLogin=1">
      <div class="mb-4">
        <input type="text" placeholder="Email" name="user_email" class="form-control" />
        <?php
          if(isset($_POST['user_email']) && empty($_POST['user_email']))
            echo '<p class="text-danger text-small">Required</p>';
        ?>
      </div>
      <div class="mb-4">
        <input type="password" placeholder="Password" name="user_password" class="form-control" />
        <?php
          if(isset($_POST['user_password']) && empty($_POST['user_password']))
            echo '<p class="text-danger text-small">Required</p>';
        ?>
      </div>
      <div class="row mb-3">
        <div class="col-8">
          <a href="/forgot-password" class="btn-a mb-2">Forgot Password</a>
          <span class="divider px-2">|</span>
          <a href="/signup" class="btn-a">Sign up</a>
        </div>
        <div class="col-4 text-end">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php include_once("app/views/shared/footer.php"); ?>

<?php
  session_start();
  if(isset($_SESSION['user']) && $_SESSION['user'] !== ''){
    header("Location: /wholesale-shop");
    exit;
  }
  require_once dirname(dirname(__DIR__)) . '/controllers/auth.controller.php';
  use app\Controllers\AuthController;
  $authController = new AuthController();

  $user_email    = isset($_POST['user_email']) ? trim($_POST['user_email']) : '';
  $user_password = isset($_POST['user_password']) ? $_POST['user_password'] : '';

  $errors = [];
  $loginError = '';
  $newUser = isset($_GET['newUser']) && $_GET['newUser'] == '1';

  if(isset($_GET['userLogin'])){
    // Validate email
    if(empty($user_email)){
      $errors['user_email'] = 'Email is required';
    } elseif(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
      $errors['user_email'] = 'Please enter a valid email address';
    }

    // Validate password
    if(empty($user_password)){
      $errors['user_password'] = 'Password is required';
    }

    if(empty($errors)){
      $data = [
        "user_email"    => $user_email,
        "user_password" => $user_password,
      ];
      $userLogin = $authController->login($data);
      if($userLogin['type'] === 'success'){
        $_SESSION['user'] = $userLogin['data']['token'];
        $_SESSION['user_email'] = $userLogin['data']['user_email'];
        $_SESSION['business_name'] = $userLogin['data']['business_name'];
        header("Location: /wholesale-shop");
        exit;
      } else {
        $loginError = 'Invalid email or password';
      }
    }
  }

  include_once("app/views/shared/header.php");
?>
<div class="page-content">
  <div class="row justify-content-center px-3">
    <h2 class="text-center mb-4">Login</h2>
    <?php if($newUser): ?>
      <div class="mb-3 text-center">
        <p class="text-success"><strong>Registration successful! Please login.</strong></p>
      </div>
    <?php endif; ?>
    <?php if(!empty($loginError)): ?>
      <div class="mb-3 text-center">
        <p class="text-danger"><?php echo htmlspecialchars($loginError); ?></p>
        <p><a href="/forgot-password">Forgot Password?</a></p>
      </div>
    <?php endif; ?>
    <form class="col-lg-5 col-md-6 col-12" method="post" action="/login?userLogin=1" novalidate>
      <div class="mb-4">
        <label for="user-email">Email*</label>
        <input type="email" id="user-email" name="user_email" class="form-control" value="<?php echo htmlspecialchars($user_email); ?>" />
        <?php if(isset($errors['user_email'])): ?>
          <p class="text-danger text-small"><?php echo htmlspecialchars($errors['user_email']); ?></p>
        <?php endif; ?>
      </div>
      <div class="mb-4">
        <label for="user-password">Password*</label>
        <input type="password" id="user-password" name="user_password" class="form-control" />
        <?php if(isset($errors['user_password'])): ?>
          <p class="text-danger text-small"><?php echo htmlspecialchars($errors['user_password']); ?></p>
        <?php endif; ?>
      </div>
      <div class="d-flex mb-3">
        <div class="col-6">
          <a href="/signup" class="btn-a">Signup</a>
        </div>
        <div class="col-6 text-end">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </div>
      <div class="text-center mt-3">
        <a href="/forgot-password">Forgot Password?</a>
      </div>
    </form>
  </div>
</div>
<?php include_once("app/views/shared/footer.php"); ?>

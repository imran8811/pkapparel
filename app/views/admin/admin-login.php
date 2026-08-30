<?php
  session_start();
  require_once dirname(dirname(__DIR__)) . '/controllers/admin.controller.php';
  require_once dirname(dirname(dirname(__DIR__))) . '/app/csrf.php';
  use app\Controllers\AdminController;
  $adminController = new AdminController();
  $email = isset($_POST['email'])? trim(strtolower($_POST['email'])) : '';
  $password = isset($_POST['password'])? $_POST['password'] : '';
  $loginError = '';
  if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($email) && !empty($password)){
    if(!csrf_verify()){
      $loginError = 'Invalid form submission, please try again.';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $loginError = 'Please enter a valid email address.';
    } else {
      $userLogin = $adminController->login($email, $password);
      if($userLogin['status'] === 'success'){
        $_SESSION['admin'] = $userLogin['data']['email'];
        header("Location: /admin/add-product");
        exit;
      } else {
        $loginError = 'Invalid email or password';
      }
    }
  }
  include_once __DIR__ ."/admin-header.php";
?>
<div class='container mt-5 mb-5'>
  <div class='row justify-content-center'>
    <h2 class='text-center mb-3'>Admin Login</h2>
    <?php if(!empty($loginError)): ?>
      <p class="text-danger text-center"><?php echo htmlspecialchars($loginError); ?></p>
    <?php endif; ?>
    <form action="/admin/login" method="post" class='col-lg-4 col-md-6 col-12'>
      <?php echo csrf_field(); ?>
      <div class='mb-3'>
        <input type="email" placeholder='Email' name="email" class='form-control' required />
      </div>
      <div class='mb-3'>
        <input type="password" placeholder='Password' name="password" class='form-control' />
      </div>
      <div class='mb-3 justify-content-end'>
        <button type="submit" class='btn btn-primary col-4'>Login</button>
      </div>
    </form>
  </div>
</div>

<?php include_once __DIR__."/admin-footer.php"; ?>

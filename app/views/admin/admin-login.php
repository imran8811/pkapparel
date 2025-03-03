<?php
  include_once __DIR__ ."/admin-header.php";
  require_once dirname(dirname(__DIR__)) . '/controllers/admin.controller.php';
  use app\Controllers\AdminController;
  $adminController = new AdminController();
  $email = $_POST['email'];
  $password = $_POST['password'];
  if(isset($_GET['userLogin']) && isset($email) && !empty($email) && isset($password) && !empty($password)){
    $userLogin = $adminController->login($email, $password);
    if($userLogin['status'] === 'success'){
      session_start();
      $_SESSION['admin'] = $userLogin['data']['email'];
      header("Location: /admin/add-product");
    }
  }
?>
<div class='col-lg-12 mt-5 mb-5'>
  <div class='row justify-content-center'>
    <h2 class='text-center mb-3'>Admin Login</h2>
    <?php
      if(isset($_POST['email']) && empty($_POST['email']))
        echo '<p class="text-danger text-small">Invalid Email/Password</p>';
    ?>
    <form action="/admin/login?userLogin=1" method="post" class='col-lg-4 col-md-6 col-12'>
      <div class='mb-3'>
        <input type="text" placeholder='Email' name="email" class='form-control' />
        <?php
          if(isset($_POST['email']) && empty($_POST['email']))
            echo '<p class="text-danger text-small">Email Required</p>';
        ?>
      </div>
      <div class='mb-3'>
        <input type="password" placeholder='Password' name="password" class='form-control' />
        <?php
          if(isset($_POST['password']) && empty($_POST['password']))
            echo '<p class="text-danger text-small">Password Required</p>';
        ?>
      </div>
      <div class='mb-3'>
        <button type="submit" class='btn btn-primary col-4'>Login</button>
      </div>
    </form>
  </div>
</div>

<?php include_once __DIR__."/admin-footer.php"; ?>

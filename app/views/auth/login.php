<?php include_once("app/views/shared/header.php"); ?>
<div class='page-content'>
  <div class='row justify-content-center px-3'>
    <h2 class='mb-4 text-center'>User Login</h2>
    <div class='mb-3 text-center'>
      <p class='text-danger'>Invalid Username/Password</p>
    </div>
    <form class='col-lg-5 col-md-6 col-12'>
      <div class='mb-4'>
        <input type="text" placeholder='Email' class='form-control' />
      </div>
      <div class='mb-4'>
        <input type="password" placeholder='Password' class='form-control' />
      </div>
      <div class='row mb-3'>
        <div class='col-8'>
          <a href="/forgot-password" class='btn-a mb-2'>Forgot Password</a>
          <span class='divider px-2'>|</span>
          <a href="/signup" class='btn-a'>Sign up</a>
        </div>
        <div class='col-4 text-end'>
          <button type="submit" class='btn btn-primary'>Login</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php include_once("app/views/shared/footer.php"); ?>

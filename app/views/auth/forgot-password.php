<?php include_once("app/views/shared/header.php"); ?>
<div class='page-content'>
  <div class='row justify-content-center px-3'>
    <h2 class='mb-4 text-center'>Forgot Password</h2>
    <div class='mb-3 text-center'>
      <p class='text-danger'>User doesn&apos;t Exist!</p>
    </div>
    <div class='mb-3 text-center'>
      <p class='text-success'><strong>Password reset email sent, check your inbox.</strong></p>
    </div>
    <form class='col-lg-5 col-md-6 col-12'>
      <div class='mb-4'>
        <input type="text" placeholder='Enter email' class='form-control' />
      </div>
      <div class='row mb-3'>
        <div class='col-12 text-end'>
          <button type="submit" class='btn btn-primary col-4'>Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php include_once("app/views/shared/footer.php"); ?>

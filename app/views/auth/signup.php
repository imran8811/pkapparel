<?php include_once("app/views/shared/header.php"); ?>
<div class='page-content'>
  <div class='row justify-content-center px-3'>
    <h2 class='text-center mb-4'>Business Registration</h2>
    <div class='mb-3 text-center'>
      <p class='text-danger'>User already Exists</p>
      <p>Try <a href="/login">Login</a> or <a href="/forgot-password">Forgot Password</a></p>
    </div>
    <form class='col-lg-5 col-md-6 col-12'>
      <div class='mb-4'>
        <input type="text" placeholder='Business Name' class='form-control' />
      </div>
      <div class='mb-4'>
        <select class='select-input'>
          <option value=''>Business Type</option>
          <option value='retailer'>Retailer</option>
          <option value='wholesaler'>Wholesaler</option>
        </select>
      </div>
      <div class='mb-4'>
        <input type="text" placeholder='Email' class='form-control' />
      </div>
      <div class='mb-4'>
        <input type="password" placeholder='Password' class='form-control' />
      </div>
      <div class='mb-4'>
        <input type="password" placeholder='Confirm Password' class='form-control' />
          <span class='text-small text-danger'>Confirm password mismatch</span>
      </div>
      <div class='mb-4 pb-4 border-bottom'>
        <div class='row'>
          <div class='col-4'>
            <select class='select-input'>
              <option value={code} key={index}>{code}</option>
            </select>
          </div>
          <div class='col-8'>
            <input type="number" placeholder='Contact No' class='form-control' />
          </div>
        </div>
      </div>
      <div class='d-flex mb-3'>
        <div class='col-6'>
          <a href="/login" class='btn-a col-6'>Login</a>
        </div>
        <div class='col-6 text-end'>
          <button type="submit" class='btn btn-primary'>Signup</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php include_once("app/views/shared/footer.php"); ?>

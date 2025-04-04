<?php
  include_once("app/views/shared/header.php");
  require_once dirname(dirname(__DIR__)) . '/controllers/auth.controller.php';
  use app\Controllers\AuthController;
  $authController = new AuthController();

  $business_name  = isset($_POST['business_name'])? $_POST['business_name'] : '';
  $business_type  = isset($_POST['business_type'])? $_POST['business_type'] : '';
  $user_email     = isset($_POST['user_email'])? $_POST['user_email'] : '';
  $user_password  = isset($_POST['user_password'])? $_POST['user_password'] : '';
  $country_code   = isset($_POST['country_code'])? $_POST['country_code'] : '';
  $contact_no     = isset($_POST['contact_no'])? $_POST['contact_no'] : '';

  if(
    isset($_GET['userSignup']) &&
    isset($business_name) &&
    !empty($business_name) &&
    isset($business_type) &&
    !empty($business_type) &&
    isset($user_email) &&
    !empty($user_email) &&
    isset($user_password) &&
    !empty($user_password) &&
    isset($country_code) &&
    !empty($country_code) &&
    isset($contact_no) &&
    !empty($contact_no)){
    $data = [
      "business_name" => $business_name,
      "business_type" => $business_type,
      "user_email"    => $user_email,
      "user_password" => $user_password,
      "country_code"  => $country_code,
      "contact_no"    => $contact_no
    ];
    $userSignup = $authController->signup($data);
    if($userSignup['type'] === 'userDuplicate'){
      isset($_POST['userDuplicate']);
    } else {
      session_start();
      $_SESSION['user'] = $userSignup['data']['token'];
      header("Location: /wholesale-shop?newUser=1");
    }
  }
?>
<div class="page-content">
  <div class="row justify-content-center px-3">
    <h2 class="text-center mb-4">Business Registration</h2>
    <?php
      if(isset($userSignup['type']) && $userSignup['type'] === 'userDuplicate')
        echo '<div class="mb-3 text-center">
          <p class="text-danger">User already Exists</p>
          <p>Try <a href="/login">Login</a> or <a href="/forgot-password">Forgot Password</a></p>
        </div>'
    ?>
    <form class="col-lg-6 col-md-6 col-12" method="post" action="/signup?userSignup=1">
      <div class="mb-4">
        <label for="business-name">Business Name*</label>
        <input type="text" id="business-name" name="business_name" class="form-control" />
        <?php
          if(isset($_POST['business_name']) && empty($_POST['business_name']))
            echo '<p class="text-danger text-small">Required</p>';
        ?>
      </div>
      <div class="mb-4">
        <label for="business-type">Business Type*</label>
        <select class="select-input" id="business-type" name="business_type">
          <option value="retailer">Retailer</option>
          <option value="wholesaler">Wholesaler</option>
        </select>
        <?php
          if(isset($_POST['business_type']) && empty($_POST['business_type']))
            echo '<p class="text-danger text-small">Required</p>';
        ?>
      </div>
      <div class="mb-4">
        <label for="user-email">Email*</label>
        <input type="text" id="user-email" name="user_email" class="form-control" />
        <?php
          if(isset($_POST['user_email']) && empty($_POST['user_email']))
            echo '<p class="text-danger text-small">Required</p>';
        ?>
      </div>
      <div class="mb-4">
        <label for="user-password">Password*</label>
        <input type="password" id="user-password" name="user_password" class="form-control" />
        <?php
          if(isset($_POST['user_password']) && empty($_POST['user_password']))
            echo '<p class="text-danger text-small">Required</p>';
        ?>
      </div>
      <div class="mb-4">
        <label for="confirm-password">Confirm Password*</label>
        <input type="password" id="confirm-password" name="confirm_password" class="form-control" />
        <?php
          if(isset($_POST['confirm_password']) && empty($_POST['confirm_password']))
            echo '<p class="text-danger text-small">Required</p>';
        ?>
        <!-- <span class="text-small text-danger">Confirm password mismatch</span> -->
      </div>
      <div class="mb-4 pb-4 border-bottom">
        <div class="row">
          <div class="col-4">
            <label for="country-code">Country Code*</label>
            <input type="text" id="country-code" name="country_code" class="form-control" />
            <?php
              if(isset($_POST['country_code']) && empty($_POST['country_code']))
                echo '<p class="text-danger text-small">Required</p>';
            ?>
          </div>
          <div class="col-8">
            <label for="contact-no">Contact No.*</label>
            <input type="number" id="contact-no" name="contact_no" class="form-control" />
            <?php
              if(isset($_POST['contact_no']) && empty($_POST['contact_no']))
                echo '<p class="text-danger text-small">Required</p>';
            ?>
          </div>
        </div>
      </div>
      <div class="d-flex mb-3">
        <div class="col-6">
          <a href="/login" class="btn-a col-6">Login</a>
        </div>
        <div class="col-6 text-end">
          <button type="submit" class="btn btn-primary">Signup</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php include_once("app/views/shared/footer.php"); ?>

<?php
  session_start();
  if(isset($_SESSION['user']) && $_SESSION['user'] !== ''){
    header("Location: /");
  }
  require_once dirname(dirname(__DIR__)) . '/controllers/auth.controller.php';
  require_once dirname(dirname(dirname(__DIR__))) . '/app/csrf.php';
  use app\Controllers\AuthController;
  $authController = new AuthController();

  $business_name  = isset($_POST['business_name'])? trim($_POST['business_name']) : '';
  $business_type  = isset($_POST['business_type'])? trim($_POST['business_type']) : '';
  $user_email     = isset($_POST['user_email'])? trim(strtolower($_POST['user_email'])) : '';
  $user_password  = isset($_POST['user_password'])? $_POST['user_password'] : '';
  $country_code   = isset($_POST['country_code'])? trim($_POST['country_code']) : '';
  $contact_no     = isset($_POST['contact_no'])? trim($_POST['contact_no']) : '';

  if(
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
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
    if(!csrf_verify()){
      $signupError = 'Invalid form submission, please try again.';
    } elseif(strlen($business_name) < 2 || strlen($business_name) > 100 || !preg_match('/^[a-zA-Z0-9\s\.\-\&\']+$/', $business_name)){
      $signupError = 'Business name must be 2-100 characters and contain only letters, numbers, spaces, dots, hyphens, or &.';
    } elseif(!in_array($business_type, ['retailer', 'wholesaler'], true)){
      $signupError = 'Please select a valid business type.';
    } elseif(!filter_var($user_email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/', $user_email)){
      $signupError = 'Please enter a valid email address.';
    } elseif(!checkdnsrr(substr(strrchr($user_email, '@'), 1), 'MX')){
      $signupError = 'Email domain does not appear to be valid.';
    } elseif(strlen($user_password) < 8 || !preg_match('/[A-Za-z]/', $user_password) || !preg_match('/[0-9]/', $user_password)){
      $signupError = 'Password must be at least 8 characters with letters and numbers.';
    } elseif($user_password !== ($_POST['confirm_password'] ?? '')){
      $signupError = 'Passwords do not match.';
    } elseif(!preg_match('/^\+\d{1,4}$/', $country_code)){
      $signupError = 'Invalid country code.';
    } elseif(!preg_match('/^\d{6,15}$/', $contact_no)){
      $signupError = 'Phone number must be 6-15 digits.';
    } else {
      $data = [
      "business_name" => htmlspecialchars($business_name, ENT_QUOTES, 'UTF-8'),
      "business_type" => $business_type,
      "user_email"    => filter_var($user_email, FILTER_SANITIZE_EMAIL),
      "user_password" => $user_password,
      "country_code"  => $country_code,
      "contact_no"    => preg_replace('/[^0-9]/', '', $contact_no)
    ];
    $userSignup = $authController->signup($data);
    if($userSignup['type'] === 'userDuplicate'){
      isset($_POST['userDuplicate']);
    } else {
      header("Location: /login?newUser=1");
    }
    }
  }
  include_once("app/views/shared/header.php");
?>
<div class="page-content">
  <div class="row justify-content-center px-3">
    <h2 class="text-center mb-4">Business Registration</h2>
    <?php if(isset($signupError)): ?>
      <div class="mb-3 text-center">
        <p class="text-danger"><?php echo htmlspecialchars($signupError); ?></p>
      </div>
    <?php endif; ?>
    <?php
      if(isset($userSignup['type']) && $userSignup['type'] === 'userDuplicate')
        echo '<div class="mb-3 text-center">
          <p class="text-danger">User already Exists</p>
          <p>Try <a href="/login">Login</a> or <a href="/forgot-password">Forgot Password</a></p>
        </div>'
    ?>
    <form class="col-lg-6 col-md-6 col-12" method="post" action="/signup">
      <?php echo csrf_field(); ?>
      <div class="mb-4">
        <label for="business-name">Business Name*</label>
        <input type="text" id="business-name" name="business_name" class="form-control" required minlength="2" maxlength="100" pattern="[a-zA-Z0-9\s\.\-\&']+" />
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
        <input type="email" id="user-email" name="user_email" class="form-control" required maxlength="254" />
        <?php
          if(isset($_POST['user_email']) && empty($_POST['user_email']))
            echo '<p class="text-danger text-small">Required</p>';
        ?>
      </div>
      <div class="mb-4">
        <label for="user-password">Password*</label>
        <input type="password" id="user-password" name="user_password" class="form-control" required minlength="8" maxlength="128" />
        <?php
          if(isset($_POST['user_password']) && empty($_POST['user_password']))
            echo '<p class="text-danger text-small">Required</p>';
        ?>
      </div>
      <div class="mb-4">
        <label for="confirm-password">Confirm Password*</label>
        <input type="password" id="confirm-password" name="confirm_password" class="form-control" required minlength="8" maxlength="128" />
        <?php
          if(isset($_POST['confirm_password']) && empty($_POST['confirm_password']))
            echo '<p class="text-danger text-small">Required</p>';
        ?>
        <!-- <span class="text-small text-danger">Confirm password mismatch</span> -->
      </div>
      <div class="mb-4 pb-4">
        <label for="contact-no">Phone Number*</label>
        <input type="number" id="contact-no" name="contact_no" class="form-control" required />
        <input type="hidden" id="country-code" name="country_code" value="+92" />
        <?php
          if(isset($_POST['country_code']) && empty($_POST['country_code']))
            echo '<p class="text-danger text-small">Required</p>';
          if(isset($_POST['contact_no']) && empty($_POST['contact_no']))
            echo '<p class="text-danger text-small">Required</p>';
        ?>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.8.2/build/css/intlTelInput.css" />
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.8.2/build/js/intlTelInput.min.js"></script>
<script>
  var phoneInput = document.getElementById('contact-no');
  var countryCodeInput = document.getElementById('country-code');
  var iti = intlTelInput(phoneInput, {
    initialCountry: 'pk',
    preferredCountries: ['pk', 'us', 'gb', 'ae', 'sa', 'in'],
    separateDialCode: true,
    utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@24.8.2/build/js/utils.js'
  });
  phoneInput.addEventListener('countrychange', function(){
    countryCodeInput.value = '+' + iti.getSelectedCountryData().dialCode;
  });
  phoneInput.closest('form').addEventListener('submit', function(){
    countryCodeInput.value = '+' + iti.getSelectedCountryData().dialCode;
  });
</script>
<style>
  .iti { width: 100%; }
</style>

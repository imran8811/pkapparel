<?php
  include_once ("./init.php");
  if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="Jeans Manufacturers"/>
  <meta name="description" content="PK Apparel specializes in export-quality denim jeans, and have been top Jeans Manufacturers for years with its clients all over the world. Place your order now!" />
  <meta name="google-site-verification" content="tq6NZzCuCj2a7kvdssFcuBKb8z0BdAjdUhS4e_IuiNY" />
  <title>Cart | PK Apparel</title>
  <link rel="icon" href="./assets/images/favicon.png" type="image/png">
  <link type="text/css" rel="stylesheet" href="./assets/css/style.css">
  <link type="text/css" rel="stylesheet" href="./assets/css/style-wholesale.css">
</head>
<body>
<div class="wrapper">
  <?php include_once ('./header-menu.php'); ?>
  <div class="main">
    <div class="page-accounts clearfix">
      <?php include_once("user-sidebar.php"); ?>
      <div class="acc-content">
        <h1>Change Password</h1>
        <div class="inner-wrap">
          <form action="#" class="changepass-form">
            <div class="input-wrap">
              <label for="password">New Password</label>
              <input type="password" id="password" name="password" class="new-pass">
              <span class="error-alert"></span>
            </div>
            <div class="input-wrap">
              <label for="confirm-pass">Confirm Password</label>
              <input type="password" id="confirm-pass" name="confirm_pass" class="confirm-pass">
              <span class="error-alert"></span>
            </div>
            <div class="submit-wrap clearfix">
              <input type="submit" value="Save" class="btn-submit">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once ("./footer.php"); ?>
<?php include_once ("./assets/js/changepassjs.php"); ?>
</body>
</html>

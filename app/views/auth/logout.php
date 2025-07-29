<?php
  session_start();
  require_once dirname(dirname(__DIR__)) . '/controllers/auth.controller.php';
  use app\Controllers\AuthController;
  $authController = new AuthController();
  $token = $_SESSION['user'];
  $userLogout = $authController->logout($token);
  if($userLogout){
    session_destroy();
    header("Location: /wholesale-shop");
  }
?>

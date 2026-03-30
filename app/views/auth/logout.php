<?php
  session_start();
  require_once dirname(dirname(__DIR__)) . '/controllers/auth.controller.php';
  use app\Controllers\AuthController;
  $authController = new AuthController();
  $token = $_SESSION['user'] ?? '';
  if($token){
    $authController->logout($token);
  }
  session_unset();
  session_destroy();
  header("Location: /");
  exit;
?>

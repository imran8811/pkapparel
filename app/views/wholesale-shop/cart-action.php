<?php
if(!isset($_SESSION)) session_start();

require_once("app/controllers/cart.controller.php");
use app\Controllers\CartController;
$cartCtrl = new CartController();

$sessionExist = isset($_SESSION['user']) && $_SESSION['user'] !== '';
if(!$sessionExist || !isset($_SESSION['user_email'])){
  header('Location: /login');
  exit;
}

$userId = $cartCtrl->getUserIdByEmail($_SESSION['user_email']);
if(!$userId){
  header('Location: /login');
  exit;
}

$action = $_POST['action'] ?? 'add';
$referer = $_SERVER['HTTP_REFERER'] ?? '/wholesale-shop';

if($action === 'add'){
  $article = trim($_POST['article'] ?? '');
  $sizes   = trim($_POST['sizes'] ?? '30,32,34,36,38');
  $price   = floatval($_POST['price'] ?? 0);
  $qty     = max(1, intval($_POST['quantity'] ?? 1));

  if($article !== '' && $price > 0){
    $pId = $cartCtrl->getProductIdByArticle($article);
    if($pId){
      $cartCtrl->addItem($userId, $pId, $sizes, $qty, $price);
    }
  }

  $redirect = trim($_POST['redirect'] ?? '');
  if($redirect === '/checkout'){
    header('Location: /checkout');
  } else {
    $referer = strtok($referer, '?');
    header('Location: ' . $referer . '?cart_added=1');
  }
  exit;
}

if($action === 'update'){
  $cartId = intval($_POST['cart_id'] ?? 0);
  $qty    = max(1, intval($_POST['quantity'] ?? 1));
  if($cartId > 0){
    $cartCtrl->updateQuantity($cartId, $userId, $qty);
  }
  header('Location: /cart');
  exit;
}

if($action === 'remove'){
  $cartId = intval($_POST['cart_id'] ?? 0);
  if($cartId > 0){
    $cartCtrl->removeItem($cartId, $userId);
  }
  header('Location: /cart');
  exit;
}

if($action === 'clear'){
  $cartCtrl->clearCart($userId);
  header('Location: /cart');
  exit;
}

header('Location: /cart');
exit;

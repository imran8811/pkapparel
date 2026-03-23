<?php
namespace app\Controllers;
require_once dirname(__DIR__). "/models/cart.model.php";
include_once(dirname(dirname(__DIR__)). "/Core/Controller.php");
use Core\Controller;
use app\Models\CartModel;

class CartController extends Controller {
  private $cartModel;

  public function __construct(){
    $this->cartModel = new CartModel();
  }

  public function addItem($userId, $pId, $sizes, $quantity, $amount){
    return $this->cartModel->addItem($userId, $pId, $sizes, $quantity, $amount);
  }

  public function getCartItems($userId){
    return $this->cartModel->getCartItems($userId);
  }

  public function updateQuantity($cartId, $userId, $quantity){
    return $this->cartModel->updateQuantity($cartId, $userId, $quantity);
  }

  public function removeItem($cartId, $userId){
    return $this->cartModel->removeItem($cartId, $userId);
  }

  public function clearCart($userId){
    return $this->cartModel->clearCart($userId);
  }

  public function getCartCount($userId){
    return $this->cartModel->getCartCount($userId);
  }

  public function getProductIdByArticle($articleNo){
    return $this->cartModel->getProductIdByArticle($articleNo);
  }

  public function getUserIdByEmail($email){
    return $this->cartModel->getUserIdByEmail($email);
  }
}

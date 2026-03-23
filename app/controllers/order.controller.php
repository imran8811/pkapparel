<?php
namespace app\Controllers;
require_once dirname(__DIR__). "/models/order.model.php";
include_once(dirname(dirname(__DIR__)). "/Core/Controller.php");
use Core\Controller;
use app\Models\OrderModel;

class OrderController extends Controller {
  private $orderModel;

  public function __construct(){
    $this->orderModel = new OrderModel();
  }

  public function createOrder($data, $items){
    return $this->orderModel->createOrder($data, $items);
  }

  public function getOrdersByUserId($userId){
    return $this->orderModel->getOrdersByUserId($userId);
  }

  public function getOrderByNumber($orderNumber){
    return $this->orderModel->getOrderByNumber($orderNumber);
  }

  public function getOrderById($orderId){
    return $this->orderModel->getOrderById($orderId);
  }

  public function getOrderItems($orderId){
    return $this->orderModel->getOrderItems($orderId);
  }

  public function getAllOrders(){
    return $this->orderModel->getAllOrders();
  }

  public function updateOrderStatus($orderId, $status){
    return $this->orderModel->updateOrderStatus($orderId, $status);
  }

  public function deleteOrder($orderId){
    return $this->orderModel->deleteOrder($orderId);
  }

  public function getUserIdByEmail($email){
    return $this->orderModel->getUserIdByEmail($email);
  }
}

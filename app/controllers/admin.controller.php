<?php
namespace app\Controllers;
require_once dirname(__DIR__). "/models/admin.model.php";
include_once(dirname(dirname(__DIR__)). "/Core/Controller.php");
use Core\Controller;
use app\Models\AdminModel;

class AdminController extends Controller {
  private $adminModel;

  public function __construct(){
    $this->adminModel = new AdminModel();
  }

  public function login($email, $password){
    $adminLogin = $this->adminModel->login($email, $password);
    if($adminLogin){
      return [
        "status" => "success",
        "message" => "Admin LoggedIn",
        "data" => $adminLogin
      ];
    } else {
      return [
        "status" => "Error",
        "message" => "Invalid Username/Password"
      ];
    }
  }

  public function getAllUsers(){
    return $this->adminModel->getAllUsers();
  }

  public function getUserById($id){
    return $this->adminModel->getUserById($id);
  }

  public function updateUser($data){
    return $this->adminModel->updateUser($data);
  }

  public function deleteUser($id){
    return $this->adminModel->deleteUser($id);
  }

  public function updateUserStatus($userId, $status){
    return $this->adminModel->updateUserStatus($userId, $status);
  }
}

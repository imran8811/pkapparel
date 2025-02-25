<?php
namespace app\Controllers;
require_once dirname(__DIR__). "/models/admin.model.php";
use Core\Controller;
use app\Models\AdminModel;

class AdminController extends Controller {
  private $adminModel;

  public function __construct(){
    $this->adminModel = new AdminModel();
  }

  public function login($email, $password){
    $adminLogin = $this->adminModel->login($email, $password);
    // return $adminLogin;
    if($adminLogin){
      return [
        "status" => "success",
        "message" => "Admin LoggedIn",
        "data" => [
          "email" => $adminLogin['email']
        ]
      ];
    } else {
      return [
        "status" => "Error",
        "message" => "Invalid Username/Password"
      ];
    }
  }
}

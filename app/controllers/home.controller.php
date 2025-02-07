<?php

use Framework\Controller;
use Framework\ViewerController;

class HomeController extends Controller {

  public function index(){
    return $this->view("/views/home");
  }
}

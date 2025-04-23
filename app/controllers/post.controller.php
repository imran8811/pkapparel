<?php

namespace app\Controllers;

include_once(dirname(dirname(__DIR__)) . "/Core/Controller.php");
include_once(dirname(__DIR__) . "/models/post.model.php");

use Core\Controller;
use app\Models\postModel;
use finfo;

class PostController extends Controller
{
  protected $postModel;

  public function __construct()
  {
    $this->postModel = new postModel();
  }

  public function getPostComments($postID)
  {
    $getPostComments = $this->postModel->getPostComments($postID);
    return $getPostComments;
  }

  public function addComment($data){
    $addComment = $this->postModel->addComment($data);
    if ($addComment) {
      $res = [
        'type' => 'success',
        'p_id' => $addComment,
        'message' => 'Comment Added Successfully'
      ];
    } else {
      $res = [
        'type' => 'error',
        'message' => 'Unable to add product'
      ];
    }
    return $res;
  }

}

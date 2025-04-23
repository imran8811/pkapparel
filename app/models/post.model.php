<?php

namespace app\Models;
include_once(dirname(dirname(__DIR__)). "/Core/Model.php");
use Core\Model;

class PostModel extends Model {
  public function __construct(){
    parent::__construct();
  }

  public function getPostComments($postID){
    $query = 'SELECT * FROM post_comments WHERE post_id=? ORDER BY comment_id DESC';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$postID]);
    $res = $stmt->fetchAll();
    return $res;
  }

  public function addComment($data) {
    $query = "INSERT INTO post_comments
            (
            post_id,
            commenter_name,
            post_comment
            )
            VALUES
            (
            :post_id,
            :commenter_name,
            :post_comment
            )";
    $stmt= $this->pdo->prepare($query);
    $stmt->execute($data);
    $stmt2 = $this->pdo->prepare('SELECT MAX(comment_id) from post_comments');
    $stmt2->execute();
    $res = $stmt2->fetchColumn();
    return $res;
  }

}

?>

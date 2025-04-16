<?php
require_once("app/controllers/post.controller.php");
use app\Controllers\PostController;
$postController = new PostController();
$postID="1";
$getPostComments = $postController->getPostComments($postID);
// print_r($getPostComments);
echo $_SERVER['REQUEST_URI'];

?>
<hr />
<h3 class="mt-5 text-center h2">Users Comments</h3>
<div class="user-comments mb-5">
<?php foreach($getPostComments as $postComment): ?>
  <div class="card">
    <div class="card-body">
      <div class="post-comment mb-3"><?php echo $postComment['post_comment'] ?></div>
      <div class="comment-user d-flex justify-content-end">
        <strong class="divider"><?php echo $postComment['commenter_name'] ?></strong>
        <span class="spacer">&nbsp; - &nbsp;</span>
        <span class="date-time"><?php echo $postComment['date_time'] ?></span>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<div class="mt-5 mb-5">
  <form action="<?php echo $_SERVER['REQUEST_URI']; ?>/user_comment=1" method="post">
    <div class="mb-3">
      <label for="commenter-name">Full Name:</label>
      <input type="text" id="commenter-name" name="commenter_name" class="form-control" />
    </div>
    <div class="mb-3">
      <label for="post-comment">Comment:</label>
      <textarea rows="6" id="post-comment" name="post_comment" class="form-control"></textarea>
    </div>
    <div class="mb-3 d-flex justify-content-center">
      <button type="submit" class="btn btn-success">comment</button>
    </div>
  </form>
</div>

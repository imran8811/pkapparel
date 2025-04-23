<?php
require_once("app/controllers/post.controller.php");
use app\Controllers\PostController;
$postController = new PostController();
$postID="1";
$getPostComments = $postController->getPostComments($postID);
// print_r($getPostComments);

?>
<hr />
<h3 class="mt-5 text-center h2">Users Comments</h3>
<div class="row justify-content-between">
  <div class="col-lg-6 col-md-7 col-12 user-comments mt-3 mb-3">
    <?php foreach($getPostComments as $postComment): ?>
      <div class="card mb-3">
        <div class="card-body">
          <div class="post-comment mb-3"><?php echo $postComment['post_comment'] ?></div>
          <div class="comment-user d-flex justify-content-end">
            <strong class="divider"><?php echo $postComment['commenter_name'] ?></strong>
            <span class="spacer">&nbsp; - &nbsp;</span>
            <span class="date-time"><?php echo date_format(date_create($postComment['date_time']), "F j, Y") ?></span>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="col-lg-4 col-md-5 col-12 mt-3">
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>?user_comment=1" method="post">
      <div class="mb-3">
        <label for="commenter-name">Full Name:</label>
        <input type="text" id="commenter-name" name="commenter_name" required class="form-control" />
      </div>
      <div class="mb-3">
        <label for="post-comment">Comment:</label>
        <textarea rows="6" id="post-comment" name="post_comment" required class="form-control"></textarea>
      </div>
      <div class="mb-3 d-flex justify-content-center">
        <button type="submit" class="btn btn-success">comment</button>
      </div>
    </form>
  </div>
</div>

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
  <div class="col-lg-6 col-md-6 col-12 user-comments mt-3 mb-3">
    <?php foreach($getPostComments as $postComment): ?>
      <div class="card mb-3">
        <div class="card-body">
          <div class="post-comment mb-3"><?php echo htmlspecialchars($postComment['post_comment']) ?></div>
          <div class="comment-user d-flex justify-content-end">
            <strong class="divider"><?php echo htmlspecialchars($postComment['commenter_name']) ?></strong>
            <span class="spacer">&nbsp; - &nbsp;</span>
            <span class="date-time"><?php echo date_format(date_create($postComment['date_time']), "F j, Y") ?></span>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="col-lg-6 col-md-6 col-12 mt-3">
    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="_ts" value="<?php echo time(); ?>" />
      <!-- Honeypot — hidden from real users, bots will fill it -->
      <div style="position:absolute;left:-9999px;" aria-hidden="true">
        <label for="website">Leave this empty</label>
        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off" />
      </div>
      <div class="mb-3">
        <label for="commenter-name">Full Name:</label>
        <input type="text" id="commenter-name" name="commenter_name" required maxlength="100" class="form-control" />
      </div>
      <div class="mb-3">
        <label for="post-comment">Comment:</label>
        <textarea rows="6" id="post-comment" name="post_comment" required maxlength="2000" class="form-control"></textarea>
      </div>
      <div class="mb-3 d-flex justify-content-center">
        <button type="submit" class="btn btn-success">comment</button>
      </div>
    </form>
  </div>
</div>

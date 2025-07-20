<?php
  // $constants    = include_once(dirname(dirname(__DIR__))."/constants.php");
  // $metaData     = $constants['metaData'];
  $currentPage  = $_SERVER['REQUEST_URI'];
  $currentPage  = explode('?', $currentPage);
  $currentPage  = explode('/', $currentPage[0]);
  $currentPage  = end($currentPage);
  $heading      = metaData[$currentPage]['title'];
  $description  = metaData[$currentPage]['description'];

?>
<div class="tagline mb-5">
  <div class="bg-img"></div>
  <div class="col-12 col-md-9 col-lg-6 text-center tagline-text">
    <h1 class="heading mb-4"><?php echo $heading ?></h1>
    <p class="para"><?php echo $description ?></p>
  </div>
</div>

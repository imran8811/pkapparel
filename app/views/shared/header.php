<?php
  $constants = include(dirname(dirname(__DIR__))."/constants.php");
  $metaData = $constants['metaData'];
  $currentPage = $_SERVER['REQUEST_URI'];
  $currentPage = explode('/', $currentPage);
  $currentPage = end($currentPage);
  if(isset($metaData[$currentPage]['title']) && isset($metaData[$currentPage]['keywords']) && isset($metaData[$currentPage]['description'])){
    $title = $metaData[$currentPage]['title'];
    $keywords = $metaData[$currentPage]['keywords'];
    $description = $metaData[$currentPage]['description'];
  } else {
    $title = ucwords(str_replace("-"," ",$currentPage));
    $keywords = $currentPage;
    $description = $currentPage;
  }
?>
<!doctype html>
<html lang="en">
<head>
    <title><?php echo $title ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/public/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/public/css/fontawesome.all.min.css" />
    <link rel="stylesheet" href="/public/css/swiper.min.css" />
    <link rel="stylesheet" href="/public/css/style.css" />
    <link rel="icon" type="image/png" href="/public/images/favicon.png">
    <meta name="keywords" content="<?php echo $keywords ?>">
    <meta name="description" content="<?php echo $description ?>">
</head>
<body>
  <div class="main-wrapper">
    <header>
      <div class="header-main border-bottom row mt-4 pb-3">
        <div class="col-md-4 mb-3">
          <a href="/">
            <img src="/public/images/logo.jpg" alt="PK Apparel logo" title="PK Apparel Home" />
          </a>
        </div>
        <ul class="header-menu col-md-8 my-4">
          <li><a href="https://www.wholesale.pkapparel.com">Wholesale</a></li>
          <li><a href="/about">About us</a></li>
          <li><a href="/factory">Factory</a></li>
          <li><a href="/blog">Blog</a></li>
          <li><a href="/contact">Contact us</a></li>
          <li><a href="https://www.retail.pkapparel.com">Retail</a></li>
        </ul>
      </div>
    </header>

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
    <meta name="google-site-verification" content="tq6NZzCuCj2a7kvdssFcuBKb8z0BdAjdUhS4e_IuiNY" />
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
        <ul class="header-menu col-md-8 mt-3 mb-3">
          <li><a href="/wholesale-shop">Wholesale Shop</a></li>
          <li><a href="/wholesale-shop/men">Men</a></li>
          <li><a href="/wholesale-shop/women">Women</a></li>
          <li><a href="/wholesale-shop/boys">Boys</a></li>
          <li><a href="/wholesale-shop/girls">Girls</a></li>
          <li><a href="/contact">Contact us</a></li>
        </ul>
      </div>
    </header>

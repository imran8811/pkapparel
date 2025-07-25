<?php
  ini_set('display_errors', '1');
  ini_set('display_startup_errors', '1');
  error_reporting(E_ALL);
  include_once(dirname(dirname(__DIR__))."/constants.php");
  // $userCountry = user_info("Visitor", "Country");
  // if($userCountry === 'Pakistan'){
  //   header("Location: https://www.pk.pkapparel.com");
  // }
  $currentPage = $_SERVER['REQUEST_URI'];
  $currentPage = explode('/', $currentPage);
  $currentPage = end($currentPage);
  if(isset(metaData[$currentPage]['title']) && isset(metaData[$currentPage]['keywords']) && isset(metaData[$currentPage]['description'])){
    $title = metaData[$currentPage]['title'];
    $keywords = metaData[$currentPage]['keywords'];
    $description = metaData[$currentPage]['description'];
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
          <li><a href="/wholesale-shop" class="btn-link">Wholesale Shop</a></li>
          <li><a href="/login" class="btn-link">Login</a></li>
          <li><a href="/signup" class="btn-link">Signup</a></li>
        </ul>
      </div>
    </header>

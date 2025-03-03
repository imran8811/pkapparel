<?php

?>
<!doctype html>
<html lang="en">
<head>
  <title><?php echo "Admin Panel" ?></title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="stylesheet" href="/public/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/public/css/fontawesome.all.min.css" />
  <link rel="stylesheet" href="/public/css/swiper.min.css" />
  <link rel="stylesheet" href="/public/css/style.css" />
  <link rel="icon" type="image/png" href="/public/images/favicon.png" />
</head>
<body>
  <div class="main-wrapper">
    <header class='container-fluid'>
      <div class='row'>
        <div class='col-6 mt-3'>
          <a href="/admin" class="navbar-brand">
            <img src="/public/images/logo.jpg" alt="logo" class="img-fluid" title="PK Apparel Home" />
          </a>
        </div>
        <ul class='col-6 main-menu'>
          <li><a href="/admin/products" class="nav-item nav-a">Products</a></li>
          <li><a href="/admin/add-product" class="nav-item nav-a">Add product</a></li>
          <li><a href="/admin/logout" class="nav-item nav-a">Logout</a></li>
        </div>
      </div>
    </header>

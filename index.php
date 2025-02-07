<?php
  require_once(__DIR__."/app/user-info.php");
  $constants = include(__DIR__."/app/constants.php");
  $userInfo = new userInfo();
  $userCountry = $userInfo->ip_info("Visitor", "Country");
  $bannedCountries = $constants['bannedCountries'];
  if(in_array($userCountry, $bannedCountries)){
    echo "<h1> Not Available </h1>";
    return;
  };

  include_once './vendor/autoload.php';
  $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load();

  include_once('./Core/Router.php');
  use \Core\Router;
  $router = new Router();

  $base_path = '/';
  //static
  $router->get($base_path, 'app/views/home.php');
  $router->get($base_path.'about', '/app/views/static/about.php');
  $router->get($base_path.'contact', '/app/views/static/contact.php');
  $router->get($base_path.'factory', '/app/views/static/factory.php');
  $router->get($base_path.'blog', '/app/views/static/blog.php');

  //authentication
  $router->get($base_path.'login', 'app/views/auth/login.php');
  $router->get($base_path.'signup', 'app/views/auth/signup.php');
  $router->get($base_path.'forgot-password', 'app/views/auth/forgot-password.php');
  $router->get($base_path.'reset-password', 'app/views/auth/reset-password.php');
  $router->get($base_path.'user-account', 'app/views/auth/user-account.php');

  //wholesale shop
  $router->get($base_path.'wholesale-shop', 'app/views/wholesale-shop/shop.php');
  $router->get($base_path.'wholesale-shop/$dept', 'app/views/wholesale-shop/shop.php');
  $router->get($base_path.'wholesale-shop/$dept/$category', 'app/views/wholesale-shop/shop.php');
  $router->get($base_path.'wholesale-shop/$dept/$category/$name', 'app/views/wholesale-shop/product-details.php');
  $router->get($base_path.'wholesale-shop/cart', 'app/views/wholesale-shop/cart.php');
  $router->get($base_path.'wholesale-shop/checkout', 'app/views/wholesale-shop/checkout.php');
  $router->get($base_path.'wholesale-shop/orders', 'app/views/wholesale-shop/orders.php');
  $router->get($base_path.'wholesale-shop/orders-invoice', 'app/views/wholesale-shop/orders-invoice.php');

  //posts
  $router->get($base_path.'post/bulk-jeans', 'app/views/post/bulk-jeans.php');
  $router->get($base_path.'post/jeans-manufacturers', 'app/views/post/jeans-manufacturers.php');
  $router->get($base_path.'post/jeans-manufacturing-cost', 'app/views/post/jeans-manufacturing-cost.php');
  $router->get($base_path.'post/jeans-pants-manufacturers', 'app/views/post/jeans-pants-manufacturers.php');
  $router->get($base_path.'post/jeans-wholesale', 'app/views/post/jeans-wholesale.php');
  $router->get($base_path.'post/motorcycle-jeans-manufacturers', 'app/views/post/motorcycle-jeans-manufacturers.php');
  $router->get($base_path.'post/wholesale-denim-jeans-suppliers', 'app/views/post/wholesale-denim-jeans-suppliers.php');
  $router->get($base_path.'post/wholesale-jeans-bulk', 'app/views/post/wholesale-jeans-bulk.php');
  $router->get($base_path.'post/wholesale-jeans-manufacturers', 'app/views/post/wholesale-jeans-manufacturers.php');
  $router->get($base_path.'post/wholesale-jeans-suppliers', 'app/views/post/wholesale-jeans-suppliers.php');
  $router->get($base_path.'post/wholesale-women-jeans', 'app/views/post/wholesale-women-jeans.php');


  // get('/user/$id', 'views/user');
  // get('/user/$name/$last_name', 'views/full_name.php');
  // get('/product/$type/color/$color', 'product.php');
  // get('/callback', function(){
  //   echo 'Callback executed';
  // });
  // get('/callback/$name', function($name){
  //   echo "Callback executed. The name is $name";
  // });
  // get('/product', '');
  // get('/callback/$name/$last_name', function($name, $last_name){
  //   echo "Callback executed. The full name is $name $last_name";
  // });
  // post('/user', '/api/save_user');
  // any('/404','views/404.php');

?>


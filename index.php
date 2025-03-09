<?php
  $constants = include(__DIR__."/app/constants.php");
  require_once(__DIR__."/vendor/autoload.php");
  include_once('./Core/Router.php');
  use \Core\Router;
  $router = new Router();

  //static
  $router->get('/', 'app/views/static/home.php');
  $router->get('/about', '/app/views/static/about.php');
  $router->get('/contact', '/app/views/static/contact.php');
  $router->get('/factory', '/app/views/static/factory.php');
  $router->get('/blog', '/app/views/static/blog.php');

  //posts
  $router->get('/post/bulk-jeans', 'app/views/post/bulk-jeans.php');
  $router->get('/post/jeans-manufacturers', 'app/views/post/jeans-manufacturers.php');
  $router->get('/post/jeans-manufacturing-cost', 'app/views/post/jeans-manufacturing-cost.php');
  $router->get('/post/jeans-pants-manufacturers', 'app/views/post/jeans-pants-manufacturers.php');
  $router->get('/post/jeans-wholesale', 'app/views/post/jeans-wholesale.php');
  $router->get('/post/motorcycle-jeans-manufacturers', 'app/views/post/motorcycle-jeans-manufacturers.php');
  $router->get('/post/wholesale-denim-jeans-suppliers', 'app/views/post/wholesale-denim-jeans-suppliers.php');
  $router->get('/post/wholesale-jeans-bulk', 'app/views/post/wholesale-jeans-bulk.php');
  $router->get('/post/wholesale-jeans-manufacturers', 'app/views/post/wholesale-jeans-manufacturers.php');
  $router->get('/post/wholesale-jeans-suppliers', 'app/views/post/wholesale-jeans-suppliers.php');
  $router->get('/post/wholesale-women-jeans', 'app/views/post/wholesale-women-jeans.php');

  //admin
  $router->get('/admin', 'app/views/admin/index.php');
  $router->get('/admin/login', 'app/views/admin/admin-login.php');
  $router->post('/admin/login', 'app/views/admin/admin-login.php');
  $router->get('/admin/add-product', 'app/views/admin/add-product.php');
  $router->post('/admin/add-product', 'app/views/admin/add-product.php');
  $router->get('/admin/logout/$token', function($token){
    echo $token;
  });

  //authentication
  $router->get('/login', 'app/views/auth/login.php');
  $router->get('/signup', 'app/views/auth/signup.php');
  $router->get('/forgot-password', 'app/views/auth/forgot-password.php');
  $router->get('/reset-password', 'app/views/auth/reset-password.php');
  $router->get('/user-account', 'app/views/auth/user-account.php');

  //wholesale shop
  $router->get('/wholesale-shop', 'app/views/wholesale-shop/shop.php');
  $router->get('/wholesale-shop/$dept', 'app/views/wholesale-shop/shop.php');
  $router->get('/wholesale-shop/$dept/$category', 'app/views/wholesale-shop/shop.php');
  $router->get('/wholesale-shop/$dept/$category/$name', 'app/views/wholesale-shop/product-details.php');
  $router->get('/cart', 'app/views/wholesale-shop/cart.php');
  $router->get('/checkout', 'app/views/wholesale-shop/checkout.php');
  $router->get('/orders', 'app/views/wholesale-shop/orders.php');
  $router->get('/orders-invoice', 'app/views/wholesale-shop/orders-invoice.php');


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


<?php

use \Core\Router;

$router = new Router();

// ##################################################
// ##################################################
// ##################################################

// Static GET
// In the URL -> http://localhost
// The output -> Index
$router->get('/', 'views/index.php');

// Dynamic GET. Example with 1 variable
// The $id will be available in user.php
$router->get('/user/$id', 'views/user');

// Dynamic GET. Example with 2 variables
// The $name will be available in full_name.php
// The $last_name will be available in full_name.php
// In the browser point to: localhost/user/X/Y
$router->get('/user/$name/$last_name', 'views/full_name.php');

// Dynamic GET. Example with 2 variables with static
// In the URL -> http://localhost/product/shoes/color/blue
// The $type will be available in product.php
// The $color will be available in product.php
$router->get('/product/$type/color/$color', 'product.php');

// A route with a callback
$router->get('/callback', function(){
  echo 'Callback executed';
});

// A route with a callback passing a variable
// To run this route, in the browser type:
// http://localhost/user/A
$router->get('/callback/$name', function($name){
  echo "Callback executed. The name is $name";
});

// Route where the query string happends right after a forward slash
$router->get('/product', '');

// A route with a callback passing 2 variables
// To run this route, in the browser type:
// http://localhost/callback/A/B
$router->get('/callback/$name/$last_name', function($name, $last_name){
  echo "Callback executed. The full name is $name $last_name";
});

// ##################################################
// ##################################################
// ##################################################
// Route that will use POST data
$router->post('/user', '/api/save_user');



// ##################################################
// ##################################################
// ##################################################
// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
$router->any('/404','views/404.php');

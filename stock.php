<?php
	require_once("./init");
	$base_url = $_SERVER['HTTP_HOST'] === 'localhost:8080'? 'http://localhost:8080/pkwebnew' : 'https://www.pkapparel.com';
  $cart = new Cart();
  $JeansPants	= new JeansPants();
  $misc = new Misc();
  $get_jeans_pants 		= $JeansPants->get_all_pants();
	if(isset($_SESSION['sess_id'])){
		$count_cart_items = $cart->count_cart_items();
	} else {
		$count_cart_items = 0;
	}
	if($count_cart_items > 0){
		$get_cart_items = $cart->get_cart_items();
	}
  print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="Jeans Manufacturers"/>
  <meta name="description" content="PK Apparel specializes in export-quality denim jeans, and have been top Jeans Manufacturers for years with its clients all over the world. Place your order now!" />
  <meta name="google-site-verification" content="tq6NZzCuCj2a7kvdssFcuBKb8z0BdAjdUhS4e_IuiNY" />
  <title>Expert Jeans Manufacturers and wholesale dealers of export-quality Denim | PK Apparel</title>
  <link rel="icon" href="./assets/images/favicon.png" type="image/png">
  <link type="text/css" rel="stylesheet" href="./assets/css/style.css">
  <link type="text/css" rel="stylesheet" href="./assets/css/style-wholesale.css">
</head>
<body>
<div class="wrapper">
  <?php include_once ('./header-menu.php'); ?>
  <div class="main">
    <h3 class="section-heading">Wholesale Available Stock</h3>
    <div class="stock-wrap">
      <div class="product-filters">
        <div class="filter-head">Search Filters</div>
        <div class="filter-wrap">
          <h3>Product Category</h3>
          <form class="filter-form" method="get">
            <h5>Men</h5>
            <ul class="category-filter">
              <li><label><input type="radio" value="men-jeans_pants" name="category-filter" checked /> Jeans Pants</label></li>
              <li><label><input type="radio" value="men-jeans_jackets" name="category-filter" /> Jeans Jackets</label></li>
              <li><label><input type="radio" value="men-jeans_shorts" name="category-filter" /> Jeans Shorts</label></li>
              <li><label><input type="radio" value="men-jeans_shirts" name="category-filter" /> Jeans Shirts</label></li>
            </ul>
            <h5>Women</h5>
            <ul class="category-filter">
              <li><label><input type="radio" value="women-jeans_pants" name="category-filter" /> Jeans Pants</label></li>
              <li><label><input type="radio" value="women-jeans_jackets" name="category-filter" /> Jeans Jackets</label></li>
              <li><label><input type="radio" value="women-jeans_shorts" name="category-filter" /> Jeans Shorts</label></li>
              <li><label><input type="radio" value="women-jeans_shirts" name="category-filter" /> Jeans Shirts</label></li>
            </ul>
          </div>
          <div class="filter-wrap">
            <h3>Colors</h3>
            <ul class="color-filter">
              <li><label><input type="checkbox" value="all" name="color-filter" checked /> All</label></li>
              <li><label><input type="checkbox" value="black" name="color-filter" /> Black</label></li>
              <li><label><input type="checkbox" value="red" name="color-filter" /> Red</label></li>
              <li><label><input type="checkbox" value="blue" name="color-filter" /> Blue</label></li>
              <li><label><input type="checkbox" value="navy" name="color-filter" /> Navy</label></li>
            </ul>
          </div>
          <div class="filter-wrap">
            <h3>Sizes</h3>
            <ul class="size-filter">
              <li><label><input type="checkbox" value="all" name="size-w-filter" checked /> All</label></li>
              <li><label><input type="checkbox" value="w-28" name="size-w-filter" /> W 28</label></li>
              <li><label><input type="checkbox" value="w-30" name="size-w-filter" /> W 30</label></li>
              <li><label><input type="checkbox" value="w-32" name="size-w-filter" /> W 32</label></li>
              <li><label><input type="checkbox" value="w-34" name="size-w-filter" /> W 34</label></li>
              <li><label><input type="checkbox" value="w-36" name="size-w-filter" /> W 36</label></li>
              <li><label><input type="checkbox" value="w-38" name="size-w-filter" /> W 38</label></li>
            </ul>
          </div>
          <div class="filter-wrap">
            <h3>Sizes</h3>
            <ul class="size-filter">
              <li><label><input type="checkbox" value="all" name="size-filter" checked /> All</label></li>
              <li><label><input type="checkbox" value="small" name="size-filter" /> Small</label></li>
              <li><label><input type="checkbox" value="medium" name="size-filter" /> Medium</label></li>
              <li><label><input type="checkbox" value="large" name="size-filter" /> Large</label></li>
              <li><label><input type="checkbox" value="x-large" name="size-filter" /> XL Large</label></li>
              <li><label><input type="checkbox" value="xx-large" name="size-filter" /> XXL Large</label></li>
            </ul>
          </div>
        </form>
      </div>
      <ul class="men-product-list">
        <?php foreach($get_jeans_pants as $jeans_pant): ?>
        <li>
          <a href="./product-details.php?p=<?php echo $jeans_pant['p_id']; ?>" class='inner-manufacture'>
            <img src="./<?php echo $jeans_pant['image_front'];?>" alt="jeans pants">
            <span class="product-category">PK-<?php echo $jeans_pant['p_id']; ?></span>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <?php include_once ('./footer.php'); ?>
</div>
<script src="./assets/js/jquery-3.5.1.min.js"></script>
<script src="./assets/js/custom.js"></script>
<script>
  var params = {
    filter_search : 1,
    dept: 'men',
    category: 'jeanspants',
    color: [],
    size: []
  }
  const setFiltersCriteria = (params) => {
    if(history.pushState){
      var newurl = `${window.location.origin + window.location.pathname}?dept=${params.dept}&category=${params.category}&color=${params.color.length === 0? 'all' : params.color}&size=${params.size.length === 0? 'all' : params.size}`
      window.history.pushState({path:newurl},'',newurl);
    }
  }

  const searchByFilter = (params) => {
    // const apiUrl = "<?php echo $base_url.'/api.php' ?>"
    // const res = fetch(apiUrl, {
    //   method: 'POST',
    //   body : JSON.stringify({
    //     category : params.category
    //   })
    // }).then(res => console.log(res));
    $.ajax({
      type: "POST",
      url: "<?php echo $base_url; ?>/api",
      data: {
        filter_search: 1,
        dept : params.dept,
        category : params.category,
        colors : params.color,
        size : params.size
      },
      success: function (res) {
        <?php $get_jeans_pants ?> = JSON.parse(res);
      }
    })
  }


  $("input[name='category-filter']").on('change', () => {
    const selectedCategory = $("input[name='category-filter']:checked").val().split("-");
    params.dept = selectedCategory[0];
    params.category = selectedCategory[1];
    setFiltersCriteria(params);
    searchByFilter(params);
  })
  $("input[name='color-filter']").on('change', () => {
    params.color = [];
    $("input:checkbox[name='color-filter']:checked").each(function(){
      params.color.push(this.value);
    });
    if(params.color.length > 1) {
      params.color.shift();
    }
    setFiltersCriteria(params);
    searchByFilter(params);
  })
  $("input[name='size-w-filter']").on('change', () => {
    params.size = [];
    $("input:checkbox[name='size-w-filter']:checked").each(function(){
      params.size.push(this.value);
    });
    if(params.size.length > 1) {
      params.size.shift();
    }
    setFiltersCriteria(params);
  })
  $("input[name='size-filter']").on('change', () => {
    params.size = [];
    $("input:checkbox[name='size-filter']:checked").each(function(){
      params.size.push(this.value);
    });
    if(params.size.length > 1) {
      params.size.shift();
    }
    setFiltersCriteria(params);
  })
</script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-71901684-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-71901684-1');
</script>
</body>
</html>
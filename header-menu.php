<?php 
  $base_url = $_SERVER['HTTP_HOST'] === 'localhost:8080'? 'http://localhost:8080/pkweb' : 'https://www.pkapparel.com' 
?>
<header>
  <div class="holder clearfix">
    <div class="head-contact clearfix">
      <div class="clearfix">
        <a href="<?php echo $base_url; ?>" class="logo">
          <img src="<?php echo $base_url; ?>/assets/images/logo.jpg" alt="logo" width="200" title="PK Apparel Home">
        </a>
        <nav id="nav" class="open-close">
          <a href="" class="opener">Menu</a>
          <ul class="navigation">
            <li><a href="<?php echo $base_url; ?>/about">About us</a></li>
            <li><a href="<?php echo $base_url; ?>/factory">Factory</a></li>
            <li><a href="<?php echo $base_url; ?>/men/jeans-pants">Jeans Pants</a></li>
            <li><a href="<?php echo $base_url; ?>/men/jeans-shirts">Jeans Shirts</a></li>
            <li><a href="<?php echo $base_url; ?>/blog">Blog</a></li>
            <li><a href="<?php echo $base_url; ?>/contact">Contact us</a></li>
            <li><a href="<?php echo $base_url; ?>/stock">Buy Stock</a></li>
          </ul>
        </nav>
        <!-- <ul class="whatsapp-inquiry">
          <li>Whatsapp for inquiries</li>
          <li><a href="https://wa.me/923000911000">+923 000-911-000</a></li>
        </ul> -->
        <ul class="whatsapp-inquiry">
          <!-- <li>For inquiries</li> -->
          <li>Whatsapp: &nbsp;<a href="https://wa.me/923000911000">+92 3 000-911-000</a></li>
          <li>Email: &nbsp;<a href="mailto:&#105;&#110;&#102;&#111;&#064;&#112;&#107;&#097;&#112;&#112;&#097;&#114;&#101;&#108;&#046;&#099;&#111;&#109;">&#105;&#110;&#102;&#111;&#064;&#112;&#107;&#097;&#112;&#112;&#097;&#114;&#101;&#108;&#046;&#099;&#111;&#109;</a></li>
        </ul>
      </div>
    </div>
    <nav class="main-menu">
      <ul>
        <!-- <li><a href="<?php echo $base_url; ?>/stock">Stock</a></li> -->
        <li><a href="<?php echo $base_url; ?>/about">About us</a></li>
        <li><a href="<?php echo $base_url; ?>/factory">Factory</a></li>
        <li><a href="<?php echo $base_url; ?>/men/jeans-pants">Jeans Pants</a></li>
        <li><a href="<?php echo $base_url; ?>/men/jeans-shirts">Jeans Shirts</a></li>
        <li><a href="<?php echo $base_url; ?>/blog">Blog</a></li>
        <li><a href="<?php echo $base_url; ?>/contact">Contact us</a></li>
        <li><a href="<?php echo $base_url; ?>/stock">Buy Stock</a></li>
      </ul>
    </nav>
  </div><!--end of header holder-->
</header>

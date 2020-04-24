<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="Wholesale Jeans, Jeans Wholesalers, Wholesale Denim Pants"/>
  <meta name="description" content="PK Apparel Specializes in jeans pants manufacturing and wholesale, jeans Jackets wholesale, Jeans Shirt and all other denim products. We stand behind all of the products that we handle and we are the company that stand behind the quality and performance of the products they build"/>
  <meta name="google-site-verification" content="tq6NZzCuCj2a7kvdssFcuBKb8z0BdAjdUhS4e_IuiNY" />
  <title>Confirm Order</title>
  <link rel="icon" href="images/favicon.png" type="image/png">
  <link type="text/css" rel="stylesheet" href="css/stylesheet.css">
</head>
<body>
<div class="wrapper">
  <header>
    <div class="holder clearfix">
      <div class="head-contact clearfix">
        <div class="clearfix">
          <a href="/" class="logo">
            <img src="images/logo.jpg" alt="logo" width="200" title="PK Apparel Home">
          </a>
          <nav id="nav" class="open-close">
            <a href="" class="opener">Menu</a>
            <ul class="navigation">
              <li><a href="/">Home</a></li>
              <li><a href="about">About us</a></li>
              <li><a href="factory">Factory</a></li>
              <li><a href="jeans-pants.php">Jeans Pants</a></li>
              <li><a href="jeans-shirts.php">Jeans Shirts</a></li>
              <li><a href="blog">Blog</a></li>
              <li><a href="contact">Contact us</a></li>
            </ul>
          </nav>
          <ul class="social-network">
            <li><a href="https://www.facebook.com/pkapparelfactory" target="_blank">facebook</a></li>
            <li class="instagram"><a href="https://www.instagram.com/pkapparelfactory" target="_blank">instagram</a></li>
            <li class="twitter"><a href="https://www.twitter.com/pkapparelfactry" target="_blank">twitter</a></li>
          </ul>
        </div>
      </div>
      <nav class="main-menu">
        <ul>
            <li><a href="about">About us</a></li>
            <li><a href="factory">Factory</a></li>
            <li><a href="jeans-pants.php">Jeans Pants</a></li>
            <li><a href="jeans-shirts.php">Jeans Shirts</a></li>
            <li><a href="blog">Blog</a></li>
            <li><a href="contact">Contact us</a></li>
        </ul>
      </nav>
    </div><!--end of header holder-->
  </header>
  <div id="main">
      <div id="content">
          <div class="confirm-payment">
              <div class="big-gap">
                  <h2 class="payment-heading">Please enter details</h2>
                  <form method="post" action="payment.php">
                      <div class="input-wrap">
                          <label for="InvoiceID">Invoice ID</label>
                          <input type="number" id="InvoiceID" name="invoice-id" required>
                          <span class="error-alert"></span>
                      </div>
                      <div class="input-wrap">
                          <label for="InvoiceAmount">Invoice Amount (USD)</label>
                          <input type="number" id="InvoiceAmount" name="invoice-amount" required>
                          <span class="error-alert"></span>
                      </div>
                      <div class="input-wrap">
                          <input type="submit" value="Confirm Order">
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div><!-- end of main -->
  <?php include_once 'footer.php';?>
</div> <!-- end of wrapper -->
<script type="text/javascript" src="js/jquery-3.3.1.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
        a = s.createElement(o), m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-71901684-1', 'auto');
    ga('send', 'pageview');
</script>
</body>
</html>
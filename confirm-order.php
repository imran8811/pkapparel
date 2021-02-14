<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="Wholesale Jeans, Jeans Wholesalers, Wholesale Denim Pants"/>
  <meta name="description" content="PK Apparel Specializes in jeans pants manufacturing and wholesale, jeans Jackets wholesale, Jeans Shirt and all other denim products. We stand behind all of the products that we handle and we are the company that stand behind the quality and performance of the products they build"/>
  <meta name="google-site-verification" content="tq6NZzCuCj2a7kvdssFcuBKb8z0BdAjdUhS4e_IuiNY" />
  <title>Confirm Order</title>
  <link rel="icon" href="./assets/images/favicon.png" type="image/png">
  <link type="text/css" rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<div class="wrapper">
  <?php include_once('./header-menu.php'); ?>
  <div class="main">
    <div id="content">
      <div class="confirm-payment">
        <div class="big-gap">
          <h2 class="payment-heading">Please enter details</h2>
          <form method="post" action="payment">
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
  <?php include_once './footer.php';?>
</div> <!-- end of wrapper -->
<script type="text/javascript" src="./assets/jsjquery-3.5.1.js"></script>
<script type="text/javascript" src="./assets/jscustom.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-71901684-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-71901684-1');
</script>
</body>
</html>
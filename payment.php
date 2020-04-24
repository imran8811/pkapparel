<?php
	$MerchantID     = "00157561"; //Your Merchant from transaction Credentials
	$Password       = "01s80xv0de"; //Your Password from transaction Credentials
	$ReturnURL      = "https://www.pkapparel.com/payment-return.php"; //Your Return URL
	$HashKey 		= "05y2tb7598";//Your HashKey integrity salt from transaction Credentials
	$PostURL 		= "https://payments.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform";

	date_default_timezone_set("Asia/karachi");
	$currentDollarRate = 160;
	$userEnteredUSD = $_POST['invoice-amount'];
	$userInputAmount = $_POST['invoice-amount']*$currentDollarRate*100;
	$userInputInvoiceID = $_POST['invoice-id'];
//	print_r($_POST['invoice-id']);
//	print_r($_POST['invoice-amount']);
	$Amount = $userInputAmount; //Last two digits will be considered as Decimal
	$BillReference = $userInputInvoiceID;
	$Description = "This is description";
	$Language = "EN";
	$TxnCurrency = "PKR";
	$TxnDateTime = date('YmdHis') ;
	$TxnExpiryDateTime = date('YmdHis', strtotime('+8 Days'));
	$TxnRefNumber = "TXN".date('YmdHis');
	$TxnType = "";
	$Version = '1.1';
	$SubMerchantID = "";
	$DiscountedAmount = "";
	$DiscountedBank = "";
	$ppmpf_1="";
	$ppmpf_2="";
	$ppmpf_3="";
	$ppmpf_4="";
	$ppmpf_5="";

	$HashArray=[$Amount,$BillReference,$Description,$DiscountedAmount,$DiscountedBank,$Language,$MerchantID,$Password,$ReturnURL,$TxnCurrency,$TxnDateTime,$TxnExpiryDateTime,$TxnRefNumber,$TxnType,$Version,$ppmpf_1,$ppmpf_2,$ppmpf_3,$ppmpf_4,$ppmpf_5];

	$SortedArray=$HashKey;
	for ($i = 0; $i < count($HashArray); $i++) {
		if($HashArray[$i] != 'undefined' AND $HashArray[$i]!= null AND $HashArray[$i]!="" )
		{
			$SortedArray .="&".$HashArray[$i];
		}
	}
	$Securehash = hash_hmac('sha256', $SortedArray, $HashKey);
?>
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
	<?php include_once('./header-menu.php'); ?>
	<div id="main">
		<div id="content" class="confirm-payment">
			<div class="big-gap width-50">
				<h2 class="payment-heading">Please confirm below details:</h2>
				<table>
					<tr>
						<td>Invoice ID</td>
						<td><?php echo $userInputInvoiceID ?></td>
					</tr>
					<tr>
						<td>Invoice Amount (USD)</td>
						<td><?php echo $userEnteredUSD ?></td>
					</tr>
				</table>
<!--				<div id="header"></div>-->
				<form method="post" action="<?php echo $PostURL; ?>"/>
					<input type="hidden" name="pp_Version" value="<?php echo $Version; ?>" />
					<input type="hidden" name="pp_TxnType" value="<?php echo $TxnType; ?>" />
					<input type="hidden" name="pp_Language" value="<?php echo $Language; ?>" />
					<input type="hidden" name="pp_MerchantID" value="<?php echo $MerchantID; ?>" />
					<input type="hidden" name="pp_SubMerchantID" value="<?php echo $SubMerchantID; ?>" />
					<input type="hidden" name="pp_Password" value="<?php echo $Password; ?>" />
					<input type="hidden" name="pp_TxnRefNo" value="<?php echo $TxnRefNumber; ?>"/>
					<input type="hidden" name="pp_Amount" value="<?php echo $Amount; ?>" />
					<input type="hidden" name="pp_TxnCurrency" value="<?php echo $TxnCurrency; ?>"/>
					<input type="hidden" name="pp_TxnDateTime" value="<?php echo $TxnDateTime; ?>" />
					<input type="hidden" name="pp_BillReference" value="<?php echo $BillReference ?>" />
					<input type="hidden" name="pp_Description" value="<?php echo $Description; ?>" />
					<input type="hidden" id="pp_DiscountedAmount" name="pp_DiscountedAmount" value="<?php echo $DiscountedAmount ?>">
					<input type="hidden" id="pp_DiscountBank" name="pp_DiscountBank" value="<?php echo $DiscountedBank ?>">
					<input type="hidden" name="pp_TxnExpiryDateTime" value="<?php echo  $TxnExpiryDateTime; ?>" />
					<input type="hidden" name="pp_ReturnURL" value="<?php echo $ReturnURL; ?>" />
					<input type="hidden" name="pp_SecureHash" value="<?php echo $Securehash; ?>" />
					<input type="hidden" name="ppmpf_1" value="<?php echo $ppmpf_1; ?>" />
					<input type="hidden" name="ppmpf_2" value="<?php echo $ppmpf_2; ?>" />
					<input type="hidden" name="ppmpf_3" value="<?php echo $ppmpf_3; ?>" />
					<input type="hidden" name="ppmpf_4" value="<?php echo $ppmpf_4; ?>" />
					<input type="hidden" name="ppmpf_5" value="<?php echo $ppmpf_5; ?>" />
					<!--    <button id="submit" type="submit"><img src="jazzcash.png" /></button>-->
					<input type="submit" id="submit" value="Confirm &amp; Pay Now" />
				</form>
			</div>
		</div>
	</div><!-- end of main -->
	<?php include_once('footer.php'); ?>
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

<?php
	$currentDollarRate = 160;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="Wholesale Jeans, Jeans Wholesalers, Wholesale Denim Pants"/>
	<meta name="description" content="PK Apparel Specializes in jeans pants manufacturing and wholesale, jeans Jackets wholesale, Jeans Shirt and all other denim products. We stand behind all of the products that we handle and we are the company that stand behind the quality and performance of the products they build"/>
	<meta name="google-site-verification" content="tq6NZzCuCj2a7kvdssFcuBKb8z0BdAjdUhS4e_IuiNY" />
	<title>Payment Successful</title>
	<link rel="icon" href="./assets/images/favicon.png" type="image/png">
	<link type="text/css" rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<div class="wrapper">
	<?php include_once('./header-menu.php'); ?>
	<div class="main">
		<div id="content">
			<div class="big-gap width-50">
				<?php
				$HashKey= "05y2tb7598"; //Your Hash Key
				$ResponseCode =$_POST['pp_ResponseCode'];
				$ResponseMessage = $_POST['pp_ResponseMessage'];
				$Response = "";
				$comment = "";
				$ReceivedSecureHash = $_POST['pp_SecureHash'];
				$sortedResponseArray = array();
				if (!empty($_POST)) {
					foreach ($_POST as $key => $val) {
						$comment .= $key . "[" . $val . "],<br/>";
						$sortedResponseArray[$key] = $val;
					}
				}
				ksort($sortedResponseArray);
				unset($sortedResponseArray['pp_SecureHash']);
				$Response=$HashKey;
				foreach ($sortedResponseArray as $key => $val) {
					if ($val!=null and $val!="") {
						$Response.='&'.$val;
					}
				}
				$GeneratedSecureHash= hash_hmac('sha256', $Response, $HashKey);
				if (strtolower($GeneratedSecureHash) == strtolower($ReceivedSecureHash)) {
					$txnRefNo = $_POST['pp_TxnRefNo'];
					$reqAmount = $_POST['pp_Amount']/100;
					$reqDatetime = $_POST['pp_TxnDateTime'];
					$reqBillref = $_POST['pp_BillReference'];
					$reqRetrivalRefNo = $_POST['pp_RetreivalReferenceNo'];

					if($ResponseCode == '000'||$ResponseCode == '121'||$ResponseCode == '200'){
						echo "Thanks for your Order, <br><br> Your Payment of $".$reqAmount / $currentDollarRate." has been Successful. <br><br>Your Transaction ID is ".$txnRefNo. "<br><br>";
//						echo $ResponseCode."Transaction Message=".$ResponseMessage . "<br>";
						echo "Please note down your Transaction ID for future reference.";
						//send success mail
						$email         	= 'info@pkapparel.com';
						$to             = 'imran@pkapparel.com';
						$headers 		= 'From:' . $email . "\r\n" . 'Reply-To:' . $email . "\r\n";
						$subject        = "Transaction Successful";
						$msg            = "Transaction ID : ".$txnRefNo."\r\n". "Amount : ".$reqAmount."\r\n";
						if(@mail($to,$subject,$msg,$headers)){

						} else {
							
						}
					}
					else  if($ResponseCode == '124'||$ResponseCode == '210') {
						echo "Your voucher No is:".$reqRetrivalRefNo." of amount ".$reqAmount." has been successfully generated. Visit any JazzCash shop and pay the amount before the expiry date";
						echo $ResponseCode."Transaction Message=".$ResponseMessage;
						// do your handling for pending
					}
					else {
						echo "Sorry, your Payment of RS:".$reqAmount." against order no ".$txnRefNo." has been Failed. please try again." . "<br><br>";
						echo $ResponseCode."Transaction Message= ".$ResponseMessage. "<br><br>";
						echo "<a href='https://www.pkapparel.com/confirm-order.php'>Go Back</a>";
					}
				}
				else {
					echo "mismatched, marked it suspicious or reject it";
				}
				?>
			</div>
		</div>
	</div><!-- end of main -->
	<?php include_once('footer.php'); ?>
</div> <!-- end of wrapper -->
<script type="text/javascript" src="./assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="./assets/js/custom.js"></script>
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
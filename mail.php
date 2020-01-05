<?php
//getStatus();
//function getStatus(){
	if(isset($_POST['send_inquiry'])) {
//		$name        	= $_REQUEST['user_name'];
		$email         	= $_REQUEST['user_email'];
		$contact        = $_REQUEST['user_contact'];
		$details        = $_REQUEST['inquiry_details'];
		$to             = 'info@pkapparel.com';
		$headers 		= 'From:' . $email . "\r\n" . 'Reply-To:' . $email . "\r\n";
		$subject        = "Quote from website";
		$msg            = "Contact : ".$contact."\r\n"."Details : ".$details."\r\n";
		if(@mail($to,$subject,$msg,$headers)){
			echo "1";
		} else {
			echo "0";
		}
	} else {
		echo "0";
	}
//}

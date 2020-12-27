<?php
	include_once("header.php");
	$user = new User();
	if($user->is_logged()){
		header("Location:index");
	};
	if(isset($_GET['e'])){
		$verify_user = "";
		$email = $_GET['e'];
		$email_exist = false;
		$email_exist = $user->user_exist($email);
		if($email_exist) {
			$verify_user = $user->verify_user($email);
		}
		if(!$email_exist) {
			echo "<br><h2 class='msg-error'>Email Not Found</h2>";
		}
		if($verify_user == "007") {
			echo "<br><h2 class='msg-error'>Email already verified</h2>";
		} else if($verify_user == "1") {
			echo "<br><h2 class='msg-success'>Email has been verified</h2>";
		} else if($verify_user == "0") {
			echo "<br><h2 class='msg-error'>Can't verify, try later</h2>";
		}
	}

//	if(isset($_SERVER['HTTP_REFERER'])){
//		$url = $_SERVER["HTTP_REFERER"];
//	} else {
//		$url = "index.php";
//	}
//	if(isset($_SESSION['user_id'])){
//		header("Location: $url");
//	}
?>
<div class="login-page">
	<?php if(isset($_GET['m']) == 1) { ?>
		<span class="msg-block">Registration Successful!</span>
	<?php } ?>
	<div class="login-area">
		<div class="login-form">
			<h2>Sign in</h2>
			<span class="show-msg"></span>
			<form class="form-login">
				<div class="input-wrap clearfix">
					<label for="user-email">Email</label>
					<input type="text" id="user-email" name="user_email" class="user-email">
					<span class="error-alert"></span>
				</div>
				<div class="input-wrap clearfix">
					<label for="user-pass">Password</label>
					<input type="password" id="user-pass" name="user_pass" class="user-pass">
					<span class="error-alert"></span>
				</div>
				<div class="input-wrap margin-top-40 clearfix">
					<a href="forgot-pass.php" class="forgot-pass">Forgot Password?</a>
					<input type="submit" value="Sign in" class="btn-submit">
				</div>
			</form>
			<div class="input-wrap clearfix">
				<p class="link-signup">New to Lahori Jeans? <a href="register.php">Join Now!</a></p>
			</div>
		</div>
	</div>
</div>
<?php include_once("footer.php"); ?>
<?php include_once("assets/js/loginjs.php"); ?>
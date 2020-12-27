<?php
	include_once("header.php");
	if(User::is_logged()){
		header("Location:index");
	}
?>
<div class="login-page">
	<div class="login-area">
		<div class="login-form register-form">
			<h2>Join Lahori Jeans Now!</h2>
			<span class="show-msg"></span>
			<form action="#" class="form-reg">
				<div class="input-wrap clearfix">
					<label for="user-name">Full Name*</label>
					<input type="text" id="user-name" name="full_name" class="user-name">
					<span class="error-alert"></span>
				</div>
				<div class="input-wrap clearfix">
					<label for="user-email">Email*</label>
					<input type="text" id="user-email" name="user_email" class="user-email">
					<span class="error-alert"></span>
				</div>
				<div class="input-wrap clearfix">
					<label for="user-password">Password*</label>
					<input type="password" id="user-password" name="user_password" class="user-password">
					<span class="error-alert"></span>
				</div>
				<div class="input-wrap clearfix">
					<label for="mobile-no">Mobile No.* <span class="text-small">(e.g 03001234567)</span> </label>
					<input type="text" id="mobile-no" class="mobile-no" name="mobile_no">
					<span class="error-alert"></span>
				</div>
				<div class="input-wrap clearfix">
					<input type="submit" value="Join" class="btn-submit" id="user-join" name="user_join">
				</div>
			</form>
			<div class="input-wrap clearfix">
				<p class="link-signup">Already have an account? <a href="login.php">Sign in</a></p>
			</div>
		</div>
	</div>
</div>
<?php include_once("footer.php"); ?>
<script>
	$(".form-reg").on("submit", function (e) {
		e.preventDefault();
		var full_name	= $(".form-reg .user-name").val();
		var	email		= $(".form-reg .user-email").val();
		var	password	= $(".form-reg .user-password").val();
		var	mobile_no	= $(".form-reg .mobile-no").val();
		function validate_register_form(){
			var v_full_name		= false;
			var	v_email			= false;
			var v_password		= false;
			var v_mobile_no		= false;
			function validateMobile(number){
				var reg = new RegExp('^[0-9]+$');
				return reg.test(number);
			}
			function validateEmail(email){
				var re = /\S+@\S+\.\S+/;
				return re.test(email);
			}
			if(full_name == ""){
				$(".form-reg .user-name").siblings(".error-alert").text("Required");
				$(".form-reg .user-name").addClass("input-error");
			} else if(full_name.length < 3){
				$(".form-reg .user-name").siblings(".error-alert").text("Minimum 3 characters");
				$(".form-reg .user-name").addClass("input-error");
			} else {
				$(".form-reg .user-name").siblings(".error-alert").text("");
				$(".form-reg .user-name").removeClass("input-error");
				v_full_name = true;
			}

			if(email == ""){
				$(".form-reg .user-email").siblings(".error-alert").text("Required");
				$(".form-reg .user-email").addClass("input-error");
			} else if(!validateEmail(email)){
				$(".form-reg .user-email").siblings(".error-alert").text("Invalid Email");
				$(".form-reg .user-email").addClass("input-error");
			} else {
				$(".form-reg .user-email").siblings(".error-alert").text("");
				$(".form-reg .user-email").removeClass("input-error");
				v_email = true
			}

			if(password == ""){
				$(".form-reg .user-password").siblings(".error-alert").text("Required");
				$(".form-reg .user-password").addClass("input-error");
			} else if(password.length < 8){
				$(".form-reg .user-password").siblings(".error-alert").text("Minimum 8 characters");
				$(".form-reg .user-password").addClass("input-error");
			} else {
				$(".form-reg .user-password").siblings(".error-alert").text("");
				$(".form-reg .user-password").removeClass("input-error");
				v_password = true;
			}

			if(mobile_no == ""){
				$(".form-reg .mobile-no").siblings(".error-alert").text("Required");
				$(".form-reg .mobile-no").addClass("input-error");
			} else if(mobile_no.length < 10){
				$(".form-reg .mobile-no").siblings(".error-alert").text("invalid number");
				$(".form-reg .mobile-no").addClass("input-error");
			} else if(!validateMobile(mobile_no)){
				$(".form-reg .mobile-no").siblings(".error-alert").text("Only numbers allowed");
				$(".form-reg .mobile-no").addClass("input-error");
			} else {
				$(".form-reg .mobile-no").siblings(".error-alert").text("");
				$(".form-reg .mobile-no").removeClass("input-error");
				v_mobile_no = true;
			}

			if(v_full_name && v_email && v_password && v_mobile_no){
				return true;
			} else {
				return false;
			}
		}
		if(validate_register_form()){
			$(".gif").show().text("loading...");
			$.ajax({
				type : "POST",
				url : "<?php echo $base_url; ?>api.php",
				data :  {
					full_name	: full_name,
					email		: email,
					password	: password,
					mobile_no	: mobile_no,
					user_join	: "1"
				},
				success : function (res) {
					if (res === '1') {
						$(".gif").hide();
//						$(".show-msg").text("Registration successful").removeClass("msg-error").addClass("msg-success").show().delay(8000).fadeOut("slow");
						window.location.href = "login.php?m=1";
					} else if (res === "008") {
						$(".gif").hide();
						$(".show-msg").replaceWith("<span class='show-msg msg-error'>Email already exists, try " + "<br><a href='login.php'>login</a> or " + "<a href='forgot-pass.php'>Forgot Password</a></span>").addClass("msg-error").show().delay(8000).fadeOut("slow");
					} else {
						$(".gif").hide();
						$(".show-msg").text("Server Error, Try Later").addClass("msg-error").show().delay(8000).fadeOut("slow");
					}
				}
			})
		}
	});
</script>

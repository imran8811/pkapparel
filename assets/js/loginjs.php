<script>
    $(".form-login").on("submit", function (e) {
        e.preventDefault();
        var email           = $(".form-login .user-email").val();
        var password        = $(".form-login .user-pass").val();
        function validate_login_form(){
            var	v_email = false;
            var v_password =  false;
            function validateEmail(email){
                var re = /\S+@\S+\.\S+/;
                return re.test(email);
            }

            if(email == ""){
                $(".form-login .user-email").siblings(".error-alert").text("Required");
                $(".form-login .user-email").addClass("input-error");
            } else if(!validateEmail(email)){
                $(".form-login .user-email").siblings(".error-alert").text("Invalid Email");
                $(".form-login .user-email").addClass("input-error");
            } else {
                $(".form-login .user-email").siblings(".error-alert").text("");
                $(".form-login .user-email").removeClass("input-error");
                v_email = true
            }

            if(password == ""){
                $(".form-login .user-pass").siblings(".error-alert").text("Required");
                $(".form-login .user-pass").addClass("input-error");
            } else {
                $(".form-login .user-pass").siblings(".error-alert").text("");
                $(".form-login .user-pass").removeClass("input-error");
                v_password = true;
            }

            if(v_email && v_password){
                return true;
            } else {
                return false;
            }
        }
        if(validate_login_form()){
            $(".gif").show().text("loading...")
            $.ajax({
                type: "POST",
                url: "<?php echo $base_url; ?>/api.php",
                data: {
                    login: 1,
                    email: email,
                    pass: password
                },
                success: function (res) {
                    if (res === "1") {
                        window.location.href = "<?php echo $base_url; ?>"
                    } else {
                        $(".gif").hide();
                        $(".show-msg").text("Invalid Email/Password").addClass("msg-error").show();
                    }
                }
            })
        }
    });
    //	$(document).on("click", ".email-resend", function(e){
    //		e.preventDefault();
    //		var email = $("#user-email").val();
    //		$.ajax({
    //			type: "POST",
    //			url: "<?php //echo $base_url; ?>//api.php",
    //			data: {
    //				email: email,
    //				rsnd_lnk:1
    //			},
    //			success: function(res){
    //				console.log(res);
    //			}
    //		})
    //	});
</script>
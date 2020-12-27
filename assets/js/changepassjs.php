<script>
    function validate_change_pass(){
        var password           = $(".changepass-form .new-pass").val();
        var confirm_password        = $(".changepass-form .confirm-pass").val();
        var v_password =  false;
        var	v_pass_confirm = false;

        if(password == ""){
            $(".changepass-form .new-pass").siblings(".error-alert").text("Required");
            $(".changepass-form .new-pass").addClass("input-error");
        } else if(password.length < 8){
            $(".changepass-form .new-pass").siblings(".error-alert").text("Minimum 8 characters");
            $(".changepass-form .new-pass").addClass("input-error");
        } else {
            $(".changepass-form .new-pass").siblings(".error-alert").text("");
            $(".changepass-form .new-pass").removeClass("input-error");
            v_password = true;
        }
        if(confirm_password == ""){
            $(".changepass-form .confirm-pass").siblings(".error-alert").text("Required");
            $(".changepass-form .confirm-pass").addClass("input-error");
        }else if(confirm_password != password){
            $(".changepass-form .confirm-pass").siblings(".error-alert").text("Password doesn't match");
            $(".changepass-form .confirm-pass").addClass("input-error");
        } else {
            $(".changepass-form .confirm-pass").siblings(".error-alert").text("");
            $(".changepass-form .confirm-pass").removeClass("input-error");
            v_pass_confirm = true;
        }

        if(v_pass_confirm && v_password){
            return true;
        } else {
            return false;
        }
    }
    $(".changepass-form").on("submit", function(e){
        e.preventDefault();
        if(validate_change_pass()) {
            $(".gif").show().text("loading...");
            $.ajax({
                type: "POST",
                url: "<?php echo $base_url; ?>api.php",
                data: {
                    update_pass: 1,
                    user_id: <?php echo $_SESSION["user_id"]; ?>,
                    new_pass: $(".new-pass").val()
                },
                success: function(res){
                    $(".gif").hide();
                    if(res === "001"){
                        $.alert({
                            title: "",
                            content: "New password cannot be same as old password",
                            useBootstrap: false,
                            type: "red",
                            boxWidth: "25%"
                        });
                    } else if(res =='1'){
                        $.alert({
                            title: "",
                            content: "Password Changed Successfully.",
                            useBootstrap: false,
                            type: "green",
                            boxWidth: "20%"
                        });
                        $(".changepass-form .new-pass").val("");
                        $(".changepass-form .confirm-pass").val("");
                        $(".changepass-form .confirm-pass:focus").blur();
                    } else {
                        $.alert({
                            title: "",
                            content: "Cannot changed password, try later",
                            useBootstrap: false,
                            type: "green",
                            boxWidth: "20%"
                        });
                    }
                }
            })
        }
    })
</script>
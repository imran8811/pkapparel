<script>

    $("#checkout-login-form").on("submit", function (e) {
        e.preventDefault();
        $(".loader").show();
        var email = $(".chk-email").val();
        var pass = $(".chk-pass").val();
        $.ajax({
            type: "POST",
            url: "<?php echo $base_url . '/api.php' ?>",
            data: {
                email: email,
                pass: pass,
                login: 1
            },
            success: function (res) {
                if (res === "1") {
                    location.reload();
                } else {
                    $(".loader").hide();
                    $(".user-login .msg-error").text("Invalid Email/Password");
                }
            }
        });
    });

    $(".single-add:not(:last)").on("click", function(e){
        e.preventDefault();
        $(this).addClass("selected").siblings().removeClass("selected");
    });
    $(".checkout-overlay").each(function(){
        var parentHeight = $(this).parent().height();
        $(this).css("height", parentHeight);
    })

    function recount_total_amount (){
        var total_amount = 0;
        $(".checkout-summary tbody tr").each(function(){
            var total_qty = 0;
            $(this).find(".j-calcqty li").each(function(){
                total_qty += parseInt($(this).text());
            });
            total_amount += parseInt(total_qty) * parseInt($(this).find(".item-amount").text());
            $(".checkout-confirm .pro-price").text(total_amount);
        })
    }
    recount_total_amount();
    $(".form-addaddress").on("submit", function(e){
        e.preventDefault();
        $(".gif").text("Adding...").show();
        $.ajax({
            type:"POST",
            url: "<?php echo $base_url; ?>/api.php",
            data: {
              add_address: 1,
              address : $(".form-addaddress .add-input").val(),
              address_continue : $(".form-addaddress .add-cont-input").val(),
              city: $(".form-addaddress .add-cities option:selected").text()
            },
            success: function(res){
              $(".gif").hide();
              if(res == 1){
                $.alert({
                  title: "Success",
                  content: 'Address Added',
                  type: 'green',
                  boxWidth: '30%',
                  useBootstrap: false,
                  animation: 'zoom',
                  animationSpeed: 200,
                  onClose: function(){
                    location.reload();
                  }
                });
              } else {
                $.alert({
                  title: "Error",
                  content: 'Server Error, try later',
                  type: 'red',
                  boxWidth: '30%',
                  useBootstrap: false,
                  animation: 'zoom',
                  animationSpeed: 200
                });
              }
            }
        })
    })

    $(".j-confirm-order").on("click", function(e){
        e.preventDefault();
        $(".gif").text('Working...').show();
        var add_id = $(".addresses .selected").data('id');
        var accessory = $(".section-accessory input[name=accessory]:checked").val();
        var shipping = $(".section-shipping input[name=cargo]:checked").val();
        var payment = $(".section-payment input[name=payment]:checked").val();
        var total_amount = $(".checkout-confirm .pro-price").text();
        console.log(add_id, accessory, shipping, payment);
        $.ajax({
            type: "POST",
            url: "<?php echo $base_url . '/api.php' ?>",
            data: {
                confirm_order: 1,
                add_id: add_id,
                accessory: accessory,
                shipping: shipping,
                payment: payment,
                total_amount: total_amount
            },
            success: function (res) {
                var jsonCoded = JSON.parse(res);
                localStorage.setItem("order_no", jsonCoded.order_no);
                if (jsonCoded.order_no != "") {
                    $(".gif").hide();
                    location.href = base_url + "confirm-order.php?o=" + jsonCoded.order_no + "&u=" + "<?php echo sha1(isset($_SESSION['user_id'])); ?>";
                } else {
                    $(".gif").hide();
                    $.alert({
                        title: "Error!",
                        content: 'Server Error, Try Later',
                        type: 'red',
                        boxWidth: '30%',
                        useBootstrap: false,
                        animation: 'zoom',
                        animationSpeed: 200
                    });
                }
            }
        });
    })
</script>
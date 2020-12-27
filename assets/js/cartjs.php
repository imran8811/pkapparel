<script>
    function recount_total_amount (){
        var total_amount = 0;
        $(".cart-hover .cart-wrap").each(function(){
            total_amount += parseInt($(this).find(".qty").text()) * parseInt($(this).find(".unit-amount").text());
            $(".amount-wrap .total-amount").text(total_amount);
        })
    }
    recount_total_amount();

    $(".cart-wrap .btn-remove").on("click", function (e) {
        e.preventDefault();
        var self = $(this);
        var elm_hide = $(".cart-hover");
        var cart_items_count = $(".link-cart .total-cart").text();
        $.ajax({
            type: "POST",
            url: "<?php echo $base_url  . '/api.php' ?>",
            data: {
                cart_remove: 1,
                p_id: $(this).data("id")
            },
            success: function (res) {
                if (res === "1") {
                    recount_total_amount();
                    self.closest(".cart-wrap").remove();
                    var new_cart_item_count = cart_items_count - 1;
                    $(".link-cart .total-cart").text(new_cart_item_count);
                    var new_val = $(".link-cart .total-cart").text();
                    if (new_val === '0') {
                        elm_hide.hide();
                    }
                    $.alert({
                        title: "Success",
                        content: 'Item removed from cart',
                        type: 'green',
                        boxWidth: '30%',
                        useBootstrap: false,
                        animation: 'zoom',
                        animationSpeed: 200,
                        onClose: function(){
                            location.reload();
                        }
                    });
                }
            }
        })
    });

    $(".td-edit .link-remove").on("click", function (e) {
        e.preventDefault();
        var self = $(this);
        var cart_items_count = $(".link-cart .total-cart").text();
        $.ajax({
            type: "POST",
            url: base_url + "/api.php",
            data: {
                cart_remove: 1,
                p_id: $(this).data("id")
            },
            success: function (res) {
                if (res === "1") {
                    self.closest("tr").remove();
                    var new_cart_item_count = parseInt(cart_items_count - 1);
                    $(".link-cart .total-cart").text(new_cart_item_count);
                    if (new_cart_item_count == '0') {
                        location.reload();
                    } else {
                        calculateCartSum();
                    }
                }
            }
        })
    });

    $(".empty-cart").on("click", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?php echo $base_url  . '/api.php' ?>",
            data: {
                empty_cart: 1
            },
            success: function (res) {
                if (res === "1") {
                    $.alert({
                        title: "Success",
                        content: 'All Items removed from cart',
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
                        content: 'Server Error, Try Later',
                        type: 'red',
                        boxWidth: '30%',
                        useBootstrap: false,
                        animation: 'zoom',
                        animationSpeed: 200
                    });
                }
            }
        })
    });

</script>
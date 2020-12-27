<script>
    $(".add-cart").on("click", function(e){
      e.preventDefault();
      var cart_validated = validateCart();
      if(cart_validated){
        var size_qty = {};
        $(".cart-qty select").each(function(index){
          var get_size = $(this).find("option:selected").val();
          var size = $(this).data("id");
          if(get_size > 0){
            size_qty[size] = $(this).find("option:selected").val();
          }
        });
        $.ajax({
            type:"POST",
            url: "<?php echo $base_url; ?>/api.php",
            data: {
              p_id: '<?php echo $p_id ?>',
              sizes_qty : size_qty,
              add_cart: 1
            },
            success: function(data){
              if(data != "007"){
                if(data != ""){
                  $(".total-cart").html(data);
                  $.alert({
                    title: "Success",
                    content: 'Item added in cart',
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
                    title: "Error!",
                    content: 'Server Error, Try Later',
                    type: 'red',
                    boxWidth: '30%',
                    useBootstrap: false,
                    animation: 'zoom',
                    animationSpeed: 200
                  });
                }
              } else {
                $.alert({
                  title: "Error!",
                  content: 'Item already exist in cart',
                  type: 'red',
                  boxWidth: '30%',
                  useBootstrap: false,
                  animation: 'zoom',
                  animationSpeed: 200
                });
              }
            }
          })
        }
    });

    $(".cart-qty select").change(function(){
      calculateTotal();
    });

    function calculateTotal(){
      var total_qty = 0;
      $(".cart-qty select").each(function(){
          total_qty += parseInt($(this).find("option:selected").val()) || 0;
      });
      $(".notice-list .t-pcs").text(total_qty);
      var proPrice = parseInt($(".title-area .pro-price").text()) * total_qty;
      $(".notice-list .t-amount").text(proPrice);
    }

    function validateCart(){
      var qty_check = 0;
      $(".cart-qty select option:selected").each(function(){
        if($(this).val() > 0){
          qty_check++
        }
      });
      if(qty_check == 0){
        $.dialog({
          title: "Error!",
          content: 'Select Quantity',
          type: 'red',
          boxWidth: '30%',
          useBootstrap: false,
          animation: 'zoom',
          animationSpeed: 200
        });
        return false;
      } else if(qty_check == 1){
        $.alert({
          title: "Error!",
          content: 'Buy at least 2 sizes',
          type: 'red',
          boxWidth: '30%',
          useBootstrap: false,
          animation: 'zoom',
          animationSpeed: 200
        });
        return false;
      } else {
          return true;
      }
    }

    $(".view-later").on("click", function(e){
        e.preventDefault();
        if($(this).html() === "Save for later view"){
            $.ajax({
                type:"POST",
                url: "<?php echo $base_url; ?>/api",
                data: {
                    p_id:'<?php echo $p_id ?>',
                    save_item: 1
                },
                success: function(data){
                    if(data === "1"){
                        $(".view-later").html("Saved");
                    }
                }
            })
        } else {
            window.location = "saved-items.php";
        }
    });
</script>
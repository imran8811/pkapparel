<?php
  include_once("./init.php");
  if(!isset($_SESSION['user_id'])){
      header("Location: login.php");
  }
  $misc = new Misc();
  $profile = new Profile();
  $get_addresses = $profile->get_user_addresses();
	$get_cities = $misc->get_cities();
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
  <link rel="icon" href="./assets/images/favicon.png" type="image/png">
  <link type="text/css" rel="stylesheet" href="./assets/css/style.css">
  <link type="text/css" rel="stylesheet" href="./assets/css/style-wholesale.css">
</head>
<body>
<div class="wrapper">
  <?php include_once('./header-menu.php'); ?>
  <div class="main">
  <div class="page-accounts clearfix">
    <?php include_once('user-sidebar.php'); ?>
    <div class="acc-content">
        <h1>Addresses</h1>
        <div class="inner-wrap">
            <ul class="add-list">
                <?php foreach($get_addresses as $address): ?>
                <li <?php echo $address['add_status'] == '1' ?' class="active"' : "" ?>>
                    <p>
                        <span class="user-add"><?php echo $address['address']; ?></span>,
                        <span class="user-add-cont"><?php echo $address['add_continue']; ?></span>
                    </p>
                    <p><span class="user-city"><?php echo $address['ad_city']; ?></span></p>
                    <div class="add-links">
                        <div>
                            <a href="#edit-popup" rel="modal:open" data-id="<?php echo $address['address_id']; ?>" class="btn-edit j-btnedit">Edit</a>
                        </div>
                        <?php if(count($get_addresses) > 1){ ?>
                            <div>
                                <a href="#" data-id="<?php echo $address['address_id']; ?>" class="btn-edit j-deladdress">Delete</a>
                            </div>
                        <?php } ?>

	                    <?php if($address['add_status'] != '1'): ?>
                            <div class="make-default">
                                <a href="#" data-id="<?php echo $address['address_id']; ?>">Make Default</a>
                            </div>
		                <?php endif; ?>
                    </div>
                </li>
                <?php endforeach; ?>
                <li class="add-new">
                    <a href="#add-popup" rel="modal:open">Add new address</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="edit-popup" style="display:none;" class="add-popup">
    <h2 class="add-heading">Edit Address</h2>
    <form action="#" class="form-edit-address">
        <input type="text" placeholder="address" value="" class="add-input">
        <input type="text" placeholder="address continue" value="" class="add-cont-input">
	    <select class="add-cities">
            <option>Select City</option>
		    <?php foreach($get_cities as $city): ?>
			    <option value="<?php echo $city['city_name']; ?>"><?php echo $city['city_name']; ?></option>
		    <?php endforeach; ?>
	    </select>
	    <input type="submit" value="Save" class="btn-submit">
    </form>
</div>
<div id="add-popup" style="display:none;" class="add-popup">
    <h2 class="add-heading">Add New Address</h2>
    <form action="#" class="form-add-address">
        <input type="text" placeholder="address" value="" class="add-input">
        <input type="text" placeholder="address continue" value="" class="add-cont-input">
        <select class="add-cities">
            <option>Select City</option>
            <?php foreach($get_cities as $city): ?>
                <option value="<?php echo $city['city_name']; ?>"><?php echo $city['city_name']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Save" class="btn-submit">
    </form>
</div>
  </div>
</div>
<?php include_once("./footer.php"); ?>
<script>
    $(".make-default a").on("click", function(e){
        $(".gif").text("loading...").show();
        e.preventDefault();
        var ad_id = $(this).data("id");
        $.ajax({
            type:"POST",
            url: "<?php echo $base_url; ?>api.php",
            data: {
                address_make_default: 1,
                ad_id : ad_id
            },
            success: function(res){
                $(".gif").hide();
                if(res == 1){
                    $.alert({
                        title: "Success",
                        content: 'Address Updated',
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
                        animationSpeed: 200,
                    });
                }
            }
        })
    });

    $(".add-list .j-btnedit").on("click", function(e){
		e.preventDefault();
		var add         = $(this).parent().parent().parent().find(".user-add").text();
		var add_cont    = $(this).parent().parent().parent().find(".user-add-cont").text();
		$("#edit-popup .add-input").val(add);
		$("#edit-popup .add-cont-input").val(add_cont);
        var userCity = $(this).closest("li").find('.user-city').text();
        $("#edit-popup .add-cities option").each(function(){
            if($(this).val() == userCity){
                $(this).attr("selected", "selected").siblings().removeAttr("selected");
            }
        });
        $(".form-edit-address .btn-submit").attr("data-id", $(this).data("id"));
	});

    $(".form-edit-address").on("submit", function(e){
        e.preventDefault();
        $(".gif").text("Updating...").show();
        var ad_id = $(this).data("id");
        $.ajax({
            type:"POST",
            url: "<?php echo $base_url; ?>api.php",
            data: {
                edit_address: 1,
                ad_id : $(".form-edit-address .btn-submit").data("id"),
                address : $("#edit-popup .add-input").val(),
                address_continue : $("#edit-popup .add-cont-input").val(),
                city: $("#edit-popup .add-cities option:selected").text()
            },
            success: function(res){
                $(".gif").hide();
                if(res == 1){
                    $.alert({
                        title: "Success",
                        content: 'Address Updated',
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
    });

    $(".form-add-address").on("submit", function(e){
        e.preventDefault();
        $(".gif").text("Adding...").show();
        $.ajax({
            type:"POST",
            url: "<?php echo $base_url; ?>api.php",
            data: {
                add_address: 1,
                address : $("#add-popup .add-input").val(),
                address_continue : $("#add-popup .add-cont-input").val(),
                city: $("#add-popup .add-cities option:selected").text()
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

    $(".add-list .j-deladdress").on("click", function(e){
        e.preventDefault();
        $(".gif").text("Deleting...").show();
        var ad_id = $(this).data("id");
        $.ajax({
            type:"POST",
            url: "<?php echo $base_url; ?>api.php",
            data: {
                del_address: 1,
                ad_id : ad_id
            },
            success: function(res){
                $(".gif").hide();
                if(res == 1){
                    $.alert({
                        title: "Success",
                        content: 'Address Deleted',
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
                        animationSpeed: 200,
                    });
                }
            }
        })

    });
</script>
</body>
</html>

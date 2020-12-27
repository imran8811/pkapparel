<?php
    include_once("./init.php");
    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
    }
    $misc = new Misc();
    $profile = new Profile();
    $get_cities     = $misc->get_cities();
    $get_user_profile   = $profile->get_user_profile();
//echo "<pre>";
//print_r($get_user_profile);
//echo "</pre>";
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
    <span class="msg-block" style="display: none;"></span>
    <div class="page-accounts clearfix">
        <?php include_once("user-sidebar.php"); ?>
        <?php foreach($get_user_profile as $user): ?>
        <div class="acc-content">
          <h1>Account Information</h1>
          <div class="inner-wrap">
            <div class="member-since">
              <span>Member Since:</span>
              <span><?php echo date("d-M-Y", strtotime($user['joined_at'])); ?></span>
            </div>
            <form action="#" class="acc-form" method="post">
              <div class="input-wrap">
                <label for="full-name">Name</label>
                <input type="text" id="full-name" name="full_name" value="<?php echo $user['full_name']; ?>">
              </div>
              <div class="input-wrap">
                <label for="user-email">Email</label>
                <input type="text" id="user-email" name="user_email" value="<?php echo $user['user_email']; ?>">
              </div>
              <div class="input-wrap">
                <label for="city">City</label>
                <select id="city" name="user_city">
                  <option value="0">Select City</option>
                  <?php foreach($get_cities as $city): ?>
                    <option value="<?php echo $city['city_name']; ?>" <?php echo $city['city_name'] == $user['city'] ? 'selected="selected"': ""?>><?php echo $city['city_name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="input-wrap">
                <label for="contact">Contact <span class="text-small">(e.g 03001234567)</span></label>
                <input type="text" id="contact" name="user_contact" value="<?php echo $user['mobile_no'] ?>">
              </div>
              <div class="submit-wrap clearfix">
                <input type="submit" value="Save Changes" name="update_user_profile" class="btn-submit">
              </div>
            </form>
          </div>
        </div>
        <?php endforeach; ?>
    </div>
  </div>
</div>
<?php include_once("./footer.php"); ?>
<script>
  $(".acc-form").on("submit", function(e){
    e.preventDefault();
    $(".gif").show().text("loading...")
    $.ajax({
        type: "POST",
        url: "<?php echo $base_url; ?>api.php",
        data: {
          update_profile: 1,
          full_name: $("#full-name").val(),
          email: $("#user-email").val(),
          city: $("#city option:selected").val(),
          contact: $("#contact").val()
        },
        success: function(res){
          if(res == "1"){
            $(".gif").hide();
            $.alert({
              title: "",
              content: "Profile Updated",
              useBootstrap: false,
              type: "green",
              boxWidth: "20%",
//                onClose: function(){
//                  location.reload();
//                }
                });
            } else {
              $(".gif").hide();
              $.alert({
                title: "",
                content: "Server Error, try later",
                useBootstrap: false,
                type: "red",
                boxWidth: "20%"
              });
            }
          }
      })
    })
</script>
</body>
</html>
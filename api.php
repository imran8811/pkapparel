<?php
    if(!$_REQUEST){
        echo "<h1>Access Denied</h1>";
    }
    require_once "init.php";
    $user           = new User;
    $misc           = new Misc;
    $JeansPants     = new JeansPants();
    $cart           = new Cart();
    $checkout       = new Checkout();
    $profile        = new Profile();

    if(isset($_POST['p_id'])){
	    $p_id = $_POST['p_id'];
    }

    if(isset($_POST["user_join"])){
        $result = $user->register();
        echo $result;
    }

    if(isset($_POST['login'])){
        $result = $user->login();
        echo $result;
    };

    if(isset($_POST['save_item'])){
        if(isset($_SESSION['user_id'])){
            $result = $misc->save_item($p_id);
            echo $result;
        } else {
            echo "002";
        }
    }

    if(isset($_POST['add_cart'])){
        $sizes_qty  = $_POST['sizes_qty'];
        $result = $cart->add_cart($p_id, $sizes_qty);
        print_r($result);
    }

    if(isset($_POST['update_cart'])){
        $sizes_qty  = $_POST['sizes_qty'];
        $result = $cart->update_cart($p_id, $sizes_qty);
        print_r($result);
    }

    if(isset($_POST['check_sess'])){
        $sess_id = $_POST['sess_id'];
        $result = $cart->end_session($sess_id);
        echo $result;
    }

    if(isset($_POST['cart_det'])){
        $sess_id = $_POST['sess_id'];
        $result = $cart->get_cart_items($sess_id);
        echo $result;
    }

    if(isset($_POST['filter_search'])){
      $dept     = (isset($_POST['dept']) ? $_POST['dept']: '' );
      $category = (isset($_POST['category']) ? $_POST['category']: '' );
      $sizes    = (isset($_POST['sizes']) ? $_POST['sizes']: array() );
      $colors   = (isset($_POST['colors']) ? $_POST['colors']: array() );
      $result   = $misc->filter_search($dept, $category, $sizes, $colors);
      // print_r($category);
      echo json_encode($result);
      //  echo $result;
    }

    if(isset($_POST['cart_remove'])){
        $p_id = $_POST["p_id"];
        $result = $cart->remove_item_from_cart($p_id);
        echo $result;
    }

    // if(isset($_POST['rmv_sv_tm'])){
    //     $result = $misc->remove_saved_item();
    //     echo $result;
    // }

    if(isset($_POST['address_make_default'])){
        $result = $misc->make_add_default();
        echo $result;
    }

    if(isset($_POST['edit_address'])){
        $result = $misc->edit_address();
        echo $result;
    }

    if(isset($_POST['add_address'])){
        $result = $misc->add_address();
        echo $result;
    }

    if(isset($_POST['del_address'])){
        $result = $misc->del_address();
        echo $result;
    }

    if(isset($_POST['chk_qty'])){
		$result = $misc->check_quantity();
	    echo $result;
	}

    if(isset($_POST['update_cart_qty'])){
        $result = $cart->update_cart_qty();
        echo $result;
    }

    if(isset($_POST['update_cart_size'])){
        $result = $cart->update_cart_size();
        echo $result;
    }

    if(isset($_POST['get_region'])){
        $country_id = $_POST['country_id'];
        $result = $misc->get_states($country_id);
        echo json_encode($result);
    }

    if(isset($_POST['get_cities'])){
        $state_id = $_POST['state_id'];
        $result = $misc->get_cities($state_id);
        echo json_encode($result);
    }

    if(isset($_POST['reset_pass'])){
        $email = $_POST['email'];
        $result = $user->reset_pass($email);
        print_r($result);
    }

    if(isset($_POST['rsnd_lnk'])){
        $email = $_POST['email'];
        $result = $user->resend_email_verfication_link($email);
        echo $result;
    }

    if(isset($_POST['update_pass'])){
        $user_id = $_SESSION['user_id'];
        $new_pass = $_POST['new_pass'];
        $result = $profile->update_pass($user_id, $new_pass);
        echo $result;
    }

    if(isset($_POST['update_pass_by_email'])){
        $email = $_POST['email'];
        $new_pass = $_POST['new_pass'];
        $result = $profile->update_pass_by_email($email, $new_pass);
        echo $result;
    }

    if(isset($_POST['update_profile'])){
        $result = $user->update_user_profile();
        echo $result;
    }

    if(isset($_POST['confirm_order'])){
        $result = $checkout->confirm_order();
        echo $result;
    }

    if(isset($_POST['log_issue'])){
        $result = $misc->log_issue();
        echo $result;
    }

    if(isset($_POST['empty_cart'])){
        $result = $cart->empty_cart();
        echo $result;
    }
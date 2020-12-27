<?php
class Cart {
	private static $con;
	public function __construct(){
		$db = new Db();
		self::$con = $db->connect_db();
		return self::$con;
	}

	public static function generate_session(){
		$sess_id = rand();
		if(isset($_SESSION['user_id'])){
			$user_id = $_SESSION['user_id'];
			$user_type = 'user';
		} else {
			$user_id = NULL;
			$user_type = 'guest';
		}
		$guest_id_query = self::$con->prepare("INSERT INTO sessions (sess_id, user_type, user_id) VALUES('$sess_id', '$user_type', '$user_id')");
		$guest_id_query->execute();
		$last_id = self::$con->lastInsertId();
		$sess_id_query = self::$con->prepare("SELECT sess_id from sessions WHERE record_id = $last_id");
		$sess_id_query->execute();
		$result = $sess_id_query->fetchObject();
		$sess_id = $result->sess_id;
		$_SESSION['sess_id'] = $sess_id;
		$_SESSION['user_type'] = $user_type;
	}

	public static function end_session($sess_id){
		$query  = self::$con->prepare("SELECT added_at from sessions WHERE sess_id = $sess_id");
		$query->execute();
		$result = $query->fetchColumn();
		date_default_timezone_set("Asia/Karachi");
		$added_time = strtotime($result);
		$time_now = time();
		$time_diff = $time_now - $added_time;
		$sess_time =  round($time_diff/60, 2);
		if($sess_time > 5 ){
			$remove_sess = self::$con->prepare("DELETE FROM sessions WHERE sess_id = $sess_id");
			$remove_sess->execute();
			$remove_cart_items = self::$con->prepare("DELETE FROM cart WHERE sess_id = $sess_id");
			$remove_cart_items->execute();
			session_unset();
			session_destroy();
		}
	}

	public static function add_cart($p_id, $sizes_qty){
		$sess_id = isset($_SESSION['sess_id']);
		if(!$sess_id){
			self::generate_session();
		}
        $sess_id = $_SESSION['sess_id'];
        $item_already_in_cart = self::item_already_in_cart($sess_id, $p_id);
		if(!$item_already_in_cart){
			$insert_to_cart = self::insert_to_cart($p_id, $sess_id, $sizes_qty);
			if($insert_to_cart){
				return $insert_to_cart;
			} else {
				return false;
			}
		} else {
			return "007";
		}
	}

	public static function insert_to_cart($p_id, $sess_id, $sizes_qty){
	    $user_id_exist = isset($_SESSION['user_id']);
	    if($user_id_exist) {
	        $user_id = $_SESSION['user_id'];
            foreach($sizes_qty as $size => $qty){
                $query = self::$con->prepare("INSERT INTO cart(p_id, sess_id, user_id, size, qty) VALUES($p_id,$sess_id,'$user_id', '$size','$qty')");
                $query->execute();
            }
        } else {
            foreach($sizes_qty as $size => $qty){
                $query = self::$con->prepare("INSERT INTO cart(p_id, sess_id, size, qty) VALUES($p_id,$sess_id,'$size','$qty')");
                $query->execute();
            }
        }
		$result = self::count_cart_items();
		if($result){
			return $result;
		} else {
			return false;
		}
	}

	public static function item_already_in_cart($sess_id, $p_id){
		$query = self::$con->prepare("SELECT sess_id, p_id FROM cart WHERE sess_id='$sess_id' AND p_id = '$p_id'");
		$query->execute();
		$result = $query->fetch();
		if($result){
			return true;
		} else {
			return false;
		}
	}

	public static function update_cart($p_id, $sizes_qty){
		$sess_id = $_SESSION['sess_id'];
		self::remove_item_from_cart($p_id);
		foreach($sizes_qty as $size => $qty){
			$query = self::$con->prepare("INSERT INTO cart(p_id, sess_id, size, qty) VALUES($p_id, $sess_id, $size, $qty)");
			$query->execute();
		}
		if($query->rowCount() > 0){
			return "1";
		}else {
			return "0";
		}
	}

	public static function count_cart_items(){
		$sess_id = $_SESSION['sess_id'];
		$query = self::$con->prepare("SELECT count(DISTINCT p_id, sess_id) FROM cart WHERE sess_id = $sess_id");
		$query->execute();
		$result = $query->fetchColumn();
		return $result;
	}

	public static function get_cart_items(){
		$sess_id = $_SESSION['sess_id'];
		$query = self::$con->prepare("SELECT i.image_front, GROUP_CONCAT(DISTINCT c.size) as sizes, GROUP_CONCAT(c.qty) AS qty, j.* FROM cart c LEFT JOIN images i ON c.p_id = i.p_id LEFT JOIN jeans_pants j ON c.p_id = j.p_id WHERE c.sess_id= $sess_id GROUP BY c.p_id");
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	public static function remove_item_from_cart($p_id){
		$sess_id = $_SESSION['sess_id'];
		$query = self::$con->prepare("DELETE FROM cart WHERE p_id = $p_id AND sess_id = $sess_id");
		$query->execute();
		if($query->rowCount() > 0){
			return "1";
		} else {
			return "0";
		}
	}

    public static function empty_cart(){
        $sess_id = $_SESSION['sess_id'];
        $query = self::$con->prepare("DELETE FROM cart WHERE sess_id = $sess_id");
        $query->execute();
        if($query->rowCount() > 0){
            return "1";
        } else {
            return "0";
        }
    }

	public static function get_cart_item_details($p_id){
		$query = self::$con->prepare("SELECT i.image_front, j.*, c.color, GROUP_CONCAT(DISTINCT c.size) as sizes, GROUP_CONCAT(c.qty) AS qty FROM cart c LEFT JOIN images i ON c.p_id = i.p_id LEFT JOIN jeans_pants j ON c.p_id = j.p_id WHERE c.p_id= $p_id");
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}

	public static function update_cart_qty(){
		$item_id = $_POST['item_id'];
		$qty = $_POST['qty'];
		$query = self::$con->prepare("UPDATE cart SET qty='$qty' WHERE cart_id = '$item_id'");
		$query->execute();
		if($query->rowCount() > 0){
			return "1";
		} else {
			return "0";
		}
	}

	public static function update_cart_size(){
		$item_id = $_POST['item_id'];
		$size = $_POST['size'];
		$p_id = $_POST['p_id'];
		$query_size_name = self::$con->prepare("SELECT size_name FROM cart WHERE p_id = '$p_id' AND size_name ='$size'");
		$query_size_name->execute();
		if($query_size_name->rowCount() > 0){
			return "001";
		} else {
			$query = self::$con->prepare("UPDATE cart SET size_name='$size' WHERE cart_id = '$item_id'");
			$query->execute();
			if($query->rowCount() > 0){
				return "1";
			} else {
				return "0";
			}
		}
	}
}
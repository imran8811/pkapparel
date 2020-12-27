<?php

class Checkout {
    private static $con;
    public function __construct(){
        $db = new Db();
        self::$con = $db->connect_db();
    }

	public static function confirm_order(){
        $add_id = $_POST["add_id"];
		$accessory = $_POST["accessory"];
		$shipping_method = $_POST["shipping"];
		$payment = $_POST["payment"];
		$total_amount = $_POST["total_amount"];
		$user_id = $_SESSION['user_id'];
        $order_no = self::generate_order_no();
		$cart_query = self::$con->prepare("SELECT * FROM cart WHERE user_id = $user_id");
		$cart_query->execute();
        $cart_results = $cart_query->fetchAll();
		foreach($cart_results as $c_result){
		    $p_id = $c_result['p_id'];
		    $size = $c_result['size'];
		    $qty = $c_result['qty'];
		    $order_query = self::$con->prepare("INSERT INTO orders (p_id, user_id, address_id, size, qty, payment_method, accessory, shipping_method, order_no, total_amount) VALUES ($p_id, $user_id, $add_id, $size, $qty, '$payment', '$accessory', '$shipping_method', $order_no, $total_amount)");
		    $order_query->execute();
        }
        $cartdel_query = self::$con->prepare("DELETE FROM cart WHERE user_id = $user_id");
        if($cartdel_query->execute()){
            $order_result = [
                'order_no' => $order_no
            ];
            return json_encode($order_result);
        } else {
            return "0";
        }
	}
	public static function generate_order_no(){
	    $first_order = 10012;
	    $query = self::$con->prepare("SELECT order_no FROM orders ORDER BY order_no DESC LIMIT 1");
	    $query->execute();
	    $result = $query->fetchColumn();
	    if($result == ""){
	        return $first_order;
        } else {
	        return $result+99;
        }
    }
}
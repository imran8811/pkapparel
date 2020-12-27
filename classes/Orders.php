<?php
class Orders {
    public $con;
    function __construct(){
        $db_con = new Db();
        $this->con = $db_con->connect_db();
        return $this->con;
    }

    public function get_orders(){
        if($this->con){
            $query = $this->con->prepare("SELECT * FROM orders INNER JOIN users ON orders.user_id = users.user_id");
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }
    }

    public function get_order_by_orderId($order_id) {
        if($this->con){
            $query = $this->con->prepare("SELECT * FROM orders WHERE orders.order_id = $order_id");
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }
    }

    public function get_order_by_userId($user_id) {
        if($this->con){
            $query = $this->con->prepare("SELECT * FROM orders INNER JOIN users ON orders.user_id = users.user_id WHERE orders.user_id = $user_id");
             $query->execute();
            $result = $query->fetchAll();
            return $result;
        }
    }

    public function placeOrder(){
        if($this->con){
            $quantity           = $_POST["quantity"];
            $shipping_method    = $_POST["shipping_method"];
            $accessory          = $_POST["accessory"];
            $query = $this->con->prepare("INSERT INTO orders(user_id, p_id, quantity, shipping_method, accessory) VALUES(?,?,?,?,?)");
            $values = array($_SESSION["user_id"], $_GET["pid"], $quantity, $shipping_method, $accessory);
            $result = $query->execute($values);
            return $result;
        }
    }

    public function updateOrder($order_id){
        if($this->con){
            $quantity           = $_POST["quantity"];
            $shipping_method    = $_POST["shipping_method"];
            $accessory          = $_POST["accessory"];
            $query = $this->con->prepare("UPDATE orders set quantity='$quantity', shipping_method = '$shipping_method', accessory = '$accessory' WHERE order_id = $order_id");
            $result = $query->execute();
            return $result;
        }
    }

    public function get_latestorder_by_userId($user_id){
        if($this->con){
            $query = $this->con->prepare("SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_id DESC LIMIT 1");
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }
    }
}
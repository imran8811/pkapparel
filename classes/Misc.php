<?php

class Misc {
    private static $con;
    public function __construct(){
        $db = new Db();
        self::$con = $db->connect_db();
    }

    public static function get_cities(){
        $query = self::$con->prepare("SELECT * FROM cities");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public static function save_item($p_id){
        $user_id = $_SESSION['user_id'];
        $query = self::$con->prepare("INSERT INTO saved_items(user_id, p_id) VALUES('$user_id','$p_id')");
        $result = $query->execute();
        if($result){
            return '1';
        } else {
            return '0';
        }
    }

    public static function save_item_exist($p_id){
        $user_id = $_SESSION['user_id'];
        $query = self::$con->prepare("SELECT * FROM saved_items WHERE user_id=$user_id AND p_id=$p_id");
        $query->execute();
        $result = $query->fetch();
        if($result){
            return true;
        } else {
            return false;
        }
    }

    public static function check_quantity(){
        $size = str_replace("-", "_", $_POST['size']);
        $p_id = $_POST['p_id'];
        $query = self::$con->prepare("SELECT $size FROM stock WHERE p_id=$p_id");
        $query->execute();
        $result = $query->fetchColumn();
        return $result;

    }

    public static function get_available_sizes(){
        $query = self::$con->prepare("SELECT DISTINCT(s.size_name) FROM stock s");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public static function get_available_colors(){
        $query = self::$con->prepare("SELECT DISTINCT(s.color_name) FROM stock s");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public static function make_add_default(){
        $address_id = $_POST['ad_id'];
        $query_one = self::$con->prepare("UPDATE addresses SET add_status = '0'");
        $query_one->execute();
        $query_two = self::$con->prepare("UPDATE addresses SET add_status = '1' WHERE address_id = '$address_id'");
        $result = $query_two->execute();
        if($result){
            return "1";
        } else {
            return "0";
        }
    }

    public static function edit_address(){
        $address_id = $_POST['ad_id'];
        $address = $_POST['address'];
        $address_continue = $_POST['address_continue'];
        $city = $_POST['city'];
        $query = self::$con->prepare("UPDATE addresses SET address = '$address', add_continue='$address_continue', ad_city = '$city' WHERE address_id = '$address_id'");
        $result = $query->execute();
        if($result){
            return "1";
        } else {
            return "0";
        }
    }

    public static function add_address(){
        $address = $_POST['address'];
        $address_continue = $_POST['address_continue'];
        $city = $_POST['city'];
        $user_id = $_SESSION['user_id'];
        $query = self::$con->prepare("INSERT INTO addresses(address, add_continue, ad_city, user_id) VALUES('$address','$address_continue','$city', $user_id)");
        $result = $query->execute();
        if($result){
            return "1";
        } else {
            return "0";
        }
    }

    public static function log_issue(){
        $issue_details = $_POST['issue_details'];
        $query = self::$con->prepare("INSERT INTO issues(issue_details) VALUES('$issue_details')");
        $result = $query->execute();
        if($result){
            return "1";
        } else {
            return "0";
        }
    }

    public static function del_address(){
        $user_id = $_SESSION['user_id'];
        $ad_id = $_POST['ad_id'];
        $query = self::$con->prepare("DELETE FROM addresses WHERE address_id = $ad_id AND user_id = $user_id");
        $result = $query->execute();
        if($result){
            return "1";
        } else {
            return "0";
        }
    }


}
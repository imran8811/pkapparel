<?php

class Profile {
    public static $db;
    public function __construct(){
        $db_conn = new Db();
        self::$db = $db_conn->connect_db();
        return self::$db;
    }

    public static function get_user_orders(){
        $user_id = $_SESSION['user_id'];
        $query = self::$db->prepare("SELECT * FROM orders o LEFT JOIN jeans_pants j ON o.p_id = j.p_id LEFT JOIN addresses a ON o.address_id = a.address_id WHERE o.user_id = '$user_id'");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public static function get_user_profile(){
        $user_id = $_SESSION['user_id'];
        $query = self::$db->prepare("SELECT u.*, a.*, GROUP_CONCAT(a.address, a.add_continue) AS address FROM users u LEFT JOIN addresses a ON u.user_id = a.user_id WHERE u.user_id = '$user_id' GROUP BY u.user_id");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public static function get_user_addresses(){
        $user_id = $_SESSION['user_id'];
        $query = self::$db->prepare("SELECT * FROM addresses a WHERE a.user_id = '$user_id'");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public static function update_pass(){
        $user_id = $_SESSION['user_id'];
        $new_pass = $_POST['new_pass'];
        $new_pass_hash = hash("sha1", $new_pass);
        $check_pass = self::$db->prepare("SELECT user_pass FROM users WHERE user_id = '$user_id'");
        $check_pass->execute();
        $result = $check_pass->fetchColumn();
        if($_POST['new_pass'] == $result){
            return "001";
        }
        $query = self::$db->prepare("UPDATE users u set user_pass='$new_pass_hash' WHERE u.user_id = '$user_id'");
        if($query->execute()){
            return "1";
        } else {
            return "0";
        }
    }

    public static function update_pass_by_email($email, $new_pass){
        $new_pass_hash = hash("sha1", $new_pass);
        $check_pass = self::$db->prepare("SELECT user_pass FROM users WHERE user_email = '$email'");
        $check_pass->execute();
        $result = $check_pass->fetchColumn();
        if($new_pass == $result){
            return "001";
        }
        $query = self::$db->prepare("UPDATE users u set user_pass='$new_pass_hash' WHERE u.user_email = '$email'");
        if($query->execute()){
            return "1";
        } else {
            return "0";
        }
    }

    public static function get_saved_items(){
        $user_id = $_SESSION['user_id'];
        $query = self::$db->prepare("SELECT * FROM saved_items s LEFT JOIN jeans_pants jp ON s.p_id=jp.p_id LEFT JOIN stock st ON s.p_id=st.p_id LEFT JOIN images i ON s.p_id=i.p_id WHERE s.user_id = '$user_id' GROUP BY s.p_id");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public static function remove_saved_item(){
        $user_id    = $_SESSION['user_id'];
        $p_id       = $_POST['tm_d'];
        $query = self::$db->prepare("DELETE FROM saved_items WHERE user_id='$user_id' AND p_id=$p_id");
        if($query->execute()){
            return "1";
        } else {
            return "0";
        }
    }

    public static function get_user_reviews(){
        $user_id = $_SESSION['user_id'];
        $query = self::$db->prepare("SELECT * FROM reviews r LEFT JOIN jeans_pants jp ON r.p_id=jp.p_id LEFT JOIN images i ON r.p_id=i.p_id WHERE r.user_id = '$user_id'");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

}
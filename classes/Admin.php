<?php

class Admin {
    public static $con;
    function __construct(){
        $db = new Db();
        self::$con = $db->connect_db();
    }

	public static function login(){
		$email = $_POST['email'];
		$password = $_POST['password'];
		if(!empty($email) && !empty($password)){
			$query  = self::$con->prepare("SELECT email, password FROM admin_users WHERE email= '$email' AND password= '$password'");
			$query->execute();
			$result = $query->fetchAll();
			if($result){
				$_SESSION['admin_logged'] = true;
				return "1";
			} else {
				return "0";
			}
		}
	}

	public static function logout(){
		if(isset($_POST['logout'])){
			session_unset();
			session_destroy();
			return "1";
		}
	}

    public static function add_product(){
        $dept_id        = $_POST['p_dept'];
        $cat_id         = $_POST['p_cat'];
        $p_id           = $_POST['p_id'];
        $item_price		= $_POST['p_price'];
        $p_desc         = $_POST['p_desc'];
		$images_uploaded = self::upload_images($p_id);
        if($images_uploaded){
			$query_product = self::$con->prepare("INSERT INTO jeans_pants(p_id,p_desc,item_price,dept_id,cat_id) VALUES('$p_id', '$p_desc', '$item_price', '$dept_id', '$cat_id')");
            $product_added = $query_product->execute();
		} else {
			return "Images upload error";
		}

		$stock_added = self::add_stock($p_id);

		if($product_added && $stock_added && $images_uploaded){
			return "1";
		} else {
			return "0";
		}
    }

	public static function upload_images($p_id){
		if (!file_exists('."../assets/images/products/' . "$p_id" . "/")) {
			mkdir('."../assets/images/products/' . "$p_id" . "/", 0777, true);
		}
		$target_dir = '."../assets/images/products/' . "$p_id" . "/";
		$actual_dir = 'assets/images/products/' . "$p_id" . "/";
		$allowedExt = array("jpg", "png", "jpeg", "gif");
		$max_file_size = 5300000;
		foreach($_FILES['images']['name'] as $key => $value){
			$target_file_name = $target_dir . $_FILES['images']['name'][$key];
			$upload_files = move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file_name);
		}
		$image_front = $actual_dir . $_FILES['images']['name'][0];
		$image_back = $actual_dir . $_FILES['images']['name'][1];
		$image_side = $actual_dir . $_FILES['images']['name'][2];
		$image_other_one = $actual_dir . $_FILES['images']['name'][3];
		$image_other_two = $actual_dir . $_FILES['images']['name'][4];
		$query  = self::$con->prepare("INSERT INTO images (p_id, image_front, image_back, image_side, image_other_one, image_other_two) VALUES('$p_id', '$image_front','$image_back','$image_side','$image_other_one','$image_other_two')");
		if($query->execute()){
			return true;
		} else {
			return false;
		}
	}

	public static function add_stock($p_id){
		$sizes = $_POST['sizes'];
		$stocks = $_POST['stock'];
		$color = $_POST['p_color'];
		for($i=0; $i < count($sizes); $i++){
			$size = $sizes[$i];
			$stock = $stocks[$i];
			$query = self::$con->prepare("INSERT INTO stock(p_id, color_name, size_name, stock) VALUES('$p_id','$color','$size','$stock')");
			$result = $query->execute();
		}
		if($result){
			return true;
		} else {
			return false;
		}
	}

	public static function get_products(){
		$query = self::$con->prepare("SELECT j.*, i.*, s.*, GROUP_CONCAT(DISTINCT s.stock) as stock, GROUP_CONCAT(DISTINCT s.size_name) as sizes, GROUP_CONCAT(DISTINCT s.color_name) as colors FROM jeans_pants j LEFT JOIN images i ON j.p_id = i.p_id LEFT JOIN stock s ON j.p_id = s.p_id GROUP BY j.p_id DESC");
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}

	public static function delete_product($p_id){
		$query = self::$con->prepare("DELETE FROM jeans_pants, images USING jeans_pants INNER JOIN images ON jeans_pants.p_id = images.p_id WHERE jeans_pants.p_id= $p_id");
		$del_pro = $query->execute();
		$del_stock = self::del_stock($p_id);
		$dirPath = "."../assets/images/products/" . "$p_id";
		$del_directory = self::del_directory($dirPath);
		if($del_pro && $del_stock){
			return "1";
		} else {
			return "0";
		}
	}

	public static function del_stock($p_id){
		$query = self::$con->prepare("DELETE FROM stock WHERE stock.p_id= $p_id");
		$query->execute();
		if($query->execute()){
			return true;
		} else {
			return false;
		}
	}

	public static function del_directory($dirPath){
		if (is_dir($dirPath)) {
			$objects = scandir( $dirPath );
			foreach ( $objects as $object ) {
				if ( $object != "." && $object != ".." ) {
					if ( filetype( $dirPath . DIRECTORY_SEPARATOR . $object ) == "dir" ) {
						self::del_directory( $dirPath . DIRECTORY_SEPARATOR . $object );
					} else {
						unlink( $dirPath . DIRECTORY_SEPARATOR . $object );
					}
				}
			}
			reset( $objects );
			rmdir( $dirPath );
		}
	}

	public static function get_depts(){
		$query = self::$con->prepare("SELECT * FROM depts");
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}

	public static function get_cats(){
		$query = self::$con->prepare("SELECT * FROM cats");
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}

	public static function get_style_no(){
		$query = self::$con->prepare("SELECT p_id FROM jeans_pants ORDER BY p_id DESC LIMIT 1");
		$query->execute();
		$result = $query->fetchColumn();
		return $result;
	}

	public static function update_images($p_id){
//		if (!file_exists('."../assets/images/products/' . "$p_id" . "/")) {
//			mkdir('."../assets/images/products/' . "$p_id" . "/", 0777, true);
//		}
		$target_dir = '."../assets/images/products/' . "$p_id" . "/";
		$actual_dir = 'assets/images/products/' . "$p_id" . "/";
		$allowedExt = array("jpg", "png", "jpeg", "gif");
		$max_file_size = 5300000;
		foreach($_FILES['images']['name'] as $key => $value){
			$target_file_name = $target_dir . $_FILES['images']['name'][$key];
			$upload_files = move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file_name);
		}
		$image_front = $actual_dir . $_FILES['images']['name'][0];
		$image_back = $actual_dir . $_FILES['images']['name'][1];
		$image_side = $actual_dir . $_FILES['images']['name'][2];
		$image_other_one = $actual_dir . $_FILES['images']['name'][3];
		$image_other_two = $actual_dir . $_FILES['images']['name'][4];
		if(!empty($_FILES['images']['name'][0])){
			$query_front  = self::$con->prepare("UPDATE images SET image_front = '$image_front' WHERE p_id = $p_id");
			$query_front->execute();
		}
		if(!empty($_FILES['images']['name'][1])){
			$query_back  = self::$con->prepare("UPDATE images SET image_back = '$image_back' WHERE p_id = $p_id");
			$query_back->execute();
		}
		if(!empty($_FILES['images']['name'][2])){
			$query_side  = self::$con->prepare("UPDATE images SET image_side = '$image_side' WHERE p_id = $p_id");
			$query_side->execute();
		}
		if(!empty($_FILES['images']['name'][3])){
			$query_other_one  = self::$con->prepare("UPDATE images SET image_other_one = '$image_other_one' WHERE p_id = $p_id");
			$query_other_one->execute();
		}
		if(!empty($_FILES['images']['name'][4])){
			$query_other_two  = self::$con->prepare("UPDATE images SET image_other_two = '$image_other_two' WHERE p_id = $p_id");
			$query_other_two->execute();
		}
//		$query  = self::$con->prepare("UPDATE images SET p_id= '$p_id', image_front = '$image_front', image_back = '$image_back', image_side = '$image_side', image_other_one = '$image_other_one', image_other_two = '$image_other_two' WHERE p_id = $p_id");
//		if($query_front->execute()){
//			return true;
//		} else {
//			return false;
//		}
		return true;
	}

	public static function update_stock($p_id){
		$sizes = $_POST['sizes'];
		$stocks = $_POST['stock'];
		$color = $_POST['p_color'];
		$queryDel = self::$con->prepare("DELETE FROM stock WHERE p_id = $p_id");
		$queryDel->execute();
		for($i=0; $i < count($sizes); $i++){
			$size = $sizes[$i];
			$stock = $stocks[$i];
			$query = self::$con->prepare("INSERT INTO stock(p_id, color_name, size_name, stock) VALUES('$p_id','$color','$size','$stock')");
			$result = $query->execute();
		}
		if($result){
			return true;
		} else {
			return false;
		}
	}

	public static function update_product(){
		$dept_id        = $_POST['p_dept'];
		$cat_id         = $_POST['p_cat'];
		$p_id           = $_POST['p_id'];
		$item_price		= $_POST['p_price'];
		$p_desc         = $_POST['p_desc'];
		$images_updated = self::update_images($p_id);
		if($images_updated){
			$query_product = self::$con->prepare("UPDATE jeans_pants SET p_id = '$p_id',p_desc = '$p_desc',item_price = '$item_price',dept_id = '$dept_id',cat_id= '$cat_id' WHERE p_id = $p_id");
			$product_added = $query_product->execute();
		} else {
			return "Images upload error";
		}
		$stock_updated = self::update_stock($p_id);
		if($product_added && $stock_updated && $images_updated){
			return "1";
		} else {
			return "0";
		}
	}
}
<?php

class JeansPants {
	public static $con;

	function __construct() {
		$db_con    = new Db();
		self::$con = $db_con->connect_db();
		return self::$con;
	}

	public static function get_all_pants() {
		$query = self::$con->prepare( "SELECT j.*, i.*, GROUP_CONCAT(DISTINCT s.size_name) AS sizes FROM jeans_pants j LEFT JOIN images i ON j.p_id = i.p_id LEFT JOIN stock s ON j.p_id = s.p_id GROUP BY j.p_id");
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}

	public static function get_product_details($p_id) {
		$query = self::$con->prepare( "SELECT j.*, i.*, GROUP_CONCAT(DISTINCT s.size_name) AS sizes, GROUP_CONCAT(DISTINCT s.stock) AS stock, GROUP_CONCAT(DISTINCT s.color_name) AS colors FROM jeans_pants j LEFT JOIN images i ON j.p_id = i.p_id LEFT JOIN stock s ON j.p_id = s.p_id WHERE j.p_id = $p_id");
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}

	public static function get_total_stock($p_id) {
		$query = self::$con->prepare( "SELECT SUM(stock) AS sum_value FROM stock WHERE stock.p_id='$p_id' " );
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}

	public static function get_stock($p_id) {
		$query = self::$con->prepare("SELECT * FROM stock WHERE stock.p_id=$p_id");
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}

    public function get_stock_by_size($size){
        $query = $this->con->prepare("SELECT stock FROM stock WHERE stock.size_name='$size' ");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

	public static function get_reviews($p_id){
		$query  = self::$con->prepare("SELECT * FROM reviews INNER JOIN users ON reviews.user_id = users.user_id WHERE p_id = $p_id");
		$query->execute();
		$result  = $query->fetchAll();
		return $result;
	}

	public static function filter_jeans_pants($dept_id, $sizes, $colors, $min_value, $max_value){
		$query = self::$con->prepare("SELECT j.*, i.*, s.*, GROUP_CONCAT(s.size_name) as sizes, GROUP_CONCAT(DISTINCT s.color_name) as colors, GROUP_CONCAT(s.stock) as qty FROM jeans_pants j INNER JOIN images i ON j.p_id = i.p_id INNER JOIN stock s ON FIND_IN_SET(s.color_name, '$colors') AND j.dept_id = $dept_id GROUP BY j.p_id");
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}

	public static function paginate($this_page_first_result, $results_per_page, $dept_id, $cat_id){
		$query  = self::$con->prepare("SELECT j.*, i.*, GROUP_CONCAT(DISTINCT s.size_name) AS sizes FROM jeans_pants j LEFT JOIN images i ON j.p_id = i.p_id LEFT JOIN stock s ON j.p_id = s.p_id WHERE dept_id = $dept_id AND cat_id = $cat_id GROUP BY j.p_id LIMIT $this_page_first_result, $results_per_page");
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}
}
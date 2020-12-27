<?php

class User {
    public static $db;
    public function __construct(){
        $db_conn = new Db();
        self::$db = $db_conn->connect_db();
        return self::$db;
    }

    public function Redirect($url, $permanent = false){
        if(headers_sent() === false){
            header("Location: " . $url, true, ($permanent === true) ? 301 : 302);
        }
        exit();
    }

    public static function login(){
        $email         = $_POST["email"];
        $password      = hash("sha1", $_POST["pass"]);
		$query = self::$db->prepare("SELECT * FROM users WHERE user_email='$email' AND user_pass='$password'");
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
		if($result) {
			$_SESSION['user_id']    = $result['user_id'];
			$_SESSION['full_name']  = $result['full_name'];
			$_SESSION['user_type']  = "user";
			if(!isset($_SESSION['sess_id'])){
				Cart::generate_session();
			}
			$sess_id = $_SESSION['sess_id'];
			$user_id = $_SESSION['user_id'];
			$update_cart = self::$db->prepare("UPDATE cart SET user_id=$user_id WHERE sess_id=$sess_id");
			$update_session = self::$db->prepare("UPDATE sessions SET user_id='$user_id', user_type='user' WHERE sess_id='$sess_id'");
			if($update_cart->execute() && $update_session->execute()){
				return "1";
			} else {
				return "001";
			}
		} else {
			return "0";
		}
    }

    public static function is_logged(){
        if(isset($_SESSION['user_id'])){
            return true;
        } else {
            return false;
        }
    }

    public static function user_exist($email){
        $query = self::$db->prepare("SELECT user_email FROM users WHERE user_email = '$email'");
        $query->execute();
        if($query->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

	public static function verify_user($email){
		$check_user_status = self::check_user_status($email);
		if(!$check_user_status){
			$query = self::$db->prepare("UPDATE users SET user_status='1' WHERE user_email='$email'");
			$query->execute();
			if($query->execute()){
				return "1";
			} else {
				return "0";
			}
		} else {
			return "007";
		}
	}

	public static function check_user_status($email){
		$query = self::$db->prepare("SELECT user_status FROM users WHERE user_email = '$email'");
		$result = $query->execute();
		if($result === 0){
			return true;
		} else {
			return false;
		}
	}

    public static function register(){
        $full_name      = $_POST["full_name"];
        $email          = $_POST["email"];
        $password       = hash("sha1", $_POST["password"]);
        $mobile_no      = $_POST["mobile_no"];
        if(!empty($full_name) && !empty($email) && !empty($password) && !empty($mobile_no)) {
	        $email_exist = self::user_exist($email);
            if(!$email_exist){
	            $query = self::$db->prepare("INSERT INTO users(full_name, user_email, user_pass, mobile_no) VALUES(?,?,?,?)");
	            $values = array($full_name,$email,$password,$mobile_no);
	            $stmt = $query->execute($values);
	            if($stmt){
		            require 'PHPMailerAutoload.php';
		            $mail = new PHPMailer;
		            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		            $mail->SMTPAuth = true;                               // Enable SMTP authentication
		            $mail->Username = 'lhrjeans@gmail.com';                 // SMTP username
		            $mail->Password = 'k1ller123';                           // SMTP password
		            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		            $mail->Port = 465;                                    // TCP port to connect to
		            $mail->setFrom('noreply@lahorijeans.com', 'Lahori Jeans');
		            $mail->addAddress($email, $full_name);     // Add a recipient
		            $mail->isHTML(true);                                  // Set email format to HTML
		            $mail->Subject = 'Welcome to Lahori Jeans';
		            $mail->Body    = '
						<h3>Thanks for joining Lahori Jeans</h3>
						<a href="http://www.lahorijeans.com/dev/login.php?e=' . $email . '">Confirm Email</a>
					';
//                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		            if(!$mail->send()) {
			            return '0';
		            } else {
			            return '1';
		            }
	            } else {
		            return "n";
	            }
            } else {
	            return "008";
            }
        } else {
            return "All fields required";
        }
    }

    public function logout(){
	    $sess_id = $_SESSION['sess_id'];
	    $del_sess  = self::$db->prepare("DELETE FROM sessions WHERE sess_id = '$sess_id'");
	    $del_cart_item  = self::$db->prepare("DELETE FROM cart WHERE sess_id = '$sess_id'");
	    if($del_sess->execute() && $del_cart_item->execute()){
		    session_unset();
		    session_destroy();
		    return true;
	    } else {
		    return false;
	    }
    }

    public static function get_logged_user_info($user_id){
        $query  = self::$db->prepare("SELECT * FROM users WHERE user_id = '$user_id'");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public static function reset_pass($email){
        $query = self::$db->prepare("SELECT user_email FROM users WHERE user_email = '$email'");
	    $query->execute();
        if($query->rowCount() > 0){
            require 'PHPMailerAutoload.php';
            $mail = new PHPMailer;
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'lhrjeans@gmail.com';                 // SMTP username
            $mail->Password = 'k1ller123';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to
            $mail->setFrom('noreply@lahorijeans.com', 'Lahori Jeans');
            $mail->addAddress($email, 'Mohd Imran');     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Password reset link';
            $mail->Body    = '
            	<h1><a href="http://www.lahorijeans.com/dev/reset-pass.php?e=' . $email .'">Reset Link </a></h1>
            ';
//            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            if(!$mail->send()) {
                return '0';
            } else {
                return '1';
            }
        } else {
            return "001";
        }
    }

	public static function resend_email_verfication_link($email)
	{
		require 'PHPMailerAutoload.php';
		$mail = new PHPMailer;
		$mail->Host = 'smtp.gmail.com';                 // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'lhrjeans@gmail.com';                 // SMTP username
		$mail->Password = 'k1ller123';                           // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to
		$mail->setFrom('noreply@lahorijeans.com', 'Lahori Jeans');
		$mail->addAddress($email, "Lahori Jeans");     // Add a recipient
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = 'Registration with Lahori Jeans';
		$mail->Body = '
			<h3>Thanks for joining Lahori Jeans</h3>
			<a href="http://www.lahorijeans.com/dev/login.php?e=' . $email . '">Confirm Email</a>
		';
//                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		if (!$mail->send()) {
			return '0';
		} else {
			return '1';
		}
	}

	public static function update_user_profile(){
		$user_id		= $_SESSION['user_id'];
		$full_name		= $_POST['full_name'];
		$user_email		= $_POST['email'];
		$user_city		= $_POST['city'];
		$user_contact	= $_POST['contact'];
		$query_user		= self::$db->prepare("UPDATE users u set full_name='$full_name', user_email='$user_email', mobile_no='$user_contact', city='$user_city' WHERE u.user_id = '$user_id'");
		if($query_user->execute()){
			return "1";
		} else {
			return "0";
		}
	}
}
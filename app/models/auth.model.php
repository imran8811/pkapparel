<?php
namespace app\Models;
include_once(dirname(dirname(__DIR__)). "/Core/Model.php");
use Core\Model;
use PDO;
use PDOException;
use DateTime;
use DateInterval;

class AuthModel extends Model {

  public function __construct(){
    parent::__construct();
  }

  public function signup($data) {
    $checkUserExistQuery = 'SELECT * from users WHERE user_email=?';
    $stmt3 = $this->pdo->prepare($checkUserExistQuery);
    $stmt3->execute([$data['user_email']]);
    $res3 = $stmt3->fetchColumn();
    if($res3){
      return 'userDuplicate';
    }
    $password = password_hash($data['user_password'], PASSWORD_DEFAULT);
    $query = "INSERT INTO users (business_name, business_type, user_email, user_password, country_code, contact_no)
              VALUES(:business_name, :business_type, :user_email, :user_password, :country_code, :contact_no)";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(array(
      ":business_name" => $data['business_name'],
      ":business_type" => $data['business_type'],
      ":user_email" => $data['user_email'],
      ":user_password" => $password,
      ":country_code" => $data['country_code'],
      ":contact_no" => $data['contact_no'],
    ));
    $lastInsertedId = $this->pdo->lastInsertId();
    $query2 = 'SELECT * FROM users WHERE user_id=?';
    $stmt2 = $this->pdo->prepare($query2);
    $stmt2->execute([$lastInsertedId]);
    $res2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    $data = array(
      'business_name' => $res2['business_name'],
      'business_type' => $res2['business_type'],
      'country_code' => $res2['country_code'],
      'contact_no' => $res2['contact_no'],
    );
    return $data;
  }

  public function login($data){
    try{
      $query = "SELECT * FROM users WHERE user_email=?";
      $stmt= $this->pdo->prepare($query);
      $stmt->execute([$data['user_email']]);
      $res = $stmt->fetch();
      if($res){
        $passwordVerify = password_verify($data['user_password'], $res['user_password']);
        if($passwordVerify){
          $token = $this->generateSaveSessionToken($res['user_email']);
          if($token){
            $data = [
              'user_id'       => $res['user_id'],
              'user_email'    => $res['user_email'],
              'business_name' => $res['business_name'],
              'business_type' => $res['business_type'],
              'country_code'  => $res['country_code'],
              'contact_no'    => $res['contact_no'],
              'joined_at'     => $res['joined_at'],
              'status'        => $res['status'],
              'token'         => $token,
            ];
            return $data;
          } else {
            return false;
          }
        } else {
          return false;
        }
      } else {
       return false;
      }
    } catch(PDOException $e){
      return $e->getMessage();
    }
  }

  public function logout($userEmail){
    try{
      $query = "DELETE FROM sessions WHERE user_email=?";
      $stmt= $this->pdo->prepare($query);
      $stmt->execute([$userEmail]);
      return true;
    } catch(PDOException $e){
      return $e->getMessage();
    }
  }

  public function forgotPassword($userEmail){
    try{
      $checkUserExist = $this->checkUserExist($userEmail);
      if($checkUserExist['type'] !== 'error'){
        $passwordToken = $this->getURLToken(32);
        $Datetime = new Datetime('NOW');
        $Datetime->add(DateInterval::createFromDateString('1 day'));
        $expiry_date = $Datetime->format("Y-m-d H:i:s");
        $query = "INSERT INTO password_tokens (token, user_email, expiry_date)
                  VALUES(:token, :user_email, :expiry_date)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':token', $passwordToken, PDO::PARAM_STR);
        $stmt->bindParam(':user_email', $userEmail, PDO::PARAM_STR);
        $stmt->bindParam(':expiry_date', $expiry_date);
        $res = $stmt->execute();
        return $data = [
          'type' => 'success',
          'token' => $passwordToken,
          'res' => $res
        ];
      } else {
        return $data = [
          'type' => 'error',
          'message' => 'User does not exist',
        ];
      }
    } catch(PDOException $e){
      return $data = [
        'type' => 'error',
        'message' => $e->getMessage()
      ];
    }
  }

  public function resetPassword($data){
    $passwordHash = password_hash($data['user_password'], PASSWORD_DEFAULT);
    try{
      $query = "UPDATE users SET user_password=? WHERE user_email=?";
      $stmt = $this->pdo->prepare($query);
      $res = $stmt->execute([$passwordHash, $data['user_email']]);
      if($res){
        $query2 = "DELETE FROM password_tokens WHERE user_email=?";
        $stmt2 = $this->pdo->prepare($query2);
        $res2 = $stmt2->execute([$data['user_email']]);
      }
      return $data = [
        'type' => 'success',
        'res' => $res
      ];
    } catch(PDOException $e){
      return $data = [
        'type' => 'error',
        'message' => $e->getMessage()
      ];
    }
  }

  function checkUserExist($userEmail){
    try{
      $query = "SELECT * FROM users WHERE user_email=?";
      $stmt= $this->pdo->prepare($query);
      $stmt->execute([$userEmail]);
      $res = $stmt->fetch();
      if($res){
        return $data = [
          'type' => 'success',
          'message' => 'User Exist',
          'res' => $res
        ];
      } else {
        return $data = [
          'type' => 'error',
          'message' => 'User does not Exist',
          'res' => $res
        ];
      }
    } catch(PDOException $e){
      return $data = [
        'type' => 'error',
        'message' => $e->getMessage()
      ];
    }
  }

  function checkPasswordExpiryTokenValidity($token){
    try{
      $query = "SELECT expiry_date, user_email FROM password_tokens WHERE token=?";
      $stmt= $this->pdo->prepare($query);
      $stmt->execute([$token]);
      $res = $stmt->fetch();
      if($res){
        $today = new DateTime('NOW');
        $todayFormatted = $today->format("Y-m-d H:i:s");
        if($todayFormatted >= $res['expiry_date']){
          return $data = [
            'type' => 'error',
            'message' => 'link Expired',
          ];
        } else {
          return $data = [
            'type' => 'success',
            'message' => 'Token Valid',
            'user_email' => $res['user_email']
          ];
        }
      } else {
        return $data = [
          'type' => 'error',
          'message' => 'Invalid link',
        ];
      }
    } catch(PDOException $e){
      return $data = [
        'type' => 'error',
        'message' => $e->getMessage()
      ];
    }
  }

  function crypto_rand_secure($min, $max){
    $range = $max - $min;
    if ($range < 0) return $min; // not so random...
    $log = log($range, 2);
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
      $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
      $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd >= $range);
    return $min + $rnd;
  }

  function getURLToken($length){
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    for($i=0; $i < $length; $i++){
      $token .= $codeAlphabet[$this->crypto_rand_secure(0,strlen($codeAlphabet))];
    }
    return $token;
  }

  private function generateSaveSessionToken($userEmail){
    $token = bin2hex(random_bytes(16));
    $query = 'INSERT INTO sessions (token, user_email)
              values(:user_token, :user_email)
              ON DUPLICATE KEY UPDATE token=VALUES(token),user_email=VALUES(user_email)';
    $stmt= $this->pdo->prepare($query);
    $stmt->bindParam(':user_token', $token, PDO::PARAM_STR);
    $stmt->bindParam(':user_email', $userEmail, PDO::PARAM_STR);
    $res = $stmt->execute();
    return $res? $token : false;
  }
}

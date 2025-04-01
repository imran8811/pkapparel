<?php
namespace app\Controllers;
use Core\Controller;
use app\Models\AuthModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('App/models/auth.model.php');

class AuthController extends Controller {
  private $authModel;
  private $mail;

  public function __construct() {
    $this->authModel = new AuthModel();
    $this->mail = new PHPMailer(true);
  }

  public function signup($data) {
    $userSignup = $this->authModel->signup($data);
    if($userSignup && $userSignup !== 'userDuplicate'){
      $emailSend = $this->signupEmail($data['user_email'], $data['business_name']);
      $res = [
        'type' => 'success',
        'data' => $userSignup,
        'message' => 'Business Registered Successfully'
      ];
    } else if($userSignup === 'userDuplicate'){
      $res = [
        'type' => 'userDuplicate',
        'message' => 'User Already Exist'
      ];
    } else {
      $res = [
        'type' => 'error',
        'message' => 'Server error, try again'
      ];
    }
    return $res;
  }

  public function login($data) {
    $userLogin = $this->authModel->login($data);
    if($userLogin){
      $data = [
        'user_id'       => $userLogin['user_id'],
        'user_email'    => $userLogin['user_email'],
        'business_name' => $userLogin['business_name'],
        'business_type' => $userLogin['business_type'],
        'calling_code'  => $userLogin['calling_code'],
        'contact_no'    => $userLogin['contact_no'],
        'joined_at'     => $userLogin['joined_at'],
        'status'        => $userLogin['status'],
        'token'         => $userLogin['token']
      ];
      $res = [
        'type' => 'success',
        'data' => $data,
        'message' => 'User Login Successful'
      ];
    } else {
      $res = [
        'type' => 'error',
        'message' => 'Invalid email/password'
      ];
    }
    return $res;
  }

  public function logout($data) {
    $userLogout = $this->authModel->logout($data['userEmail']);
    if($userLogout){
      $res = [
        'type' => 'success',
        'message' => 'User Logged Out'
      ];
    } else {
      $res = [
        'type' => 'Bad Request',
        'message' => 'Unable to logout'
      ];
    }
    return $res;
  }

  public function forgotPassword($data) {
    $forgotPassword = $this->authModel->forgotPassword($data['user_email']);
    if($forgotPassword['type']==='success'){
      $this->forgotPasswordEmail($data['user_email'], $forgotPassword['token']);
      $res = [
        'type' => 'success',
        'message' => 'Password reset email sent, please check your inbox'
      ];
    } else {
      $res = [
        'type' => 'error',
        'message' => $forgotPassword['message']
      ];
    }
    return $res;
  }

  public function resetPassword($data) {
    $resetPassword = $this->authModel->resetPassword($data);
    if($resetPassword['type']==='success'){
      $this->resetPasswordEmail($data['user_email']);
      $res = [
        'type' => 'success',
        'message' => 'Password has been reset'
      ];
    } else {
      $res = [
        'type' => 'error',
        'message' => $resetPassword['message']
      ];
    }
    return $res;
  }

  public function linkValidity($token) {
    $linkValidity = $this->authModel->checkPasswordExpiryTokenValidity($token);
    if($linkValidity['type']==='success'){
      $res = [
        'type' => 'success',
        'message' => 'Link Valid',
        'user_email' => $linkValidity['user_email']
      ];
    } else {
      $res = [
        'type' => 'error',
        'message' => $linkValidity['message']
      ];
    }
    return $res;
  }

  private function signupEmail($recipientEmail, $businessName){
    try {
      //Server settings
      // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $this->mail->isSMTP();                                            //Send using SMTP
      $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
      $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $this->mail->Username   = 'pkapparel2@gmail.com';                     //SMTP username
      $this->mail->Password   = 'xysdlwmqurjidkom';                               //SMTP password
      $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      $this->mail->setFrom('pkapparel2@gmail.com', 'PK Apparel');
      // $this->mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
      $this->mail->addAddress($recipientEmail);               //Name is optional
      // $this->mail->addReplyTo('info@example.com', 'Information');
      // $this->mail->addCC('cc@example.com');
      // $this->mail->addBCC('bcc@example.com');

      //Attachments
      // $this->mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
      // $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

      $emailBody = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome to PK Apparel</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }
            .email-container {
                max-width: 600px;
                margin: 20px auto;
                background: #ffffff;
                padding: 10px;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            .header {
                text-align: center;
                color: #ffffff;
                padding: 20px;
                border-radius: 8px 8px 0 0;
            }
            .header h1 {
                margin: 0;
                font-size: 24px;
            }
            .content {
                padding: 20px;
                text-align: left;
                color: #333333;
            }
            .content p {
                margin: 0 0 15px;
                line-height: 1.6;
            }
            .cta-button {
                display: block;
                width: fit-content;
                margin: 20px auto;
                padding: 10px 20px;
                background-color: #007BFF;
                color: #ffffff;
                text-decoration: none;
                font-size: 16px;
                border-radius: 4px;
                text-align: center;
            }
            .cta-button:hover {
                background-color: #0056b3;
            }
            .footer {
                text-align: center;
                font-size: 12px;
                color: #777777;
                margin-top: 20px;
            }
          </style>
          </head>
          <body>
          <div class="email-container">
            <div class="header">
              <h1><img src="https://www.pkapparel.com/images/logo.jpg" alt="PK Apparel Logo" /></h1>
            </div>
            <div class="content">
                <p>Hi '.$businessName.',</p>
                <p>Thanks for joining PK Apparel, we are the best garments manufacturer, wholesaler and exporter.</p>
                <a href="https://www.pkapparel.com/verify-email?email='.$recipientEmail.'" class="cta-button">Verify Email</a>
            </div>
            <div class="footer">
              <p>&copy; 2025 PK Apparel Pvt. Ltd. All rights reserved.</p>
              <p>18-KM, Ferozepur road, Lahore</p>
              <p>Get in Touch : +923 000-911-000</p>
            </div>
          </div>
        </body>
      </html>';

      //Content
      $this->mail->isHTML(true);                                  //Set email format to HTML
      $this->mail->Subject = 'Welcome to PK Apparel';
      $this->mail->Body    = $emailBody;
      $this->mail->AltBody = 'Welcome to PK Apparel';

      $this->mail->send();
      return true;
    } catch (Exception $e) {
      return false;
      // return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
    }
  }

  private function forgotPasswordEmail($recipientEmail, $token){
    try {
      //Server settings
      // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $this->mail->isSMTP();                                            //Send using SMTP
      $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
      $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $this->mail->Username   = 'pkapparel2@gmail.com';                     //SMTP username
      $this->mail->Password   = 'xysdlwmqurjidkom';                               //SMTP password
      $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      $this->mail->setFrom('pkapparel2@gmail.com', 'PK Apparel');
      // $this->mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
      $this->mail->addAddress($recipientEmail);               //Name is optional
      // $this->mail->addReplyTo('info@example.com', 'Information');
      // $this->mail->addCC('cc@example.com');
      // $this->mail->addBCC('bcc@example.com');

      //Attachments
      // $this->mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
      // $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

      $emailBody = '
      <!DOCTYPE html>
      <html lang="en">
      <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Reset Your Password</title>
      <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
            line-height: 1.6;
        }
        .email-body p {
            margin: 0 0 16px;
        }
        .email-button {
            display: block;
            width: fit-content;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }
        .email-footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
            background-color: #f9f9f9;
        }
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                box-shadow: none;
            }
        }
      </style>
      </head>
      <body>
        <div class="email-container">
          <div class="email-header">
              <h1>Reset Your Password</h1>
          </div>
          <div class="email-body">
              <p>You recently requested to reset your password. Click the button below to reset it:</p>
              <a href="https://www.pkapparel.com/reset-password?token='.$token.'" class="email-button">Reset Password</a>
              <p>If you did not request a password reset, please ignore this email or contact support if you have questions.</p>
              <p>Thanks,<br>PK Apparel Team</p>
          </div>
          <div class="email-footer">
              <p>If you are having trouble clicking the button, copy and paste the link below into your web browser:</p>
              <p><a href="https://www.pkapparel.com/reset-password?token='.$token.'">https://www.pkapparel.com/reset-password?token='.$token.'</a></p>
          </div>
        </div>
      </body>
      </html>';

      //Content
      $this->mail->isHTML(true);                                  //Set email format to HTML
      $this->mail->Subject = 'Password Reset - PK Apparel';
      $this->mail->Body    = $emailBody;
      $this->mail->AltBody = 'Password Reset - PK Apparel';

      $this->mail->send();
      return true;
    } catch (Exception $e) {
      return [
        'type' => 'error',
        'message' => 'Message could not be sent. Mailer Error: '.$this->mail->ErrorInfo.''
      ];
    }
  }

  private function resetPasswordEmail($recipientEmail){
    try {
      //Server settings
      // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $this->mail->isSMTP();                                            //Send using SMTP
      $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
      $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $this->mail->Username   = 'pkapparel2@gmail.com';                     //SMTP username
      $this->mail->Password   = 'xysdlwmqurjidkom';                               //SMTP password
      $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      $this->mail->setFrom('pkapparel2@gmail.com', 'PK Apparel');
      // $this->mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
      $this->mail->addAddress($recipientEmail);               //Name is optional
      // $this->mail->addReplyTo('info@example.com', 'Information');
      // $this->mail->addCC('cc@example.com');
      // $this->mail->addBCC('bcc@example.com');

      //Attachments
      // $this->mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
      // $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

      $emailBody = '
      <!DOCTYPE html>
      <html lang="en">
      <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Reset Your Password</title>
      <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
            line-height: 1.6;
        }
        .email-body p {
            margin: 0 0 16px;
        }
        .email-button {
            display: block;
            width: fit-content;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }
        .email-footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
            background-color: #f9f9f9;
        }
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                box-shadow: none;
            }
        }
      </style>
      </head>
      <body>
        <div class="email-container">
          <div class="email-header">
            <h1>Password Reset</h1>
          </div>
          <div class="email-body">
              <p>Your password has been reset successfully.</p>
              <a href="https://www.pkapparel.com/login" class="email-button">Login Now</a>
              <p>If you did not request a password reset, please ignore this email or contact support if you have questions.</p>
              <p>Thanks,<br>PK Apparel Team</p>
          </div>
          <div class="email-footer">
              <p>&copy; 2025 PK Apparel Pvt. Ltd. All rights reserved.</p>
              <p>18-KM, Ferozepur road, Lahore</p>
              <p>Get in Touch : +923 000-911-000</p>
            </div>
        </div>
      </body>
      </html>';

      //Content
      $this->mail->isHTML(true);                                  //Set email format to HTML
      $this->mail->Subject = 'Password Reset Successful - PK Apparel';
      $this->mail->Body    = $emailBody;
      $this->mail->AltBody = 'Password Reset Successful - PK Apparel';

      $this->mail->send();
      return true;
    } catch (Exception $e) {
      return [
        'type' => 'error',
        'message' => 'Message could not be sent. Mailer Error: '.$this->mail->ErrorInfo.''
      ];
    }
  }

}

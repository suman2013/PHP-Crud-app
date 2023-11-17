<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require '../vendor/autoload.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

    include 'connection.php';

    class Signin
    {
        private $conne = '';

        function __construct()
        {
            $con = new Connection();
            $this->conne = $con->connect();
        }

        public function login($username, $password){
            $sql = "SELECT * FROM users where `username`='$username'";

            $result = mysqli_query($this->conne, $sql);

            $array_name = mysqli_fetch_array($result, MYSQLI_ASSOC);

            if(is_array($array_name) && count($array_name) > 0){
                $verify = password_verify($password, $array_name['password']);

                  if ($verify) {
                     // echo ("verified");
                      session_start();
                      $_SESSION['isAuthenticated'] = true;
                      $_SESSION['id'] = $array_name['id'];
                      $_SESSION['username'] = $array_name['username'];
                      $_SESSION['email'] = $array_name['email'];
                     // print_r($_SESSION);
                      return true;
                  }
            }
            return false;
        }

        public function logout(){
            session_start();
           if(isset($_SESSION['username'])){
               $_SESSION['isAuthenticated'] = false;
               $_SESSION['id'] = "";
               $_SESSION['username'] = "";
               $_SESSION['email'] = "";
               session_destroy();
               return true;
           }
           else{
               return false;
           }
        }

        public function ForgotPassword($email){
            $sql = "SELECT `email` FROM users WHERE `email` = '$email'";

            $result = mysqli_query($this->conne, $sql);

            $array_name = mysqli_fetch_array($result, MYSQLI_ASSOC);

            if(is_array($array_name) && count($array_name) > 0){
                $digits = 4;
                $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);

                $sql = "UPDATE users SET otp = '$otp' where email = '$email'";

                $result = mysqli_query($this->conne, $sql);

                if($result){
                    //sending otp via Email
                    $mail = new PHPMailer(true);

                    try {
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();

                        //Tell PHPMailer to use SMTP
                        $mail->isSMTP();
                        //$mail->SMTPDebug = 0;
                        //Enable SMTP debugging
                        //SMTP::DEBUG_OFF = off (for production use)
                        //SMTP::DEBUG_CLIENT = client messages
                        //SMTP::DEBUG_SERVER = client and server messages
                        $mail->SMTPDebug = false;

                        //Set the hostname of the mail server
                        $mail->Host = 'smtp.gmail.com';
                        //Use `$mail->Host = gethostbyname('smtp.gmail.com');`
                        //if your network does not support SMTP over IPv6,
                        //though this may cause issues with TLS

                        //Set the SMTP port number:
                        // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
                        // - 587 for SMTP+STARTTLS
                        $mail->Port = 465;

                        //Set the encryption mechanism to use:
                        // - SMTPS (implicit TLS on port 465) or
                        // - STARTTLS (explicit TLS on port 587)
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

                        //Whether to use SMTP authentication
                        $mail->SMTPAuth = true;

                        //Username to use for SMTP authentication - use full email address for gmail
                        $mail->Username = 'suman.sutar2013@gmail.com';

                        //Password to use for SMTP authentication
                        $mail->Password = 'masp yxxn zytn ljbx';

                        //Set who the message is to be sent from
                        //Note that with gmail you can only use your account address (same as `Username`)
                        //or predefined aliases that you have configured within your account.
                        //Do not use user-submitted addresses in here
                        $mail->setFrom('suman.sutar2013@gmail.com', 'First Last');

                        //Set an alternative reply-to address
                        //This is a good place to put user-submitted addresses
                        $mail->addAddress('suman.sutar2013@gmail.com', 'First Last');

                        //Set who the message is to be sent to
                        //$mail->addAddress('whoto@example.com', 'John Doe');

                        $mail->isHTML(true);
                            $mail->Subject = 'OTP for password change';
                            $mail->Body    = 'You have requested to change password on task app, Please use below otp to change </br><b>OTP - '.$otp.'</b>';

                        //Replace the plain text body with one created manually
                        $mail->AltBody = 'This is a plain-text message body';

                        //send the message, check for errors
                        if (!$mail->send()) {
                            return false;
                        } else {
                            return true;
                            //Section 2: IMAP
                            //Uncomment these to save your message in the 'Sent Mail' folder.
                            #if (save_mail($mail)) {
                            #    echo "Message saved!";
                            #}
                        }
                    }catch (Exception $e) {
                        return false;
                    }
                }else{
                    return false;
                }

            }else{
                return false;
            }
        }

        public function resetPassword($otp, $password, $email){

            $hash_password = password_hash($password,  PASSWORD_BCRYPT);

            $sql = "SELECT * FROM users WHERE `email` = '$email' AND `otp` = $otp";

            $result = mysqli_query($this->conne, $sql);

            $array_name = mysqli_fetch_array($result, MYSQLI_ASSOC);

            if(is_array($array_name) && count($array_name) > 0){

                $sql1 = "UPDATE `users` SET `password` = '$hash_password' WHERE `email` = '$email' AND `otp` = $otp";
            
                $result1 = mysqli_query($this->conne, $sql1);

                if($result1){
                    $sql2 = "UPDATE `users` SET `otp` = null WHERE `email` = '$email' AND `otp` = $otp";
                    $result1 = mysqli_query($this->conne, $sql2);
                    return true;
                }

                return false;
            }else{
                return false;
            }



        }

    }



 ?>

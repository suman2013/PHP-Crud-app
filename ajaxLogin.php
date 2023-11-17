<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    include "./Classes/login.php";

    $sFlag = $_GET['sFlag'];

    if($sFlag == "login"){
        $username = "";
        $password = "";
        $error_message = array();

        //Username Validation
        if(isset($_POST['username']) && $_POST['username'] != '' && $_POST['username'] != null){
            $username = $_POST['username'];
        }else{
            $error_message['username_error'] = "Username is required";
        }

        //Password Validation
        $uppercase = preg_match('@[A-Z]@', $_POST['password']);
        $lowercase = preg_match('@[a-z]@', $_POST['password']);
        $number    = preg_match('@[0-9]@', $_POST['password']);
        $specialChars = preg_match('@[^\w]@', $_POST['password']);

        if(!isset($_POST['password']) || $_POST['password'] == '' || $_POST['password'] == null){
            $error_message['password_error'] = "Password is required";
        }else{
            $password = $_POST['password'];
        }

        if(!empty($error_message)){
            header("Content-Type: application/json");
            echo(json_encode($error_message));
        }else{
            $oSignin = new Signin();
            $result = $oSignin->login($username, $password);
            $message = "You have been logged in successfully!";
            if(!$result){
                $message = "This username or password does not exist!";
            }
            $aResult = array('code'=>200, 'isSuccess' => $result, 'message' => $message);

            header("Content-Type: application/json");
            echo(json_encode($aResult));
        }

    }

    if($sFlag == "logout"){
        $oSignin = new Signin();
        $result = $oSignin->logout();
        $message = "You have been logged out successfully!";
        if(!$result){
            $message = "Some error occured!";
        }
        $aResult = array('code'=>200, 'isSuccess' => $result, 'message' => $message);

        header("Content-Type: application/json");
        echo(json_encode($aResult));
    }

    if($sFlag == "forgotpassword"){
        $email = "";
        $error_message = array();
        if(!isset($_POST['email']) || $_POST['email'] == '' || $_POST['email'] == null){
            $error_message['email_error'] = "Email is required";
        }else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $error_message['email_error'] = "Invalid Email!";
        }else{
            $email = $_POST['email'];
        }

        if(!empty($error_message)){
            header("Content-Type: application/json");
            echo(json_encode($error_message));
        }else{
            $oSignin = new Signin();
            $result = $oSignin->ForgotPassword($email);
            $message = "Otp has been emailed, please check your email, ";
            if(!$result){
                $message = "Some error occured!";
            }
            $aResult = array('code'=>200, 'isSuccess' => $result, 'message' => $message, 'email' => $email);

            header("Content-Type: application/json");
            echo(json_encode($aResult));
        }
    }

    if($sFlag == "resetPassword"){
        $password = "";
        $otp = "";
        $email = $_POST['email'];
        $error_message = array();
        //OTP
        if(!isset($_POST['otp']) || $_POST['otp'] == '' || $_POST['otp'] == null){
            $error_message['otp_error'] = "This field is required";
        }else{
            $otp = $_POST['otp'];
        }
        //Password Validation
        $uppercase = preg_match('@[A-Z]@', $_POST['newPassword']);
        $lowercase = preg_match('@[a-z]@', $_POST['newPassword']);
        $number    = preg_match('@[0-9]@', $_POST['newPassword']);
        $specialChars = preg_match('@[^\w]@', $_POST['newPassword']);

        if(!isset($_POST['newPassword']) || $_POST['newPassword'] == '' || $_POST['newPassword'] == null){
            $error_message['newpassword_error'] = "This field is required";
        }else if($_POST['newPassword'] != $_POST['confPassword']){
            $error_message['newpassword_error'] = "New password and confirm password does not match!";
        }elseif(!$uppercase || !$lowercase || !$number || !$specialChars){
            $error_message['newpassword_error'] = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
        }else{
            $password = $_POST['newPassword'];
        }

        if(!empty($error_message)){
            header("Content-Type: application/json");
            echo(json_encode($error_message));
        }else{
            $oSignin = new Signin();
            $result = $oSignin->resetPassword($otp, $password, $email);
            $message = "Password has been reset, please login using new password:)";
            if(!$result){
                $message = "Some error occured!";
            }
            $aResult = array('code'=>200, 'isSuccess' => $result, 'message' => $message);

            header("Content-Type: application/json");
            echo(json_encode($aResult));
        }

    }


 ?>

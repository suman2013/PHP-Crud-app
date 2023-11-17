<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    include "./Classes/signup.php";

    $sFlag = $_GET['sFlag'];

    if($sFlag == "signup"){
        $email = "";
        $username = "";
        $password = "";
        $error_message = array();

        //Email Validation

        if(!isset($_POST['email']) || $_POST['email'] == '' || $_POST['email'] == null){
            $error_message['email_error'] = "Email is required";
        }else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $error_message['email_error'] = "Invalid Email!";
        }else{
            $email = $_POST['email'];
        }

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
        }else if(!$uppercase || !$lowercase || !$number || !$specialChars){
            $error_message['password_error'] = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
        }else{
            $password = $_POST['password'];
        }
        //$response = array();
        if(!empty($error_message)){
            //$response['errors'] = $error_message;
            header("Content-Type: application/json");
            echo(json_encode($error_message));
        }else{
            $oSignup = new Signup();
            $result = $oSignup->register($username, $password, $email);
            $message = "You have been registered successfully, Please login!";
            if(!$result){
                $message = "This email or username already exist, Please provide other email and username!";
            }
            $aResult = array('code'=>200, 'isSuccess' => $result, 'message' => $message);
            //$response['result'] = $aResult;
            header("Content-Type: application/json");
            echo(json_encode($aResult));
        }

    }


 ?>

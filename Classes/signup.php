<?php
    include 'connection.php';

    class Signup
    {
        private $conne = '';

        function __construct()
        {
            $con = new Connection();
            $this->conne = $con->connect();
        }

        public function register($username, $password, $email){
            $sql = "SELECT * FROM users where `username`='$username' OR `email` = '$email'";

            $result = mysqli_query($this->conne, $sql);

            $array_name = mysqli_fetch_array($result, MYSQLI_ASSOC);

            if(is_array($array_name) && count($array_name) > 0)
                return false;
            else{
                $hash_password = password_hash($password,  PASSWORD_BCRYPT);

                $sql1 = "INSERT INTO users (`username`, `password`, `email`) VALUES ('$username', '$hash_password', '$email')";
//echo $sql1;
                $result1 = mysqli_query($this->conne, $sql1);
                if($result1){
                    return true;
                }
            }
            return false;
        }
    }



 ?>

<?php

  include 'connection.php';
  if(!isset($_SESSION))
    {
        session_start();
    }
  // do check
  if (!$_SESSION["isAuthenticated"]) {
      header("location: error.php");
      exit;
  }
  class Crud{
    private $conne = '';

    function __construct(){
      $con = new Connection();
      $this->conne = $con->connect();
    }

    function getTask($id){
        $userId = $_SESSION['id'];
      $sql = "SELECT `name`, `id` FROM tasks where `id`=".$id." AND created_by = $userId";
      $result = mysqli_query($this->conne, $sql);

      $task = mysqli_fetch_all($result, MYSQLI_ASSOC);

      return $task;
    }
    function add($name){
        $userId = $_SESSION['id'];
        $sql = "SELECT `name` FROM tasks where `name`='$name' AND created_by = $userId";
        //echo $sql;
        $result = mysqli_query($this->conne, $sql);

        $array_name = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if(is_array($array_name) && count($array_name) > 0)
            return false;
        else{
            $userId = $_SESSION['id'];
            $sql1 = "INSERT INTO tasks (`name`, `created_by`) VALUES ('$name', $userId)";

            $result1 = mysqli_query($this->conne, $sql1);
            if($result1){
                return true;
            }

        }
        return false;

    }

    function edit($id, $name){
        $userId = $_SESSION['id'];
      $sql = "UPDATE tasks SET name = '$name' where id = $id AND created_by = $userId";
      //echo $sql;

      $result = mysqli_query($this->conne, $sql);

      if($result){
          return true;
      }

      return false;

    }

    function view(){
        $userId = $_SESSION['id'];
        $sql = "SELECT * FROM tasks where deleted = 0 AND created_by = $userId";
        $result = mysqli_query($this->conne, $sql);

        $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $tasks;
    }

    function delete($id){
        $userId = $_SESSION['id'];
        $sql = "UPDATE tasks SET deleted = 1 where id = $id AND created_by = $userId";

        $result = mysqli_query($this->conne, $sql);

        if($result){
            return true;
        }

        return false;

    }

    function changeStatus($id){
        $userId = $_SESSION['id'];
        $sql = "SELECT * FROM tasks where `id`=".$id." AND created_by = $userId";
        $result = mysqli_query($this->conne, $sql);

        $task = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $status = 0;
        if($task[0]['status'] == 0){
            $status = 1;
        }

        $sql = "UPDATE tasks SET status = '$status', finished_at = CURRENT_TIMESTAMP where id = $id AND created_by = $userId";

        $result = mysqli_query($this->conne, $sql);

        if($result){
            return true;
        }

        return false;

    }

  }


 ?>

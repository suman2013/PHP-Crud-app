<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1); error_reporting(E_ALL);
  include './Classes/crud_data.php';

  $sFlag = $_GET['sFlag'];

  if($sFlag ==  "addTaskDetails"){ //print_r($_POST);
      $taskname = $_POST['addtaskName'];
      $oCrudData = new CrudData();
      $result = $oCrudData->addTask($taskname);
      $message = "This task is added!";
      if(!$result){
          $message = "This task is already added, Please check in list!";
      }
      $aResult = array('sCode' => 200, 'isSuccess' => $result, 'message' => $message);
      echo(json_encode($aResult));
  }

  if($sFlag == "getAllTaskDetails"){
    $oCrudData = new CrudData();
    $allTaskDetails = $oCrudData->getAllTask();
    header("Content-Type: application/json");
    echo(json_encode($allTaskDetails));
  };

  if($sFlag == "getTaskDetails"){
    $id = $_GET['taskId'];
    $oCrudData = new CrudData();
    $taskDetails = $oCrudData->getTaskDetails($id);
    header("Content-Type: application/json");
    echo(json_encode($taskDetails));
  }

  if($sFlag == "saveTaskDetails"){
    print_r( $_POST);
    $id = $_POST['taskId'];
    $name = $_POST['taskName'];

    $oCrudData = new CrudData();
    $result = $oCrudData->saveTask($id, $name);

    $aResult = array('sCode' => 200, 'isSuccess' => $result);
    echo(json_encode($aResult));

}

if($sFlag == "deleteTaskDetails"){
  $id = $_POST['idTaskID'];

  $oCrudData = new CrudData();
  $result = $oCrudData->deleteTask($id);

  $aResult = array('sCode' => 200, 'isSuccess' => $result);
  echo(json_encode($aResult));

}

if($sFlag == "changeStatusTaskDetails"){
    $id = $_POST['idStatusTaskIDName'];

    $oCrudData = new CrudData();
    $result = $oCrudData->changeStatusTask($id);

    $aResult = array('sCode' => 200, 'isSuccess' => $result);
    echo(json_encode($aResult));
}









 ?>

<?php

  include './classes/crud.php';
  if(!isset($_SESSION))
    {
        session_start();
    }
  // do check
  if (!$_SESSION["isAuthenticated"]) {
      header("location: error.php");
      exit;
  }
  class CrudData{

    public function getAllTask(){
      $crud = new Crud();
      return $crud->view();
    }

    public function getTaskDetails($id){
      $crud = new Crud();
      return $crud->getTask($id);
    }

    public function saveTask($id, $name){
      $crud = new Crud();
      return $crud->edit($id, $name);
    }

    public function addTask($name){
      $crud = new Crud();
      return $crud->add($name);
    }

    public function deleteTask($id){
      $crud = new Crud();
      return $crud->delete($id);
    }

    public function changeStatusTask($id){
        $crud = new Crud();
        return $crud->changeStatus($id);
    }
  }


 ?>

<?php

  include './classes/crud_data.php';
  if(!isset($_SESSION))
    {
        session_start();
    }
  // do check
  if (!$_SESSION["isAuthenticated"]) {
      header("location: error.php");
      exit;
  }
 ?>


 <!DOCTYPE html>
<html>
<head>
  <title>Page Title</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="
https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js
"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- Option 1: Include in HTML -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="app.css">
</head>
  <?php include './Templates/Header.php'; ?>
  <div class="container mt-4">
    <div class="alert alert-success alert-dismissible" role="alert" style="display: none;" id="idAlertSuccess">
      A simple success alert—check it out!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="alert alert-danger alert-dismissible" role="alert" style="display: none;" id="idAlertError">
      A simple danger alert—check it out!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="col-md-6 offset-md-11">
    <button type="button" class="btn btn-success" id="idCreateTask">Create Task</button>
</div>
    <hr>
    <table class="table table-striped mt-4" id="idTaskTable">
      <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Task Name</th>
      <th scope="col">Status</th>
      <th scope="col">created on</th>
      <th scope="col">Finished on</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody id="idTaskTableBody">
  </tbody>
  </table>
  </div>
  <!-- alert modal to add task -->
  <div class="modal" tabindex="-1" id="myModalAddTask" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="idAddTaskForm">
                    <div class="form-group">
                        <label>Task Name</label>
                        <input type="text" class="form-control"  name="addtaskName" id="idAddTaskName" placeholder="Enter Task name" value="">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="idAddCloseButton">Close</button>
                <button type="submit" class="btn btn-primary" id="idAddTask">Save</button>
            </div>
                </form>
        </div>
    </div>
  </div>
  <!-- alert modal to complete task -->
<div class="modal" tabindex="-1" id="myModal" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="idEditTaskForm">
                    <input type="hidden"  name="taskId" id="idTask" value="" />
                    <div class="form-group">
                        <label>Task Name</label>
                        <input type="text" class="form-control"  name="taskName" id="idTaskName" placeholder="Enter Task name" value="">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="idCloseButton">Close</button>
                <button type="submit" class="btn btn-primary" id="idEditTask">Save</button>
            </div>
                </form>
        </div>
    </div>
</div>
<!-- alert to delete task -->
<div class="modal" tabindex="-1" id="idDeleteTaskModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this task?</p>
      </div>
      <form id="idDeleteTaskForm">
          <input type="hidden"  name="idTaskID" id="idDeleteTaskId" value="" />
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="idDeleteCloseButton">Cancel</button>
            <button type="submit" class="btn btn-primary" id="idDeleteTask">Yes</button>
            </div>
      </form>
    </div>
  </div>
</div>

<!-- alert to mark task as complete-->
<div class="modal" tabindex="-1" id="idChangeStatusTaskModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Mark Complete Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p id="idStatusMessage"></p>
      </div>
      <form id="idChangeStatusForm">
          <input type="hidden"  name="idStatusTaskIDName" id="idStatusTaskId" value="" />
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="idChangeStatusCloseButton">Cancel</button>
            <button type="submit" class="btn btn-primary" id="idChangeStatusTask">Yes</button>
            </div>
      </form>
    </div>
  </div>
</div>
<?php include './Templates/Footer.php'; ?>
<script>

    jQuery(document).ready(function() {

        getAllTasks();
        function getAllTasks(){
            $.ajax({
                url:"http://localhost:8000/ajaxCrud.php?sFlag=getAllTaskDetails",
                type: "GET",
                success: function (data) {
                    console.log(data);
                    if(data){
                        $("#idTaskTableBody").children().remove();
                        for (let i = 0; i < data.length; i++) {
                            var status, finished, statusIcon;
                            if(data[i].status == '0'){
                                status = $('<td>').text("Created");
                                finished = $('<td>').text("None");
                                statusIcon = '<i class="bi bi-check-circle classChangeStatus" id= "idFinished_'+data[i].id+'"></i>';
                            }else if(data[i].status == '1'){
                                status = $('<td>').text("Finished");
                                finished = $('<td>').text(moment(data[i].finished_at).format('DD/MM/yyyy : hh:mm A'));
                                statusIcon = '<i class="bi bi-check-circle-fill classChangeStatus" id= "idFinished_'+data[i].id+'"></i>';
                            }
                                var $tr = $('<tr>').append(
                                    $('<td>').text(i+1),
                                    $('<td>').text(data[i].name),
                                    status,
                                    $('<td>').text(moment(data[i].created_at).format('DD/MM/yyyy : hh:mm A')),
                                    finished,
                                    $('<td>').html('<i class="bi bi-pencil-fill" id= "idEdit_'+data[i].id+'" ></i> <i class="bi bi-trash-fill" id= "idDelete_'+data[i].id+'"></i>'+ statusIcon)
                                );
                                $("#idTaskTableBody").append($tr);
                                
                        }
                    }else{
                        $("#idWelcomeNote").text("Welcome to the task app, start creating task and track your task here :)")
                    }
                },
                error: function (error) {
                    console.log(`Error ${error}`);
                }
            });
        }

        $(document).on('click', ".bi-pencil-fill", function(){
            const modalIdArray = this.id.split("_");
            var modalId = modalIdArray[1];
            $.ajax({
                url:"http://localhost:8000/ajaxCrud.php?sFlag=getTaskDetails",
                type: "GET",
                data:{taskId: modalId},
                success: function (data) {
                    if(data){
                         console.log(data);
                         $('#idTaskName').val(data[0].name);
                         $('#idTask').val(data[0].id);
                    }
                },
                error: function (error) {
                    console.log(`Error ${error}`);
                }
            });
            $("#myModal").modal('show');
        });

        $(document).on('click', "#idEditTask", function(){
            $("#idCloseButton").click();
            $('#idEditTaskForm').submit(function(e) { // handle the submit event
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "http://localhost:8000/ajaxCrud.php?sFlag=saveTaskDetails",
                    type: 'POST',
                    data: formData,
                    success:function(response){
                        if(response){
                            getAllTasks();
                            $("#idAlertSuccess").html("Task Updated successfully!");
                            $("#idAlertSuccess").css("display", "block");
                        }
                    }
                })
            })
        });


        $(document).on('click', "#idAddTask", function(){
            $("#idAddCloseButton").click();
            $('#idAddTaskForm').submit(function(e) { // handle the submit event
                e.preventDefault();
                var formData = $(this).serialize();
                //console.log(formData);
                $.ajax({
                    url: "http://localhost:8000/ajaxCrud.php?sFlag=addTaskDetails",
                    type: 'POST',
                    data: formData,
                    success:function(response){
                        if(response){
                            var res = JSON.parse(response);
                            getAllTasks();
                            $("#idAlertSuccess").html(res.message);
                            $("#idAlertSuccess").css("display", "block");
                        }
                    }
                })
            })
        });

        $(document).on('click', "#idCreateTask", function(){
            $("#idAddTaskName").val('');
            $("#myModalAddTask").modal('show');
        });

        $(document).on('click', ".bi-trash-fill", function(){
            const modalIdArray = this.id.split("_");
            var modalId = modalIdArray[1];
            $("#idDeleteTaskId").val(modalId);
            $("#idDeleteTaskModal").modal('show');
        });

        $(document).on('click', "#idDeleteTask", function(){
            $("#idDeleteCloseButton").click();
            $('#idDeleteTaskForm').submit(function(e) { // handle the submit event
                e.preventDefault();
                var formData = $(this).serialize();
                console.log(formData);
                $.ajax({
                    url: "http://localhost:8000/ajaxCrud.php?sFlag=deleteTaskDetails",
                    type: 'POST',
                    data: formData,
                    success:function(response){
                        if(response){
                            getAllTasks();
                            $("#idAlertSuccess").html("Task deleted successfully!");
                            $("#idAlertSuccess").css("display", "block");
                        }
                    }
                })
            })
        });


        $(document).on('click', ".bi-check-circle", function(){
            const modalIdArray = this.id.split("_");
            var modalId = modalIdArray[1];
            $("#idStatusTaskId").val(modalId);
            $("#idStatusMessage").text("Do you want to mark this task completed?");
            $("#idChangeStatusTaskModal").modal('show');
        });

        $(document).on('click', ".bi-check-circle-fill", function(){
            const modalIdArray = this.id.split("_");
            var modalId = modalIdArray[1];
            $("#idStatusTaskId").val(modalId);
            $("#idStatusMessage").text("Do you want to mark this task uncompleted?");
            $("#idChangeStatusTaskModal").modal('show');
        });


        var clickHandler = function(e){
            $('#idChangeStatusForm').submit(function(e) { // handle the submit event
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "http://localhost:8000/ajaxCrud.php?sFlag=changeStatusTaskDetails",
                    type: 'POST',
                    data: formData,
                    success:function(response){
                        if(response){
                            getAllTasks();
                            closeModal();
                            $("#idAlertSuccess").html("Task status has been updated successfully!");
                            $("#idAlertSuccess").css("display", "block");
                        }
                    }
                })
            })
        }

        //$("#idChangeStatusTask")

        function closeModal(){
            $("#idChangeStatusTaskModal").modal('hide');
        }

        $('#idChangeStatusTask').one('click', clickHandler);


    });


</script>
</html>

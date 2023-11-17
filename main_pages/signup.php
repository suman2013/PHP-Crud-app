<?php

 ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Page Title</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js
"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <!-- Option 1: Include in HTML -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="../app.css">
    </head>
    <?php include '../Templates/Header.php'; ?>
        <div class="container mt-4 d-flex justify-content-center">
            <div class="alert alert-success alert-dismissible" role="alert" style="display: none;" id="idAlertSuccess">
              A simple success alert—check it out!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="alert alert-danger alert-dismissible" role="alert" style="display: none;" id="idAlertError">
              A simple danger alert—check it out!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="card w-75 " style="height: 30rem;">
                <div class="card-body">
                    <h5 class="card-title text-center text-primary fs-2">Sign Up</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary text-center">We'll never share your details with anyone else.</h6>
                    <hr>
            <form id="idSignupForm">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="text" class="form-control" name="email" id="idEmail" value="">
                    <div id="idAlertEmail" class="form-text text-danger"></div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">User Name</label>
                    <input type="text" class="form-control" name="username" id="idUsername" value="">
                    <div id="idAlertUsername" class="form-text text-danger"></div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="idPassword" value="">
                    <div id="idAlertPassword" class="form-text text-danger"></div>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" id="idSubmitSignup" class="btn btn-primary">Submit</button>
                </div
            </form>
            <div class="mt-3 text-center">
                <a class="text-center" href="../index.php">Already have account? Click here</a>
            </div>
        </div>
    </div>
        </div>
    <?php include '../Templates/Footer.php'; ?>
    <script>
        jQuery(document).ready(function() {
            $(document).on('click', "#idSubmitSignup", function(){
                $('#idSignupForm').submit(function(e) { // handle the submit event
                    e.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        url:"http://localhost:8000/ajaxSignup.php?sFlag=signup",
                        type: "POST",
                        data: formData,
                        success: function (data) {
                            if(data){
                                //data = JSON.Parse(data);
                                console.log(data);
                                 if(data.email_error){
                                     $("#idAlertEmail").text(data.email_error);
                                 }else{
                                     $("#idAlertEmail").text("");
                                 }
                                 if(data.password_error){
                                     $("#idAlertPassword").text(data.password_error);
                                 }else{
                                      $("#idAlertPassword").text("");
                                 }
                                 if(data.username_error){
                                     $("#idAlertUsername").text(data.username_error);
                                 }else{
                                     $("#idAlertUsername").text("");
                                 }
                                 if(data.message){
                                      $("#idAlertSuccess").text(data.message);
                                      $("#idAlertSuccess").css("display", "block");
                                      $("#idEmail").val("");
                                      $("#idUsername").val("");
                                      $("#idPassword").val("");
                                      $("#idAlertError").css("display", "none");
                                 }
                            }
                        },
                        error: function (error) {
                            //error = JSON.parse(error)
                            console.log(error);
                        }
                    });
                });
            });
        });
    </script>
 </html>

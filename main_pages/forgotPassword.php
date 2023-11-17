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
            <div class="card w-50 ">
                <div class="card-body">
                    <h5 class="card-title text-center text-primary fs-2">Reset Password</h5>

                    <hr>
            <form id="idForgotPasswordForm">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="text" class="form-control" name="email" id="idEmail" value="">
                    <div id="idAlertEmail" class="form-text text-danger"></div>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" id="idSubmitForgotPassword" class="btn btn-primary">Submit</button>
                </div
            </form>

        </div>
    </div>
        </div>
        <!-- alert to mark task as complete-->
        <div class="modal" tabindex="-1" id="idAlertForgotPassModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p id="idForgotPassMessage"></p>
              </div>
              <form>
                  <input type="hidden"  name="hiddenEmail" id="idHiddenEmail" value="" />
                  <input type="hidden"  name="statusEmail" id="idStatusEmail" value="" />
              </form>
              <div class="modal-footer">

                <button type="button" class="btn btn-primary" id="idForgotPass">Ok</button>
              </div>
            </div>
          </div>
        </div>
    <?php include '../Templates/Footer.php'; ?>
    <script>
        jQuery(document).ready(function() {
            $(document).on('click', "#idSubmitForgotPassword", function(){
                $('#idForgotPasswordForm').submit(function(e) { // handle the submit event
                    e.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        url:"http://localhost:8000/ajaxLogin.php?sFlag=forgotpassword",
                        type: "POST",
                        data: formData,
                        success: function (data) {
                            if(data){

                                $("#idForgotPassMessage").text(data.message);
                                $("#idHiddenEmail").val(data.email);
                                $("#idStatusEmail").val(data.isSuccess);
                                $("#idAlertForgotPassModal").modal('show');


                            }
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                });
            });
            $(document).on('click', "#idForgotPass", function(){
                $("#idAlertForgotPassModal").modal('hide');
            });

            $('#idAlertForgotPassModal').on('hidden.bs.modal', function () {
                openResetPassPage();
            })

            function openResetPassPage(){
                var emailstatus = $("#idStatusEmail").val();
                var email = $("#idHiddenEmail").val();
                if(emailstatus){
                    window.location.replace("http://localhost:8000/main_pages/resetPass.php?email="+email);
                }
            }

        });
    </script>
 </html>

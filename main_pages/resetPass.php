<?php
    $email = "";
    if(isset($_GET['email'])){
        $email = $_GET['email'];
    }

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
                     <h5 class="card-title text-center text-primary fs-2">Provide New Password with otp</h5>
                     <hr>
             <form id="idResetPassForm">
                 <input type="hidden" class="form-control" name="email" id="idEmail" value="<?php echo $email; ?>">
                 <div class="mb-3">
                     <label for="exampleInputotp" class="form-label">OTP</label>
                     <input type="text" class="form-control" name="otp" id="idOtp" value="">
                     <div id="idAlertOtp" class="form-text text-danger"></div>
                 </div>
                 <div class="mb-3">
                     <label for="exampleInputNewPassword" class="form-label">New Password</label>
                     <input type="password" class="form-control" name="newPassword" id="idNewPassword" value="">
                     <div id="idAlertNewPassword" class="form-text text-danger"></div>
                 </div>
                 <div class="mb-3">
                     <label for="exampleInputConfPassword" class="form-label">Confirm Password</label>
                     <input type="password" class="form-control" name="confPassword" id="idConfPassword" value="">
                     <div id="idAlertConfPassword" class="form-text text-danger"></div>
                 </div>
                 <div class="d-grid gap-2 col-6 mx-auto">
                 <button type="submit" id="idSubmitResetPass" class="btn btn-primary">Submit</button>
                 </div
             </form>

         </div>
     </div>
         </div>

         <!-- alert to mark task as complete-->
         <div class="modal" tabindex="-1" id="idAlertResetPassModal">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <h5 class="modal-title">Message</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                <form>
                    <input type = "hidden" name ="pass_status" id="idPassStatus" value=""/>
                </form>
                 <p id="idResetPassMessage"></p>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-primary" id="idResetPass">Ok</button>
               </div>
             </div>
           </div>
         </div>
     <?php include '../Templates/Footer.php'; ?>
     <script>
         jQuery(document).ready(function() {
             $(document).on('click', "#idSubmitResetPass", function(){
                 $('#idResetPassForm').submit(function(e) { // handle the submit event
                     e.preventDefault();
                     var formData = $(this).serialize();
                     $.ajax({
                         url:"http://localhost:8000/ajaxLogin.php?sFlag=resetPassword",
                         type: "POST",
                         data: formData,
                         success: function (data) {
                             if(data){
                                 if(data.newpassword_error){
                                     $("#idAlertNewPassword").text(data.newpassword_error);
                                 }
                                 if(data.otp_error){
                                     $("#idAlertOtp").text(data.otp_error);
                                 }

                                 if(data.isSuccess ){
                                     $("#idResetPassMessage").text(data.message);
                                     $("#idPassStatus").val(1);
                                     $("#idAlertResetPassModal").modal('show');
                                 }
                                 if(!data.isSuccess){
                                     $("#idResetPassMessage").text(data.message);
                                     $("#idPassStatus").val(0);
                                     $("#idAlertResetPassModal").modal('show');
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

             $(document).on('click', "#idResetPass", function(){
                 $("#idAlertResetPassModal").modal('hide');
             });

             $('#idAlertResetPassModal').on('hidden.bs.modal', function () {
                 openLoginPage();
             })

             function openLoginPage(){
                 var status = $("#idPassStatus").val();
                    if(status == 1){
                        window.location.replace("http://localhost:8000/");
                    }


             }
         });
     </script>
  </html>

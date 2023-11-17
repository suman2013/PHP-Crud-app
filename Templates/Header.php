<body style="background-color:LightGray;">
  <nav class="navbar" id="header">
  <div class="container">
    <a class="navbar-brand" href="#">
      <i class="bi bi-list-task fs-1 fw-bold" title="To Do App"></i>
    </a>
    <?php if(isset($_SESSION['username'])) {?>
        <div class="d-flex justify-content-end" >
            <!--<img src="" alt="Avatar" class="avatar bg-primary">&nbsp;&nbsp;-->
            <button class="btn btn-success" type="submit" id="idLogout">Logout</button>
        </div>
    <?php } ?>
    <?php //if(!isset($_SESSION['username'])) {?>
    <!--<div class="d-flex" >
        <div class="col-md-6">
        <a class="btn btn-success " href="../index.php">Login</a>
        </div>
        <div class="col-md-6">
        <a class="btn btn-success " href="./main_pages/signup.php">Signup</a>
        </div>
    </div>-->

    <?php// } ?>
  </div>
</nav>

<script>
jQuery(document).ready(function() {
    $(document).on('click', "#idLogout", function(){
            $.ajax({
                url:"http://localhost:8000/ajaxLogin.php?sFlag=logout",
                type: "GET",
                success: function (data) {
                    if(data){
                         if(data.isSuccess){
                             window.location.href = "http://localhost:8000/index.php";
                         }else{
                             window.location.href = "http://localhost:8000/error.php";
                         }
                    }
                },
                error: function (error) {
                    console.log(`Error ${error}`);
                }
            });
    });
});
</script>

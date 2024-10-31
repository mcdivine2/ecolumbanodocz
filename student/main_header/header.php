
<?php
 
  include('../init/model/class_model.php');
       session_start();
    if(!(trim($_SESSION['student_id']))){
        header('location:../index.php');
    }

?>

<!doctype html>
<html lang="en">

 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../asset/vendor/fontawesome-free/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../asset/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../asset/libs/css/style.css">
    <link rel="stylesheet" href="../asset/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../asset/vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="../asset/vendor/datatables/css/buttons.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="../asset/vendor/datatables/css/select.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="../asset/vendor/datatables/css/fixedHeader.bootstrap4.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Diplomata+SC&family=Yanone+Kaffeesatz&display=swap');</style> 
    <title>Online-School-Documents-Processing</title>
    <style>

 /* ======================Add-request========================== */
    .hidden {
      display: none;
    }

    .spinner {
      display: flex;
      align-items: center;
    }
    
    .spinner input {
      text-align: center;
      max-width: 50px;
      height: 25px;
      font-size: 14px;
     
    }
    .spinner button {
      width: 25px;
      height: 25px;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 0;
      font-size: 14px;
    }
    .colorful .btn-minus {
      background-color: red;
      color: white;
    }
    .colorful .btn-plus {
      background-color: green;
      color: white;
    }

   /* ================================================ */
        ul.navbar-nav li a{
            color: rgb(207, 214, 200) !important;
        }
        ul.navbar-nav li a i{
            color: rgb(207, 214, 200) !important;
        }
        .navbar-brand{
            color: rgb(255, 55, 0) !important;
        }
         .box {
            display: flex;
            flex-direction:row;
          }

          .one {
            flex: 1 1 auto;
          }

          .two {
            flex: 1 1 auto;
          }

          .three {
            flex: 1 1 auto;
           }
        .four {
            flex: 1 1 auto;
           }

           * {
    box-sizing: border-box;
}

.form-box {
    background-color: #8ac088;
    margin: auto auto;
    padding: 40px;
    border-radius: 5px;
    box-shadow: 0 0 10px #000;

}

.form-box .header-text {
    font-size: 22px;
    font-weight: 600;
    padding-bottom: 30px;
    text-align: center;
}
.form-box .form-text {
    font-size: 15px;
    color: #fff;
    font-weight: 600;
    padding-bottom: 10px;
    text-align: center;
}
.form-box input {
    margin: 10px 0px;
    border: none;
    padding: 10px;
    border-radius: 5px;
    width: 100%;
    font-size: 18px;
    font-family: poppins;
}
.form-box input[type=checkbox] {
    display: none;
}
.form-box label {
    position: relative;
    margin-left: 5px;
    margin-right: 10px;
    top: 5px;
    display: inline-block;
    width: 20px;
    height: 20px;
    cursor: pointer;
}
.form-box label:before {
    content: "";
    display: inline-block;
    width: 20px;
    height: 20px;
    border-radius: 5px;
    position: absolute;
    left: 0;
    bottom: 1px;
    background-color: #ddd;
}
.form-box input[type=checkbox]:checked+label:before {
    content: "\2713";
    font-size: 20px;
    color: #000;
    text-align: center;
    line-height: 20px;
}
.form-box span {
    font-size: 14px;
}
.form-box button {
    background-color: #d59f2a;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    font-size: 18px;
    padding: 10px;
    margin: 20px 0px;
}
span a {
    color: #BBB;
}


/*Profile image */


#profileImage {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border-color: white !important;
        border-style: solid;
        border-width: 2px;
        background:#008dff;
        font-size: 16px;
        color: #fff;
        text-align: center;
        line-height: 41px;
        margin: 0px 0;
        }

        #head-color{
            background: rgb(17,10,134);
            background: linear-gradient(90deg, rgba(1,68,33) 0%, rgba(18,53,36) 28%, rgba(0,102,0) 100%);
        }

        #title-style{
            color: #FDC741;
            font-size: 100%;
            size: 3em;
            
        }

/*Profile image */
#profileImage_2 {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  border-color: white !important;
    border-style: solid;
    border-width: 2px;
    background:#008dff;
  font-size: 35px;
  color: black;
  text-align: center;
  line-height: 150px;
  margin: 20px 0;
}

    </style>

</head>



<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg fixed-top" id="head-color" >
            <a class="navbar-brand" href="index.php"><p id="title-style"><img class="logo-scc" src="../asset/images/scc_logo.png" alt ="logo" width="70px" height="50px">&nbsp;&nbsp;e-Docs-Columbano</p></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">

                    <ul class="navbar-nav ml-auto navbar-right-top">

                         <li class="nav-item dropdown" style="padding-right: 10px">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="badge badge-danger count"></span>&nbsp;<i class="fa fa-bell" style="color: black"></i></a>
                            <div class="dropdown-menu dropdown-menu-right dropdown dropdown-menu_1" aria-labelledby="navbarDropdownMenuLink1" style="width: 400px">

                            </div>
                        </li>&nbsp;&nbsp;
                         <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><!-- <img id="profileImage" alt="" class="user-avatar-md rounded-circle"> -->
                                <div id="profileImage"></div>
                            </a>
                            
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info" style="background-color: #1269af">
                                    <h5 class="mb-0 text-white nav-user-name">
                                    <?php

                                        $student_id = $_SESSION['student_id'];
                                        $conn = new class_model();
                                        $user = $conn->student_account($student_id);
                                        echo '<center><h4 class = "text-warning" style="color:white !important">Welcome!<br><b><span id="lastName">'.ucfirst($user['last_name']).'</span>, <span id="firstName">'.ucfirst($user['first_name']).'</span></b></h4></center>';
                                    ?>
                                    </h5><hr style="background-color:#ffffff !important">
                                    <a href="logout/logout.php"><i class="fas fa-power-off mr-2"></i><span class="ml-3">Logout</span></a>
                                </div>

                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
   <script type="text/javascript">
        $(document).ready(function(){
          var firstName = $('#firstName').text();
          var lastName = $('#lastName').text();
          var intials = $('#firstName').text().charAt(0) + $('#lastName').text().charAt(0);
          var profileImage = $('#profileImage').text(intials);
        });
    </script>

<script>
$(document).ready(function(){
 
 function load_unseen_notification(view = '')
 {
  $.ajax({
   url:"../init/controllers/fetch.php",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
     $('.dropdown-menu_1').html(data.notification);
    if(data.unseen_notification > 0)
    {
     $('.count').html(data.unseen_notification);
    }
   }
  });
 }
 
 load_unseen_notification();

 $(document).on('click', '.dropdown-toggle', function(){
  $('.count').html('');
  load_unseen_notification('yes');
 });
 
 setInterval(function(){ 
  load_unseen_notification();; 
 }, 4000);
 
});
</script>
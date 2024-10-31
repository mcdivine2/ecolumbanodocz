<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
    html,
    body {
       
        height: 110%;
        min-height:100%;
        background:linear-gradient(0deg, rgba(2, 115, 0), rgba(35, 152, 228, 0.4)), url("assets/images/scc-bg2.png");
        background-size:cover;
    }

    body {
        -ms-flex-align: center;
        align-items: center;
        padding-bottom: 40px;
    }
    
    </style>
</head>

<body>

 <!-- As a heading -->
 <nav class="navbar navbar-dark bg-primary" style="background: rgb(17,10,134);
            background: linear-gradient(90deg, rgba(1,68,33) 0%, rgba(18,53,36) 28%, rgba(0,102,0) 100%);">
  <span class="navbar-brand mb-0 h1">Administrator</span>
</nav>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container" style="margin-top: 30px">
        <div class="card ">
            <div class="card-header text-center"><a href="index.html"><img class="scc_logo" src="assets/images/scc_logo.png" alt="prmsu_logo" height="200px"></a></div>
            <div class="card-body">
                <form method="post" name="login_form">

                    <div class="form-group">
                    <div class="dropdown">
                        <a class="btn btn-dark dropdown-toggle container-fluid" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dean
                        </a>

                    <div class="dropdown-menu container-fluid" aria-labelledby="dropdownMenuLink" >
                        
                    <a class="dropdown-item container-fluid" href="https://ecolumbanodocz.com/administrative-accounting/">Administrative Accounting</a>
                        <a class="dropdown-item container-fluid" href="https://ecolumbanodocz.com/administrative-library/" >Administrative Library</a>
                        <a class="dropdown-item container-fluid" href="https://ecolumbanodocz.com/administrative-custodian/" >Administrative Custodian</a>
                        <a class="dropdown-item container-fluid" href="https://ecolumbanodocz.com/administrative-dean/" >Administrative Dean</a>
                        <a class="dropdown-item container-fluid" href="https://ecolumbanodocz.com/admin/" >Administrative Registrar</a>
                    </div>
                    </div>
                    </div>
                    <br>



                    <div class="form-group">
                        <input class="form-control form-control-lg" id="username" alt="username" type="text" placeholder="Username" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" id="password" type="password" alt="password" placeholder="Password"  autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="remember" onclick="myFunction()"><span class="custom-control-label">Show Password</span>
                        </label>
                    </div>
                   <div class="form-group">
                   <button class="btn btn-lg btn-block" style="background-color:rgb(235, 151, 42) !important;
                      color: rgb(243, 245, 238) !important;" value="Sign in" id="btn-login" name="btn-login">Sign in</button>
                    </div>
                     <div class="form-group" id="alert-msg">
                </form>
            </div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script type="text/javascript">
      document.oncontextmenu = document.body.oncontextmenu = function() {return false;}//disable right click
    </script>
  
     <script type="text/javascript">
            jQuery(function(){
                $('form[name="login_form"]').on('submit', function(e){
                    e.preventDefault();

                    var u_username = $(this).find('input[alt="username"]').val();
                    var p_password = $(this).find('input[alt="password"]').val();
                    var s_status = 1;

                    if (u_username === '' && p_password ===''){
                        $('#alert-msg').html('<div class="alert alert-danger"> Required Username and Password!</div>');
                    }else{
                        $.ajax({
                            type: 'POST',
                            url: 'init/controllers/login_process.php',
                            data: {
                                username: u_username,
                                password: p_password,
                                status: s_status
                            },
                            beforeSend:  function(){
                                $('#alert-msg').html('');
                            }
                        })
                        .done(function(t){
                            if (t == 0){
                                $('#alert-msg').html('<div class="alert alert-danger">Incorrect username or password!</div>');
                                
                            }else{
                                $("#btn-login").html('<img src="assets/images/loading.gif" /> &nbsp; Signing In ...');
                                setTimeout(' window.location.href = "documents/index.php"; ',2000);
                            }
                        });
                    }
                });
           });
        </script>
        <script>
            function myFunction() {
              var x = document.getElementById("password");
              if (x.type === "password") {
                x.type = "text";
              } else {
                x.type = "password";
              }
            }
     </script>
    </body>
</html>
<?php include('main_header/header.php');?>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
         <?php include('left_sidebar/sidebar.php');?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
               <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                             <h2 class="pageheader-title"><i class="fa fa-fw fa-user-lock"></i> Select Designation </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Designation</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
             
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card influencer-profile-data">
                                        <div class="card-body">
                                            <div class="" id="message"></div>
                                            <form id="validationform" name="user_form" data-parsley-validate="" novalidate="" method="POST">
                                                
                                                
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right"><i class="fa fa-user"></i> &nbsp;&nbsp;&nbsp;Designation</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">

                                                    <div class="dropdown">
                                                        <a class="btn btn-dark dropdown-toggle container-fluid" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        &larr;Select Designation&rarr;
                                                         </a>

                                                            <div class="dropdown-menu container-fluid" aria-labelledby="dropdownMenuLink" >
                                                            <a class="dropdown-item container-fluid" href="add-user.php">Administrator Registrar</a>
                                                            <a class="dropdown-item container-fluid" href="add-admin-treasurer.php">Administrative Treasurer</a>
                                                            <a class="dropdown-item container-fluid" href="add-admin-library.php" >Administrative Library</a>
                                                            <a class="dropdown-item container-fluid" href="add-admin-custudian.php" >Administrative Custudian</a>
                                                            <a class="dropdown-item container-fluid" href="add-admin-dean.php" >Administrative Dean</a>
                                                        </div>
                                                        </div>

                                                        
                                                    </div>
                                                </div>
                                               
                                            </form>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
           
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../assets/vendor/parsley/parsley.js"></script>
    <script src="../assets/libs/js/main-js.js"></script>
   
</body>
 
</html>
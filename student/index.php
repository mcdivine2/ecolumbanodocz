<?php include('main_header/header.php'); ?>

<!-- Left Sidebar -->
<?php include('left_sidebar/sidebar.php'); ?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <!-- Page Header -->
        <div class="row">
            <div class="col-xl-12">
                <div class="page-header">
                    <h2 class="pageheader-title"><i class="fa fa-fw fa-tachometer-alt"></i> Dashboard</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Home</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Metrics -->
        <div class="row">
            <?php 
            $student_id = $_SESSION['student_id'];
            $conn = new class_model(); 
            ?>
            
            <!-- Pending Request -->
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <?php 
                        $cstudent = $conn->count_numberoftotalreceived($student_id); 
                        foreach ($cstudent as $row): ?>
                            <div class="d-inline-block">
                                <h5 class="text-muted">Pending Request</h5>
                                <h2 class="mb-0"><?= $row['count_received']; ?></h2>
                            </div>
                            <div class="float-right icon-circle-medium icon-box-lg mt-1" style="background-color:#1269AF">
                                <i class="fa fa-paper-plane fa-fw fa-sm text-info" style="color: white;"></i>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="pending-request.php" class="btn btn-primary" style="background-color:#1269AF">View</a>
                </div>
            </div>

            <!-- Waiting for Payment -->
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <?php 
                        $cstudent = $conn->count_numberoftotalpending($student_id); 
                        foreach ($cstudent as $row): ?>
                            <div class="d-inline-block">
                                <h5 class="text-muted">Waiting for Payment</h5>
                                <h2 class="mb-0"><?= $row['count_pending']; ?></h2>
                            </div>
                            <div class="float-right icon-circle-medium icon-box-lg mt-1" style="background-color:#1269AF">
                                <i class="fa fa-clock fa-fw fa-sm text-info" style="color: white;"></i>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="pending-payment.php" class="btn btn-primary" style="background-color:#1269AF">View</a>
                </div>
            </div>

            <!-- Completed -->
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <?php 
                        $cstudent = $conn->count_numberofreleased($student_id); 
                        foreach ($cstudent as $row): ?>
                            <div class="d-inline-block">
                                <h5 class="text-muted">Completed</h5>
                                <h2 class="mb-0"><?= $row['count_released']; ?></h2>
                            </div>
                            <div class="float-right icon-circle-medium icon-box-lg mt-1" style="background-color:#1269AF">
                                <i class="fa fa-calendar-check fa-fw fa-sm text-info" style="color: white;"></i>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="releasing.php" class="btn btn-primary" style="background-color:#1269AF">View</a>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <?php 
                        $cstudent = $conn->count_declined($student_id); 
                        foreach ($cstudent as $row): ?>
                            <div class="d-inline-block">
                                <h5 class="text-muted">Declined</h5>
                                <h2 class="mb-0"><?= $row['count_declined']; ?></h2>
                            </div>
                            <div class="float-right icon-circle-medium icon-box-lg mt-1" style="background-color:#1269AF">
                                <i class="fa fa-calendar-check fa-fw fa-sm text-info" style="color: white;"></i>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="declined.php" class="btn btn-primary" style="background-color:#1269AF">View</a>
                </div>
            </div>
        </div>

    </div> <!-- End Container Fluid -->
</div> <!-- End Dashboard Wrapper -->

<!-- Optional JavaScript -->
<script src="../asset/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../asset/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../asset/vendor/slimscroll/jquery.slimscroll.js"></script>
<script src="../asset/vendor/charts/charts-bundle/Chart.bundle.js"></script>
<script src="../asset/vendor/charts/charts-bundle/chartjs.js"></script>
<script src="../asset/libs/js/main-js.js"></script>
<script src="../asset/libs/js/dashboard-sales.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var firstName = $('#firstName').text();
        var lastName = $('#lastName').text();
        var initials = firstName.charAt(0) + lastName.charAt(0);
        $('#profileImage').text(initials);
    });
</script>
</body>
</html>

<?php include('main_header/header.php'); ?>
<!-- ============================================================== -->
<!-- end navbar -->
<!-- ============================================================== -->
<?php include('left_sidebar/sidebar.php'); ?>
<!-- ============================================================== -->
<!-- end left sidebar -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title"><i class="fa fa-fw fa-file"></i> Document Request</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item" aria-current="page">Document Requests</li>
                                <li class="breadcrumb-item active" aria-current="page">Processing</li>
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
                <div class="card">
                    <h5 class="card-header">Request Information</h5>
                    <div class="card-body">
                        <div id="message"></div>
                        <div class="table-responsive">
                            <a href="add-request.php" class="btn btn-sm" style="background-color:rgb(235, 151, 42) !important; color: rgb(243, 245, 238) !important;">
                                <i class="fa fa-fw fa-plus"></i> Add Request
                            </a>
                            <br><br>
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th scope="col">Control No.</th>
                                        <th scope="col">Student ID</th>
                                        <th scope="col">Document Name</th>
                                        <th scope="col">Date Request</th>
                                        <th scope="col">Date Declined</th>
                                        <th scope="col">Processing Officer</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $student_id = $_SESSION['student_id'];
                                    $conn = new class_model();
                                    $docrequest = $conn->fetchAll_declined($student_id);
                                    foreach ($docrequest as $row) { ?>
                                        <tr>
                                            <td><?= $row['control_no']; ?></td>
                                            <td><?= $row['student_id']; ?></td>
                                            <td><?= $row['document_name']; ?></td>
                                            <td><?= date("M d, Y", strtotime($row['date_request'])); ?></td>
                                            <td><?= !empty($row['date_releasing']) ? date("M d, Y", strtotime($row['date_releasing'])) : ""; ?></td>
                                            <td><?= $row['processing_officer']; ?></td>
                                            <td>
                                                <?php 
                                                $statusClasses = [
                                                    "Pending Request" => "bg-info",
                                                    "Processing" => "bg-danger",
                                                    "Releasing" => "bg-success",
                                                    "Received" => "bg-warning"
                                                ];
                                                echo '<span class="badge ' . ($statusClasses[$row['registrar_status']] ?? 'bg-secondary') . ' text-white">' . $row['registrar_status'] . '</span>'; 
                                                ?> 
                                            </td>
                                            <td class="align-right">
                                                <div class="box">
                                                    <div class="four">
                                                    <a href="Track-document.php?request=<?= $row['request_id']; ?>&student-number=<?= $row['student_id']; ?>" class="btn btn-sm btn-primary text-xs" data-toggle="tooltip" data-original-title="Clearance">
                                                        Clearance
                                                    </a>
                                                    </div> 
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end responsive table -->
            <!-- ============================================================== -->
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- end main wrapper -->
<!-- ============================================================== -->
<!-- Optional JavaScript -->
<script src="../asset/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../asset/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../asset/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../asset/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="../asset/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
<script src="../asset/vendor/datatables/js/data-table.js"></script>
<script src="../asset/libs/js/main-js.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var firstName = $('#firstName').text();
        var lastName = $('#lastName').text();
        var initials = firstName.charAt(0) + lastName.charAt(0);
        $('#profileImage').text(initials);

        // Load unseen notifications
        function load_unseen_notification(view = '') {
            $.ajax({
                url: "../init/controllers/fetch.php",
                method: "POST",
                data: {view: view},
                dataType: "json",
                success: function(data) {
                    $('.dropdown-menu_1').html(data.notification);
                    if (data.unseen_notification > 0) {
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

        setInterval(load_unseen_notification, 4000);

        // Delete request
        $(document).on('click', '.delete', function() {
            var request_id = $(this).attr("data-id");
            if (confirm("Are you sure you want to remove this data?")) {
                $.ajax({
                    url: "../init/controllers/delete_request.php",
                    method: "POST",
                    data: {request_id: request_id},
                    success: function(response) {
                        $("#message").html(response);
                    },
                    error: function() {
                        console.log("Failed");
                    }
                });
            }
        });
    });
</script>
</body>
</html>

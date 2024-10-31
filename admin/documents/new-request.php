<?php include('main_header/header.php'); ?>
<!-- ============================================================== -->
<!-- end navbar -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- left sidebar -->
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
                                <li class="breadcrumb-item active" aria-current="page">Document Request</li>
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
                            <table class="table table-striped table-bordered first" attribute="data-show-print" type="boo lean">
                                <thead>
                                    <tr>
                                        <th scope="col">Date Requested</th>
                                        <th scope="col">Control No.</th>
                                        <th scope="col">Student ID</th>
                                        <th scope="col">Document Name</th>
                                        <th scope="col">Mode Request</th>
                                        <th scope="col">Processing Officer</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $conn = new class_model();
                                        $docrequest = $conn->fetchAll_newrequest();
                                    ?>
                                    <?php foreach ($docrequest as $row) { ?>
                                        <tr>
                                            <td><?= date("M d, Y", strtotime($row['date_request'])); ?></td>
                                            <td><?= $row['control_no']; ?></td>
                                            <td><?= $row['student_id']; ?></td>
                                            <td><?= $row['document_name']; ?></td>
                                            <td><?= $row['mode_request']; ?></td>
                                            <td><?= $row['processing_officer']; ?></td>
                                            <td>
                                                <?php 
                                                  if ($row['registrar_status'] === "Pending") {
                                                      echo '<span class="badge bg-primary text-white">Pending</span>'; // Blue for pending
                                                  } else if ($row['registrar_status'] === "Received") {
                                                      echo '<span class="badge bg-info text-white">Received</span>'; // Light blue for received
                                                  } else if ($row['registrar_status'] === "Waiting for Payment") {
                                                      echo '<span class="badge bg-warning text-dark">Waiting for Payment</span>'; // Yellow for waiting, dark text for contrast
                                                  } else if ($row['registrar_status'] === "Verified") {
                                                      echo '<span class="badge bg-success text-white">Verified</span>'; // Green for verified
                                                  } else if ($row['registrar_status'] === "Declined") {
                                                      echo '<span class="badge bg-danger text-white">Declined</span>'; // Red for declined
                                                  }
                                                ?> 
                                            </td>
                                            <td class="align-right">
                                                <a href="edit-request.php?request=<?= $row['request_id']; ?>&student-number=<?= $row['student_id']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit request">
                                                    <i class="fa fa-edit"></i>
                                                </a> |
                                                <a href="Track-document.php?request=<?= $row['request_id']; ?>&student-number=<?= $row['student_id']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit request">
                                                    <i class="fa fa-eye"></i>
                                                </a> |
                                                <!-- <a href="javascript:;" data-id="<?= $row['request_id']; ?>" class="text-secondary font-weight-bold text-xs delete" data-toggle="tooltip" data-original-title="Delete request">
                                                    <i class="fa fa-trash-alt"></i>
                                                </a> | -->
                                                <a href="email-form-r.php?request=<?= $row['request_id']; ?>&student-number=<?= $row['student_id']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Send email">
                                                    <i class="fa fa-envelope"></i>
                                                </a>
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
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
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
<script src="../assets/vendor/custom-js/jquery.multi-select.html"></script>
<script src="../assets/libs/js/main-js.js"></script>
<script src="../assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
<script src="../assets/vendor/datatables/js/data-table.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var firstName = $('#firstName').text();
    var lastName = $('#lastName').text();
    var initials = firstName.charAt(0) + lastName.charAt(0);
    $('#profileImage').text(initials);
});
</script>
<script>
$(document).ready(function() {
    load_data();
    
    function load_data() {
        $(document).on('click', '.delete', function() {
            var request_id = $(this).attr("data-id");
            if (confirm("Are you sure want to remove this data?")) {
                $.ajax({
                    url: "../init/controllers/delete_request.php",
                    method: "POST",
                    data: { request_id: request_id },
                    success: function(response) {
                        $("#message").html(response);
                    },
                    error: function() {
                        console.log("Failed");
                    }
                });
            }
        });
    }
});
</script>

<script>
$(document).ready(function() {
    function load_unseen_notification(view = '') {
        $.ajax({
            url: "../init/controllers/fetch.php",
            method: "POST",
            data: { view: view },
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

    $(document).on('click', '.dropdown-toggle', function() {
        $('.count').html('');
        load_unseen_notification('yes');
    });

    setInterval(function() {
        load_unseen_notification();
    }, 5000);
});
</script>
</body>

</html>

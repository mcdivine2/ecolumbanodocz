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

        <style>
        /* General Modal Styles */
.modal-dialog {
    max-width: 800px;
    margin: 1.75rem auto;
}

.modal-content {
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    background-color: #f9f9f9; /* Light background */
}

.modal-header {
    background-color: #1269AF; /* Matching the button's color */
    color: white;
    border-bottom: none;
    padding: 15px 20px;
    border-radius: 10px 10px 0 0;
}

.modal-header .close {
    color: white;
    opacity: 0.8;
    font-size: 1.0rem;
}

.modal-header .close:hover {
    opacity: 1;
}

.modal-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: white;
}

.modal-body {
    padding: 20px;
    background-color: #fff; /* White background inside */
}

#document-status-content {
    font-size: 1rem;
    line-height: 1.6;
    color: #333;
}

/* Button Styles */
.btn-custom {
    background-color: #1269AF;
    color: white;
    border-radius: 5px;
    padding: 10px 15px;
    transition: background-color 0.3s ease;
}

.btn-custom:hover {
    background-color: #0b4f87;
}

/* Badge Styling */
.badge-custom {
    font-size: 0.9rem;
    padding: 5px 10px;
    border-radius: 12px;
}

.bg-warning {
    background-color: #ffc107;
    color: #fff;
}

.bg-info {
    background-color: #17a2b8;
    color: #fff;
}

.bg-success {
    background-color: #28a745;
    color: #fff;
}

.bg-danger {
    background-color: #dc3545;
    color: #fff;
}

/* Mobile Responsiveness */
@media (max-width: 576px) {
    .modal-dialog {
        max-width: 100%;
        margin: 10px;
    }

    .modal-content {
        padding: 10px;
    }

    .modal-body {
        padding: 10px;
    }
}

    </style>

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
                                        <th scope="col">Student Name</th>
                                        <th scope="col">Document Name</th>
                                        <th scope="col">Mode Request</th>
                                        <th scope="col">Date Releasing</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Cleanrance status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $conn = new class_model();
                                        $docrequest = $conn->fetchAll_documentrequest();
                                    ?>
                                    <?php foreach ($docrequest as $row) { ?>
                                        <tr>
                                            <td><?= date("M d, Y", strtotime($row['date_request'])); ?></td>
                                            <td><?= $row['control_no']; ?></td>
                                            <td><?= $row['student_id']; ?></td>
                                            <td><?= $row['first_name']; ?> <?= $row['last_name']; ?></td>
                                            <td><?= $row['document_name']; ?></td>
                                            <td><?= $row['mode_request']; ?></td>
                                            <td>
                                                <?php 
                                                    if ($row['date_releasing'] === "") {
                                                        echo "";
                                                    } else if ($row['date_releasing'] === $row['date_releasing']) {
                                                        echo date("M d, Y", strtotime($row['date_releasing']));
                                                    }
                                                ?>
                                            </td>
                                            
                                            <td>
                                                <?php 
                                                  if ($row['registrar_status'] === "Verified") {
                                                      echo '<span class="badge bg-primary text-white">Verified</span>'; // Blue for pending
                                                  } else if ($row['registrar_status'] === "Received") {
                                                      echo '<span class="badge bg-info text-white">Received</span>'; // Light blue for received
                                                  } else if ($row['registrar_status'] === "Waiting for Payment") {
                                                      echo '<span class="badge bg-warning text-dark">Waiting for Payment</span>'; // Yellow for waiting, dark text for contrast
                                                  } else if ($row['registrar_status'] === "Released") {
                                                      echo '<span class="badge bg-success text-white">Released</span>'; // Green for verified
                                                  } else if ($row['registrar_status'] === "Declined") {
                                                      echo '<span class="badge bg-danger text-white">Declined</span>'; // Red for declined
                                                  }
                                                ?> 
                                            </td>
                                            <td>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <!-- Modal Trigger Button -->
                                                <button class="btn btn-sm btn-primary text-xs view-document" 
                                                    data-request-id="<?= $row['request_id']; ?>" 
                                                    data-student-id="<?= $row['student_id']; ?>" 
                                                    data-toggle="modal" data-target="#documentStatusModal">
                                                    View
                                                </button>
                                            </div>
                                            </td>
                                            <td class="align-right">
                                                <?php if ($row['registrar_status'] !== "Released") { ?>
                                                    <!-- Show the edit option only if the status is not Released -->
                                                    <a href="edit-request.php?request=<?= $row['request_id']; ?>&student-number=<?= $row['student_id']; ?>" 
                                                    class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit request">
                                                        <i class="fa fa-edit"></i>
                                                    </a> |
                                                <?php } ?>
                                                
                                                <a href="email-form-r.php?request=<?= $row['request_id']; ?>&student-number=<?= $row['student_id']; ?>" 
                                                class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Send email">
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
        </div>

<!-- Modal Structure -->
<div class="modal fade" id="documentStatusModal" tabindex="-1" role="dialog" aria-labelledby="documentStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="documentStatusModalLabel">Document Status Overview</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="document-status-content">
          <!-- Content will be dynamically loaded via JavaScript -->
        </div>
      </div>
      <div class="modal-footer">
        <p id="selected-department" class="text-muted"></p> <!-- This will show the selected department -->
      </div>
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


    // View document status
    $('.view-document').on('click', function(){
            var requestId = $(this).data('request-id');
            var studentId = $(this).data('student-id');

            // AJAX request to load document status
            $.ajax({
                url: '../init/controllers/fetch_document_status.php',
                type: 'GET',
                data: { 
                    request: requestId, 
                    student_number: studentId 
                },
                success: function(response){
                    // Load response content into the modal
                    $('#document-status-content').html(response);
                },
                error: function(){
                    $('#document-status-content').html('<p class="text-danger">Unable to fetch document status.</p>');
                }
            });
        });

        // Track the currently open department
        let currentOpenDepartment = null;

        // Display department at the bottom of the modal and hide the previous department section
        $(document).on('click', '.btn-custom', function () {
            var departmentName = $(this).text(); // Get the department name from the button text
            var departmentSection = $(this).data('target'); // Get the target collapse section ID

            // Update the footer with the department name
            $('#selected-department').text('Currently Viewing: ' + departmentName);

            // Collapse or hide the previously open department
            if (currentOpenDepartment && currentOpenDepartment !== departmentSection) {
                $(currentOpenDepartment).collapse('hide'); // Collapse previous department section
            }

            // Update the current department to the new one
            currentOpenDepartment = departmentSection;
        });

});
</script>
</body>

</html>

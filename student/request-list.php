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
                             <h2 class="pageheader-title"><i class="fa fa-fw fa-file"></i> Document Request </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href_no="#" class="breadcrumb-link">Dashboard</a></li>
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
    font-size: 1.2rem;
}

.modal-header .close:hover {
    opacity: 1;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: bold;
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
                    <a href="add-request.php" class="btn btn-sm" style="background-color:#1269AF !important; color:white">
                        <i class="fa fa-fw fa-plus"></i> Add Request
                    </a><br><br>
                    <table class="table table-striped table-bordered first">
                        <thead>
                            <tr>
                                <th scope="col">Control No.</th>
                                <th scope="col">Student ID</th>
                                <th scope="col">Student Name</th>
                                <th scope="col">Document Name</th>
                                <th scope="col">Date Request</th>
                                <th scope="col">Date Releasing</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $student_id = $_SESSION['student_id'];
                                $conn = new class_model();
                                $docrequest = $conn->fetchAll_documentrequest($student_id);
                            ?>
                            <?php foreach ($docrequest as $row) { ?>
                                <tr>
                                    <td><?= $row['control_no']; ?></td>
                                    <td><?= $row['student_id']; ?></td>
                                    <td><?= $row['first_name'] .' '. $row['last_name']; ?></td>
                                    <td><?= $row['document_name']; ?></td>
                                    <td><?= date("M d, Y", strtotime($row['date_request'])); ?></td>
                                    <td>
                                        <?php 
                                            if ($row['date_releasing'] === "") {
                                                echo "";
                                            } else {
                                                echo date("M d, Y", strtotime($row['date_releasing']));
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if ($row['registrar_status'] === "Released") {
                                                echo '<span class="badge bg-success text-white">Released</span>';
                                            } elseif ($row['registrar_status'] === "Waiting for Payment") {
                                                echo '<span class="badge bg-info text-white">Waiting for Payment</span>';
                                            } elseif ($row['registrar_status'] === "Releasing") {
                                                echo '<span class="badge bg-success text-white">Processing</span>';
                                            } elseif ($row['registrar_status'] === "Received") {
                                                echo '<span class="badge bg-warning text-white">Pending Request</span>';
                                            } elseif ($row['registrar_status'] === "Declined") {
                                                echo '<span class="badge bg-danger text-white">Declined</span>';
                                            }
                                        ?>
                                    </td>
                                    <td class="align-right">
                                       
                                        <div class="three">
                                            <!-- Modal Trigger Button -->
                                            <button class="btn btn-sm btn-primary text-xs view-document" 
                                                data-request-id="<?= $row['request_id']; ?>" 
                                                data-student-id="<?= $row['student_id']; ?>" 
                                                data-toggle="modal" data-target="#documentStatusModal">
                                                View
                                            </button>
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



<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel">Confirm Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to proceed with the payment for this request?</p>
        <form action="process_payment.php" method="POST" id="paymentForm" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" name="student_id" value="<?= $_SESSION['student_id']; ?>">
            <input type="hidden" class="form-control" id="student" name="date_ofpayment" readonly>
          </div>

          <div class="form-group">
            <label for="trace_nonumber">Trace. NO.</label>
            <input type="text" class="form-control" id="trace_no" name="trace_no" placeholder="Enter Trace number">
          </div>

          <div class="form-group">
            <label for="refference">Ref. No.</label>
            <input type="text" class="form-control" id="ref_no" name="ref_no" placeholder="Enter Reference number">
          </div>

          <div class="form-group">
            <label for="control number">Control No.</label>
            <input type="text" class="form-control" id="control_no" name="control_no" readonly>
          </div>
          
          <div class="form-group">
            <label for="documents">Documents</label>
            <input type="text" class="form-control" id="document_name" name="document_name" readonly>
          </div>

          <div class="form-group">
            <input type="hidden" class="form-control" id="date_ofpayment" name="date_ofpayment" readonly>
          </div>

          <div class="form-group">
            <label for="total_amount">Amount to Pay</label>
            <input type="text" class="form-control" id="total_amount" name="total_amount" readonly>
          </div>
          <!-- Image Upload Field -->
          <div class="form-group">
            <label for="paymentProof">Upload Proof of Payment</label>
            <input type="file" class="form-control" id="proof_ofpayment" name="proof_ofpayment" accept=".jpeg, .jpg, .png, .gif" required>
          </div>
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

        <button type="submit" class="btn btn-primary" form="paymentForm">Confirm Payment</button>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript -->
<script src="../asset/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../asset/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../asset/vendor/custom-js/jquery.multi-select.html"></script>
    <script src="../asset/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../asset/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../asset/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="../asset/vendor/datatables/js/data-table.js"></script>
<script src="../asset/libs/js/main-js.js"></script>

<script>
    $(document).ready(function () {
        // Generate initials for profile image
        const firstName = $('#firstName').text();
        const lastName = $('#lastName').text();
        const initials = firstName.charAt(0) + lastName.charAt(0);
        $('#profileImage').text(initials);

        // Delete request
        $('.delete').on('click', function () {
            const request_id = $(this).data('id');
            if (confirm("Are you sure you want to remove this data?")) {
                $.post("../init/controllers/delete_request.php", { request_id }, function (response) {
                    $("#message").html(response);
                }).fail(function () {
                    console.error("Failed to delete request.");
                });
            }
        });

        // Load unseen notifications
        function loadUnseenNotifications(view = '') {
            $.post("../init/controllers/fetch.php", { view }, function (data) {
                $('.dropdown-menu_1').html(data.notification);
                if (data.unseen_notification > 0) {
                    $('.count').html(data.unseen_notification);
                }
            }, 'json');
        }

        loadUnseenNotifications();
        $('.dropdown-toggle').on('click', function () {
            $('.count').html('');
            loadUnseenNotifications('yes');
        });

        setInterval(loadUnseenNotifications, 4000);

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

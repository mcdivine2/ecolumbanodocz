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
                                        <th scope="col">Total total_amount</th>
                                        <th scope="col">Date Request</th>
                                        <th scope="col">Processing Officer</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Pay</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $student_id = $_SESSION['student_id'];
                                    $conn = new class_model();
                                    $docrequest = $conn->fetchAll_paymentpending($student_id);
                                    ?>
                                    <?php foreach ($docrequest as $row) { ?>
                                        <tr>
                                            <td><?= $row['control_no']; ?></td>
                                            <td><?= $row['student_id']; ?></td>
                                            <td><?= $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                            <td><?= $row['document_name']; ?></td>
                                            <td><?= $row['price']; ?></td>
                                            <td><?= date("M d, Y", strtotime($row['date_request'])); ?></td>
                                            <td><?= $row['processing_officer']; ?></td>
                                            <td>
                                                <?php
                                                if ($row['registrar_status'] === "Pending") {
                                                    echo '<span class="badge bg-warning text-white">Pending</span>';
                                                } elseif ($row['accounting_status'] === "Waiting for Payment") {
                                                    echo '<span class="badge bg-info text-white">Waiting for Payment</span>';
                                                } elseif ($row['registrar_status'] === "Releasing") {
                                                    echo '<span class="badge bg-success text-white">Verified</span>';
                                                } elseif ($row['registrar_status'] === "Received") {
                                                    echo '<span class="badge bg-warning text-white">Pending Request</span>';
                                                } elseif ($row['registrar_status'] === "Declined") {
                                                    echo '<span class="badge bg-danger text-white">Declined</span>';
                                                }
                                                ?>
                                            </td>
                                            <td class="align-right">
                                                <div class="box">
                                                    <div class="three">
                                                        <!-- Converted to a button -->
                                                        <a href="Track-document.php?request=<?= $row['request_id']; ?>&student-number=<?= $row['student_id']; ?>" class="btn btn-sm btn-primary text-xs" data-toggle="tooltip" data-original-title="Clearance">
                                                            Clearance
                                                        </a>
                                                    </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#paymentModal"
                                                    data-control-no="<?= $row['control_no']; ?>"
                                                    data-document-name="<?= $row['document_name']; ?>"
                                                    data-total-amount="<?= $row['price']; ?>">
                                                    <i class="fa fa-credit-card"></i> Pay
                                                </button>

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
        <!-- ============================================================= -->
        <!-- end main wrapper -->
        <!-- ============================================================== -->
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

        <!-- ============================================================== -->
        <!-- Optional JavaScript -->
        <script src="../asset/vendor/jquery/jquery-3.3.1.min.js"></script>
        <script src="../asset/vendor/bootstrap/js/bootstrap.bundle.js"></script>
        <script src="../asset/vendor/custom-js/jquery.multi-select.html"></script>
        <script src="../asset/libs/js/main-js.js"></script>
        <script src="../asset/vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../asset/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
        <script src="../asset/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
        <script src="../asset/vendor/datatables/js/data-table.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var firstName = $('#firstName').text();
                var lastName = $('#lastName').text();
                var intials = $('#firstName').text().charAt(0) + $('#lastName').text().charAt(0);
                var profileImage = $('#profileImage').text(intials);
            });
        </script>


        <script>
            $(document).ready(function() {
                // Event listener for opening the modal 
                $('#paymentModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal

                    // Extract the data-* attributes from the button

                    var controlNo = button.data('control-no');
                    var totalamount = button.data('total-amount');
                    var documentName = button.data('document-name');

                    // Fetch the modal
                    var modal = $(this);

                    // Populate the modal's input fields with the data

                    modal.find('#control_no').val(controlNo);
                    modal.find('#total_amount').val(totalamount);
                    modal.find('#document_name').val(documentName);

                    // Set the current date in the hidden "date_ofpayment" field
                    var today = new Date();
                    var formattedDate = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
                    modal.find('#date_ofpayment').val(formattedDate); // Assuming the 'Name' field holds the date
                });

                // Handle form submission
                // Handle form submission
                $('#paymentForm').on('submit', function(event) {
                    event.preventDefault(); // Prevent default form submission

                    // Create FormData object to hold form data
                    var formData = new FormData(this);

                    $.ajax({
                        url: '../init/controllers/add_payment.php', // URL to your backend script
                        type: 'POST',
                        data: formData,
                        contentType: false, // Important for file upload
                        processData: false, // Important for file upload
                        success: function(response) {
                            $('#message').html(response); // Display the response message
                            $('#paymentModal').modal('hide'); // Hide the modal after submission
                            load_data(); // Reload data if necessary
                        },
                        error: function(xhr, status, error) {
                            console.error("Error: " + error); // Log error for debugging
                            console.error("Response: " + xhr.responseText); // Log response for debugging
                        }
                    });
                });


                // Load data function for handling deletions
                load_data();

                function load_data() {
                    $(document).on('click', '.delete', function() {
                        var request_id = $(this).attr("data-id");
                        if (confirm("Are you sure you want to remove this data?")) {
                            $.ajax({
                                url: "../init/controllers/delete_request.php",
                                method: "POST",
                                data: {
                                    request_id: request_id
                                },
                                success: function(response) {
                                    $("#message").html(response);
                                    load_data(); // Reload data after deletion
                                },
                                error: function(response) {
                                    console.log("Failed");
                                }
                            });
                        }
                    });
                }

                // Load unseen notifications
                function load_unseen_notification(view = '') {
                    $.ajax({
                        url: "../init/controllers/fetch.php",
                        method: "POST",
                        data: {
                            view: view
                        },
                        dataType: "json",
                        success: function(data) {
                            $('.dropdown-menu_1').html(data.notification);
                            if (data.unseen_notification > 0) {
                                $('.count').html(data.unseen_notification);
                            }
                        }
                    });
                }

                // Initial load for unseen notifications
                load_unseen_notification();

                $(document).on('click', '.dropdown-toggle', function() {
                    $('.count').html(''); // Clear notification count
                    load_unseen_notification('yes'); // Load notifications
                });

                // ref_noresh notifications every 5 seconds
                setInterval(function() {
                    load_unseen_notification();
                }, 5000); // 5 seconds interval
            });
        </script>


        </body>

        </html>
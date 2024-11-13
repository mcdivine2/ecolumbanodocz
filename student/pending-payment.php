<?php include('main_header/header.php'); ?>
<?php include('left_sidebar/sidebar.php'); ?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-12">
                <div class="page-header">
                    <h2 class="pageheader-title"><i class="fa fa-fw fa-file"></i> Document Request </h2>
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Request Information</h5>
                    <div class="card-body">
                        <div id="message"></div>
                        <div class="table-responsive">
                            <a href="add-request.php" class="btn btn-sm" style="background-color:#1269AF; color:white">
                                <i class="fa fa-fw fa-plus"></i> Add Request
                            </a>
                            <br><br>
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th>Control No.</th>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Document Name</th>
                                        <th>Total Amount</th>
                                        <th>Date Request</th>
                                        <th>Processing Officer</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Pay</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $student_id = $_SESSION['student_id'];
                                    $conn = new class_model();
                                    $docrequest = $conn->fetchAll_paymentpending($student_id);
                                    foreach ($docrequest as $row) { ?>
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
                                                $status_classes = [
                                                    "Pending" => "bg-warning text-white",
                                                    "Waiting for Payment" => "bg-info text-white",
                                                    "Releasing" => "bg-success text-white",
                                                    "Received" => "bg-warning text-white",
                                                    "Declined" => "bg-danger text-white"
                                                ];
                                                $status_class = $status_classes[$row['accounting_status']] ?? 'bg-secondary text-white';
                                                echo "<span class='badge $status_class'>{$row['accounting_status']}</span>";
                                                ?>
                                            </td>
                                            <td>
                                                <a href="Track-document.php?request=<?= $row['request_id']; ?>&student-number=<?= $row['student_id']; ?>" class="btn btn-sm btn-primary text-xs" data-toggle="tooltip" title="Clearance">Clearance</a>
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

        <!-- Payment Modal -->
        <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Confirm Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to proceed with the payment for this request?</p>
                        <form action="process_payment.php" method="POST" id="paymentForm" enctype="multipart/form-data">
                            <input type="hidden" name="student_id" value="<?= $_SESSION['student_id']; ?>">
                            <div class="form-group">
                                <label for="trace_no" >Trace No.</label>
                                <input type="text" class="form-control" id="trace_no" name="trace_no" placeholder="Enter Trace number" required>
                            </div>
                            <div class="form-group">
                                <label for="ref_no">Ref. No.</label>
                                <input type="text" class="form-control" id="ref_no" name="ref_no" placeholder="Enter Reference number" required>
                            </div>
                            <div class="form-group">
                                <label for="control_no">Control No.</label>
                                <input type="text" class="form-control" id="control_no" name="control_no" readonly>
                            </div>
                            <div class="form-group">
                                <label for="document_name">Documents</label>
                                <input type="text" class="form-control" id="document_name" name="document_name" readonly>
                            </div>
                            <div class="form-group">
                                <label for="total_amount">Amount to Pay</label>
                                <input type="text" class="form-control" id="total_amount" name="total_amount" readonly>
                            </div>
                            <div class="form-group">
                                <label for="proof_ofpayment">Upload Proof of Payment</label>
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
    </div>
</div>

<!-- Scripts -->
<script src="../asset/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../asset/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../asset/libs/js/main-js.js"></script>
<script src="../asset/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../asset/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        // Set initials in profile image
        const initials = $('#firstName').text().charAt(0) + $('#lastName').text().charAt(0);
        $('#profileImage').text(initials);

        // Payment Modal Event
        $('#paymentModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const modal = $(this);
            modal.find('#control_no').val(button.data('control-no'));
            modal.find('#total_amount').val(button.data('total-amount'));
            modal.find('#document_name').val(button.data('document-name'));

            const today = new Date();
            modal.find('#date_ofpayment').val(today.toISOString().slice(0, 10));
        });

        // Payment Form Submission
        $('#paymentForm').on('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: '../init/controllers/add_payment.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#message').html(response);
                    $('#paymentModal').modal('hide');
                },
                error: function(xhr) {
                    console.error("Error: " + xhr.responseText);
                }
            });
        });

        // Load Unseen Notifications
        function load_unseen_notification(view = '') {
            $.post("../init/controllers/fetch.php", {
                view
            }, function(data) {
                $('.dropdown-menu_1').html(data.notification);
                if (data.unseen_notification > 0) $('.count').html(data.unseen_notification);
            }, 'json');
        }

        load_unseen_notification();
        $('.dropdown-toggle').on('click', function() {
            $('.count').html('');
            load_unseen_notification('yes');
        });

        setInterval(load_unseen_notification, 5000);
    });
</script>

</body>

</html>
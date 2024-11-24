<?php include('main_header/header.php'); ?>
<?php include('left_sidebar/sidebar.php'); ?>

<style>
    .highlight-label {
        color: black; 
    }
    .guide-img {
        max-width: 90%; /* Ensures it doesn't exceed modal width */
        height: auto; /* Maintains aspect ratio */
    }

    .modal-lg {
        max-width: 75%; /* Makes the modal larger */
    }
</style>

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
                    <h5 class="card-header">Payment Details</h5>
                    <div class="card-body">
                        <div id="message"></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th>Control No.</th>
                                        <th>Student EDP</th>
                                        <th>Student Name</th>
                                        <th>Document Name</th>
                                        <th>Total Amount</th>
                                        <th>Date Request</th>
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
                                            <td><?= $row['studentID_no']; ?></td>
                                            <td><?= $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                            <td><?= $row['document_name']; ?></td>
                                            <td><?= $row['price']; ?></td>
                                            <td><?= date("M d, Y", strtotime($row['date_request'])); ?></td>
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


        <!-- Redesigned Payment Modal with Highlighted Labels -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="paymentModalLabel">Payment Confirmation</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center font-weight-bold">Please review your details before proceeding.</p>
                <form action="process_payment.php" method="POST" id="paymentForm" enctype="multipart/form-data">
                    <input type="hidden" name="student_id" value="<?= $_SESSION['student_id']; ?>">

                    <!-- Payment Option with Guide Button -->
                    <div class="form-row align-items-center">
                        <div class="form-group col-md-8">
                            <label for="payment_option" class="highlight-label">Payment Option</label>
                            <select class="form-control" id="payment_option" name="payment_option" onchange="togglePaymentFields()" required>
                                <option value="" disabled selected>Select Payment Option</option>
                                <option value="palawan">Palawan Pay</option>
                                <option value="cash">Cash</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 text-center">
                            <label class="d-block">&nbsp;</label>
                            <button type="button" class="btn btn-info btn-block" onclick="showGuide()">
                                <i class="fas fa-info-circle"></i> Payment Guide
                            </button>
                        </div>
                    </div>

                    <!-- Palawan Pay Fields -->
                    <div id="palawanFields" style="display: none;">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="trace_no" class="highlight-label">Trace No.</label>
                                <input type="text" class="form-control" id="trace_no" name="trace_no" placeholder="Enter trace number">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ref_no" class="highlight-label">Ref. No.</label>
                                <input type="text" class="form-control" id="ref_no" name="ref_no" placeholder="Enter reference number">
                            </div>
                        </div>
                    </div>

                    <!-- Cash Fields -->
                    <div id="cashFields" style="display: none;">
                        <div class="form-group">
                            <label for="cash_notes" class="highlight-label">Receipt Number</label>
                            <textarea class="form-control" id="cash_notes" name="cash_notes" placeholder="Enter cash payment details (e.g., receipt number)" rows="1"></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="control_no" class="highlight-label">Control No.</label>
                            <input type="text" class="form-control" id="control_no" name="control_no" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="total_amount" class="highlight-label">Amount to Pay (₱)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₱</span>
                                </div>
                                <input type="text" class="form-control" id="total_amount" name="total_amount" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="document_name" class="highlight-label">Documents</label>
                        <input type="text" class="form-control" id="document_name" name="document_name" readonly>
                    </div>

                    <div class="form-group">
                        <label for="proof_ofpayment" class="highlight-label">Upload Proof of Payment</label>
                        <input type="file" class="form-control-file" id="proof_ofpayment" name="proof_ofpayment" accept=".jpeg, .jpg, .png, .gif" required>
                        <small class="form-text text-muted">Accepted formats: .jpeg, .jpg, .png, .gif</small>
                    </div>

                    <input type="hidden" id="date_ofpayment" name="date_ofpayment">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" form="paymentForm">
                    <i class="fas fa-check-circle"></i> Confirm Payment
                </button>
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

<script>
    function togglePaymentFields() {
        const paymentOption = document.getElementById("payment_option").value;
        const palawanFields = document.getElementById("palawanFields");
        const cashFields = document.getElementById("cashFields");

        if (paymentOption === "palawan") {
            palawanFields.style.display = "block";
            cashFields.style.display = "none";
        } else if (paymentOption === "cash") {
            palawanFields.style.display = "none";
            cashFields.style.display = "block";
        } else {
            palawanFields.style.display = "none";
            cashFields.style.display = "none";
        }
    }

    function showGuide() {
        const paymentOption = document.getElementById("payment_option").value;

        if (paymentOption === "palawan") {
            // Display Palawan Pay guide image
            const guideModal = new bootstrap.Modal(document.getElementById('guideModal'));
            document.getElementById('guideImage').src = "../asset/images/palawanPay.png";
            guideModal.show();
        } else if (paymentOption === "cash") {
            alert("Guide for Cash Payment: \n1. Visit the cashier.\n2. Provide your control number.\n3. Pay the amount and Attach the receipt here.");
        } else {
            alert("Please select a payment option to view the guide.");
        }
    }
</script>

<!-- Guide Modal -->
<div class="modal fade" id="guideModal" tabindex="-1" aria-labelledby="guideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Set modal to large size -->
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="guideModalLabel">Payment Guide</h5>
                <button type="button" class="btn-close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body text-center">
                <img id="guideImage" src="" alt="Payment Guide" class="img-fluid guide-img"> <!-- Added custom class for larger images -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</body>

</html>
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
                    <h5 class="card-header">Payment Details</h5>
                    <div class="card-body">
                        <div id="message"></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th>Control No.</th>
                                        <th>Student ID</th>
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
                                            <td><?= $row['student_id']; ?></td>
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

        <!-- Payment Modal -->
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
                            <label for="modeof_payment" class="highlight-label">Payment Option</label>
                            <select class="form-control" id="modeof_payment" name="modeof_payment" onchange="togglePaymentFields()" required>
                                <option value="" disabled selected>Select Payment Option</option>
                                <option value="PalawanPay">Palawan Pay</option>
                                <option value="Onsite Pay">Cash</option>
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
                            <label for="or_no" class="highlight-label">Receipt Number</label>
                            <input class="form-control" id="or_no" name="or_no" placeholder="Enter cash payment details (e.g., receipt number)" rows="1"></input>
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

        <!-- Guide Modal -->
        <div class="modal fade" id="guideModal" tabindex="-1" role="dialog" aria-labelledby="guideModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="guideModalLabel">Payment Guide</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <!-- Palawan Pay Section -->
                        <div class="text-center mb-4">
                            <h6 class="font-weight-bold">Palawan Pay</h6>
                            <img src="../asset/images/PalwanPay.png" alt="Palawan Pay Guide" style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 5px; padding: 5px;">
                        </div>

                        <!-- Onsite Pay Section -->
                        <div class="text-center">
                            <h6 class="font-weight-bold">Onsite Pay</h6>
                            <p class="text-left">
                            <ol>
                                <li>Step 1: Pay at the cashier.</li>
                                <li>Step 2: Input the OR # from the receipt into the system.</li>
                                <li>Step 3: Attach an image of the receipt and hit "Confirm Payment."</li>
                            </ol>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Success Modal -->
<div class="modal fade" id="paymentSuccessModal" tabindex="-1" role="dialog" aria-labelledby="paymentSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="paymentSuccessModalLabel">
                    <i class="fas fa-check-circle"></i> Payment Successful
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h4 class="text-success font-weight-bold">Payment successful</h4>
                <div class="mt-4">
                    <p><strong>Payment Type:</strong> <span id="confirm_payment_type"></span></p>
                    <p><strong>Control Number:</strong> <span id="confirm_control_no"></span></p>
                    <p><strong>Amount Paid:</strong> ₱<span id="confirm_amount_paid"></span></p>
                    <p><strong>Transaction Reference:</strong> <span id="confirm_transaction_ref"></span></p>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" id="downloadReceipt">
                    <i class="fas fa-download"></i> Download Receipt
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times-circle"></i> Close
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
    $(document).ready(function () {
    // Set initials in profile image
    const initials = $('#firstName').text().charAt(0) + $('#lastName').text().charAt(0);
    $('#profileImage').text(initials);

    // Payment Modal Event
    $('#paymentModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const modal = $(this);
        modal.find('#control_no').val(button.data('control-no'));
        modal.find('#total_amount').val(button.data('total-amount'));
        modal.find('#document_name').val(button.data('document-name'));

        const today = new Date();
        modal.find('#date_ofpayment').val(today.toISOString().slice(0, 10));
    });

    // Validate Payment Form
    $('#paymentForm').on('submit', function (event) {
        const modeOfPayment = document.getElementById('modeof_payment').value;
        if (modeOfPayment === 'PalawanPay' && (!$('#trace_no').val() || !$('#ref_no').val())) {
            event.preventDefault();
            alert('Please fill in both Trace No. and Ref. No. for PalawanPay.');
        } else if (modeOfPayment === 'Onsite Pay' && !$('#or_no').val()) {
            event.preventDefault();
            alert('Please fill in the OR # for Onsite Pay.');
        } else {
            // Submit form via AJAX to prevent default refresh and handle response
            event.preventDefault();
            const formData = new FormData(this);
            
            $.ajax({
                url: '../init/controllers/add_payment.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('Payment processed successfully:', response);
                    $('#paymentModal').modal('hide');

                    // Trigger the payment success modal
                    const paymentData = {
                        modeof_payment: $('#modeof_payment').val(),
                        control_no: $('#control_no').val(),
                        total_amount: $('#total_amount').val(),
                        transaction_ref: $('#trace_no').val() || $('#ref_no').val() || $('#or_no').val() // Use appropriate transaction ID
                    };
                    
                    // Show the payment success modal with data
                    showPaymentSuccessModal(paymentData);
                },
                error: function (xhr) {
                    console.error('Payment processing error:', xhr.responseText);
                    alert('An error occurred while processing the payment. Please try again.');
                }
            });
        }
    });

    // Function to show the payment success modal with data
    function showPaymentSuccessModal(paymentData) {
        // Populate the modal with payment details
        $('#confirm_payment_type').text(paymentData.modeof_payment);
        $('#confirm_control_no').text(paymentData.control_no);
        $('#confirm_amount_paid').text(paymentData.total_amount);
        $('#confirm_transaction_ref').text(paymentData.transaction_ref);

        // Show the modal
        $('#paymentSuccessModal').modal('show');

        // Handle download receipt button click
        $('#downloadReceipt').off('click').on('click', function () {
            const receiptContent = `
                Payment Receipt\n
                --------------------------\n
                Payment Type: ${paymentData.modeof_payment}\n
                Control Number: ${paymentData.control_no}\n
                Amount Paid: ₱${paymentData.total_amount}\n
                Transaction Reference: ${paymentData.transaction_ref}\n
                --------------------------\n
                Thank you for your payment!
            `;
            const blob = new Blob([receiptContent], { type: 'text/plain' });
            const downloadLink = document.createElement('a');
            downloadLink.href = URL.createObjectURL(blob);
            downloadLink.download = 'payment_receipt.txt';
            downloadLink.click();
        });

        // Refresh page when closing the success modal
        $('#paymentSuccessModal').off('hidden.bs.modal').on('hidden.bs.modal', function () {
            location.reload(); // Reload the page to reflect changes
        });
    }

    // Load Unseen Notifications
    function load_unseen_notification(view = '') {
        $.post("../init/controllers/fetch.php", {
            view
        }, function (data) {
            $('.dropdown-menu_1').html(data.notification);
            if (data.unseen_notification > 0) $('.count').html(data.unseen_notification);
        }, 'json');
    }

    load_unseen_notification();
    $('.dropdown-toggle').on('click', function () {
        $('.count').html('');
        load_unseen_notification('yes');
    });

    setInterval(load_unseen_notification, 5000);
});

    function togglePaymentFields() {
        const paymentOption = document.getElementById("modeof_payment").value;
        const palawanFields = document.getElementById("palawanFields");
        const cashFields = document.getElementById("cashFields");

        if (paymentOption === "PalawanPay") {
            palawanFields.style.display = "block";
            cashFields.style.display = "none";
        } else if (paymentOption === "Onsite Pay") {
            palawanFields.style.display = "none";
            cashFields.style.display = "block";
        } else {
            palawanFields.style.display = "none";
            cashFields.style.display = "none";
        }
    }

    function showGuide() {
        const paymentOption = document.getElementById("modeof_payment").value;

        if (paymentOption === "PalawanPay") {
            // Display Palawan Pay guide image
            const guideModal = new bootstrap.Modal(document.getElementById('guideModal'));
            document.getElementById('guideImage').src = "../asset/images/palawanPay.png";
            guideModal.show();
        } else if (paymentOption === "Onsite Pay") {
            alert("Guide for Cash Payment: \n1. Visit the cashier.\n2. Provide your control number.\n3. Pay the amount and attach the receipt here.");
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
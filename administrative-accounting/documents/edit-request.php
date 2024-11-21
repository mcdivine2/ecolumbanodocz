<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('main_header/header.php');
include('left_sidebar/sidebar.php');
?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-12">
                <div class="page-header">
                    <h2 class="pageheader-title"><i class="fa fa-fw fa-file"></i> Edit Request</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Request</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <?php
        include '../init/model/config/connection2.php';

        // Check if request and student-number are passed
        if (!isset($_GET['request']) || !isset($_GET['student-number'])) {
            echo "<div class='alert alert-danger'>Missing request or student number parameter.</div>";
            exit;
        }

        $control_no = $_GET['request'];
        $student_number = $_GET['student-number'];

        // Updated query to match control_no and student_id
        $sql = "SELECT * FROM `tbl_documentrequest` WHERE `control_no` = ? AND `student_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $control_no, $student_number); // Using "ss" as both are strings
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            echo "<div class='alert alert-warning'>No records found for the provided request ID and student number.</div>";
        } else {
            while ($row = $result->fetch_assoc()) {
        ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card influencer-profile-data">
                            <div class="card-body">
                                <div id="message"></div>
                                <form id="validationform" name="docu_forms" data-parsley-validate novalidate method="POST">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-sm-right"><i class="fa fa-file"></i> Request Info</label>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-sm-right">Control No.</label>
                                        <div class="col-sm-8 col-lg-6">
                                            <input type="text" value="<?= $row['control_no']; ?>" name="control_no" required class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-sm-right">Student ID</label>
                                        <div class="col-sm-8 col-lg-6">
                                            <input type="text" value="<?= $row['student_id']; ?>" name="student_id" required class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-sm-right">Name</label>
                                        <div class="col-sm-8 col-lg-6">
                                            <input type="text" value="<?= $row['first_name']; ?> <?= $row['last_name']; ?>" name="name" required class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-sm-right">Document Name</label>
                                        <div class="col-sm-8 col-lg-6">
                                            <input type="text" value="<?= $row['document_name']; ?>" name="document_name" required class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-sm-right">Date Request</label>
                                        <div class="col-sm-8 col-lg-6">
                                            <input type="date"
                                                value="<?= isset($row['date_request']) ? date('Y-m-d', strtotime($row['date_request'])) : date('Y-m-d'); ?>"
                                                name="date_request"
                                                required
                                                class="form-control"
                                                readonly>
                                        </div>
                                    </div>

                                    <?php
                                    $user_id = $_SESSION['user_id'];
                                    $conn = new class_model();
                                    $user = $conn->user_account($user_id);
                                    ?>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-sm-right">Processing Officer</label>
                                        <div class="col-sm-8 col-lg-6">
                                            <input type="text" value="<?= ucfirst($user['complete_name']); ?>" name="processing_officer" required class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-sm-right">Status</label>
                                        <div class="col-sm-8 col-lg-6">
                                            <select id="accounting_status" required class="form-control">
                                                <option value="<?= $row['accounting_status']; ?>" hidden><?= $row['accounting_status']; ?></option>
                                                <option value="Waiting for Payment">Waiting for Payment</option>
                                                <option value="Declined">Declined</option>
                                                <option value="Verified">Verified</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Email Form Section (hidden by default) -->
                                    <div id="emailForm" style="display: none;">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label text-sm-right">Send to:</label>
                                            <div class="col-sm-8 col-lg-6">
                                                <input type="text" value="<?= $row['email_address']; ?>" name="email_address" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label text-sm-right">Subject:</label>
                                            <div class="col-sm-8 col-lg-6">
                                                <input type="text" value="Request Update for <?= $row['document_name']; ?>" name="subject" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label text-sm-right">Message:</label>
                                            <div class="col-sm-8 col-lg-6">
                                                <textarea name="body" id="emailBody" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group row text-right">
                                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                            <input type="hidden" name="request_id" value="<?= $row['request_id']; ?>">
                                            <button type="button" class="btn btn-space btn-primary" id="edit-request">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

        <?php
            } // End of while loop
        } // End of else statement if records exist
        ?>
    </div>
</div>

<!-- Optional JavaScript -->
<script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../assets/vendor/parsley/parsley.js"></script>
<script src="../assets/libs/js/main-js.js"></script>
<script>
    $(document).ready(function() {
        $('#accounting_status').on('change', function() {
            $('#emailForm').toggle($(this).val() === 'Declined');
        });

        $('#edit-request').on('click', function() {
            const data = new FormData();
            data.append('control_no', $('input[name=control_no]').val());
            data.append('student_id', $('input[name=student_id]').val());
            data.append('document_name', $('input[name=document_name]').val());
            data.append('date_request', $('input[name=date_request]').val() || '<?= date('Y-m-d'); ?>');
            data.append('processing_officer', $('input[name=processing_officer]').val());
            data.append('accounting_status', $('#accounting_status').val());
            data.append('request_id', $('input[name=request_id]').val());

            if ($('#accounting_status').val() === 'Declined') {
                data.append('email_address', $('input[name=email_address]').val());
                data.append('subject', $('input[name=subject]').val());
                data.append('body', $('#emailBody').val());
            }

            $.ajax({
                url: $('#accounting_status').val() === 'Declined' ?
                    '../init/controllers/edit_request_with_email.php' : '../init/controllers/edit_request.php',
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Response received:', response);
                    // Show a visible success alert
                    $("#message").html(`
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ${response}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
                    window.scrollTo(0, 0);

                    // Redirect to the previous index page after a short delay
                    setTimeout(() => {
                        window.location.href = "index.php"; // Adjust the path to your index page if necessary
                    }, 2000); // Delay of 2 seconds to allow the user to see the success message
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    // Show a visible error alert
                    $("#message").html(`
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                An error occurred: ${error}. Please try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
                    window.scrollTo(0, 0);
                }
            });

        });

    });
</script>

</body>

</html>
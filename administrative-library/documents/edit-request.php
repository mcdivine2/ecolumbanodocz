<?php include('main_header/header.php'); ?>
<?php include('left_sidebar/sidebar.php'); ?>

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
        $GET_reqid = intval($_GET['request']);
        $student_number = $_GET['student-number'];
        $sql = "SELECT * FROM `tbl_documentrequest` WHERE `request_id`= ? AND student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $GET_reqid, $student_number);
        $stmt->execute();
        $result = $stmt->get_result();
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
                                        <input type="date" value="<?= strftime('%Y-%m-%d', strtotime($row['date_request'])); ?>" name="date_request" required class="form-control" readonly>
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
                                        <select id="library_status" required class="form-control">
                                            <option value="<?= $row['library_status']; ?>" hidden><?= $row['library_status']; ?></option>
                                            <option value="Pending" style="background-color: orange;color: #fff">Pending</option>
                                            <option value="Declined" style="background-color: red;color: #fff">Declined</option>
                                            <option value="Verified" style="background-color: green;color: #fff">Verified</option>
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

        <?php } ?>
    </div>
</div>

<!-- Optional JavaScript -->
<script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../assets/vendor/parsley/parsley.js"></script>
<script src="../assets/libs/js/main-js.js"></script>
<script>
    $(document).ready(function() {
        var firstName = $('#firstName').text();
        var lastName = $('#lastName').text();
        var initials = firstName.charAt(0) + lastName.charAt(0);
        $('#profileImage').text(initials);

        // Toggle email form visibility based on status selection
        $('#library_status').on('change', function() {
            if ($(this).val() === 'Declined') {
                $('#emailForm').show();
            } else {
                $('#emailForm').hide();
            }
        });

        $('#edit-request').on('click', function() {
            const data = new FormData();
            data.append('control_no', $('input[name=control_no]').val());
            data.append('student_id', $('input[name=student_id]').val());
            data.append('document_name', $('input[name=document_name]').val());
            data.append('date_request', $('input[name=date_request]').val());
            data.append('processing_officer', $('input[name=processing_officer]').val());
            data.append('library_status', $('#library_status').val());
            data.append('request_id', $('input[name=request_id]').val());

            const libraryStatus = $('#library_status').val();

            if (libraryStatus === 'Declined') {
                // If "Declined" is selected, include email data for sending
                data.append('email_address', $('input[name=email_address]').val());
                data.append('subject', $('input[name=subject]').val());
                data.append('body', $('#emailBody').val());
            }

            if ([...data.values()].some(value => value === '')) {
                $('#message').html('<div class="alert alert-danger">Required All Fields!</div>');
            } else {
                $.ajax({
                    url: libraryStatus === 'Declined' ? '../init/controllers/edit_request_with_email.php' : '../init/controllers/edit_request.php',
                    type: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#message").html(response);
                        window.scrollTo(0, 0);
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
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
                    <h2 class="pageheader-title"><i class="fa fa-fw fa-file"></i> Edit Request </h2>
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
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
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
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card influencer-profile-data">
                        <div class="card-body">
                            <div id="message"></div>
                            <form id="validationform" name="docu_forms" data-parsley-validate="" novalidate="" method="POST">
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right"><i class="fa fa-file"></i> Request Info</label>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Control No.</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input data-parsley-type="alphanum" type="text" value="<?= $row['control_no']; ?>" name="control_no" required="" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Student ID</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input data-parsley-type="alphanum" value="<?= $row['student_id']; ?>" name="student_id" type="text" required="" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Student Name</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input data-parsley-type="alphanum" value="<?= $row['first_name']; ?> <?= $row['last_name']; ?>" name="student_id" type="text" required="" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Document Name</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input data-parsley-type="alphanum" value="<?= $row['document_name']; ?>" type="text" name="document_name" required="" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Date Request</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input data-parsley-type="alphanum" value="<?= strftime('%Y-%m-%d', strtotime($row['date_request'])); ?>" type="date" name="date_request" required="" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Date Releasing</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input data-parsley-type="alphanum" value="<?= $row['date_releasing']; ?>" type="date" name="date_releasing" required="" class="form-control">
                                    </div>
                                </div>

                                <?php
                                $user_id = $_SESSION['user_id'];
                                $conn = new class_model();
                                $user = $conn->user_account($user_id);
                                ?>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Processing Officer</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input data-parsley-type="alphanum" value="<?= ucfirst($user['complete_name']); ?>" type="text" name="processing_officer" required="" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Status</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <select data-parsley-type="alphanum" type="text" value="<?= $row['status']; ?>" id="status" required="" class="form-control">
                                            <option value="<?= $row['status']; ?>" hidden><?= $row['status']; ?></option>
                                            <option value="Received">Pending Request</option>
                                            <option value="Declined">Declined</option>
                                            <option value="Verified">Verified</option>
                                            <option value="Released">Released</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <!-- Email Form Section -->
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="email-group" style="display: none;">
                                        <div class="card influencer-profile-data">
                                            <div class="card-body">
                                                <form id="validationform" name="docu_forms" data-parsley-validate="" novalidate="" method="POST" action="../init/controllers/email_sender.php">
                                                    <div class="form-group row">
                                                        <label class="col-12 col-sm-3 col-form-label text-sm-right"><i class="fa fa-file"></i> Email Form</label>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Send to:</label>
                                                        <div class="col-12 col-sm-8 col-lg-6">
                                                            <input data-parsley-type="alphanum" type="text" value="<?= $row['email_address']; ?>" name="email" required="" class="form-control" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Subject:</label>
                                                        <div class="col-12 col-sm-8 col-lg-6">
                                                            <input data-parsley-type="alphanum" type="text" value="Request received for <?= $row['document_name']; ?>" name="subject" required="" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Message:</label>
                                                        <div class="col-12 col-sm-8 col-lg-6">
                                                            <textarea data-parsley-type="alphanum" name="body" required="" class="form-control">
                                            Hello, This is a test! Your request for <?= $row['document_name']; ?> has been received with Reference # <?= $row['control_no']; ?>.
                                        </textarea>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Update Button Section (Always Visible) -->

                                    <div class="col-12 text-center">
                                        <input name="request_id" value="<?= $row['request_id']; ?>" type="hidden">
                                        <button type="button" class="btn btn-primary" id="edit-request">Update</button>
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

<!-- ============================================================== -->
<!-- end main wrapper -->
<!-- ============================================================== -->
<!-- Optional JavaScript -->
<script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../assets/vendor/parsley/parsley.js"></script>
<script src="../assets/libs/js/main-js.js"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.querySelector('#edit-request');
        btn.addEventListener('click', () => {
            // Retrieve input values
            const control_no = document.querySelector('input[name=control_no]').value;
            const student_id = document.querySelector('input[name=student_id]').value;
            const document_name = document.querySelector('input[name=document_name]').value;
            const no_ofcopies = document.querySelector('input[name=no_ofcopies]') ? document.querySelector('input[name=no_ofcopies]').value : '';
            const date_request = document.querySelector('input[name=date_request]').value;
            const date_releasing = document.querySelector('input[name=date_releasing]').value;
            const processing_officer = document.querySelector('input[name=processing_officer]').value;
            const status = $('#status option:selected').val();
            const request_id = document.querySelector('input[name=request_id]').value;
            const email = document.querySelector('input[name=email]').value;
            const subject = `Request received for ${document_name}`;
            const body = `Hello, This is a test! Your request for ${document_name} has been received with Reference # ${control_no}.`;

            // Create FormData object
            var data = new FormData();
            data.append('control_no', control_no);
            data.append('student_id', student_id);
            data.append('document_name', document_name);
            data.append('no_ofcopies', no_ofcopies);
            data.append('date_request', date_request);
            data.append('date_releasing', date_releasing);
            data.append('processing_officer', processing_officer);
            data.append('status', status);
            data.append('request_id', request_id);
            data.append('email', email);
            data.append('subject', subject);
            data.append('body', body);

            if (control_no === '' && student_id === '' && document_name === '' && no_ofcopies === '' && date_request === '' && date_releasing === '' && processing_officer === '') {
                $('#message').html('<div class="alert alert-danger"> Required All Fields!</div>');
            } else {
                $.ajax({
                    url: '../init/controllers/edit_request.php',
                    type: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    async: false,
                    cache: false,
                    success: function(response) {
                        $("#message").html(response);
                        window.scrollTo(0, 0);
                    },
                    error: function(response) {
                        console.log("Failed");
                    }
                });
            }

        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const statusSelect = document.querySelector('#status');
        const emailGroup = document.querySelector('#email-group');

        statusSelect.addEventListener('change', () => {
            const selectedValue = statusSelect.value;
            if (["Received", "Declined", "Released"].includes(selectedValue)) {
                emailGroup.style.display = 'block';
            } else {
                emailGroup.style.display = 'none';
            }
        });
    });
</script>

</body>

</html>
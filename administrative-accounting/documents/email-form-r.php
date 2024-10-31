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
                    <h2 class="pageheader-title"><i class="fa fa-fw fa-file"></i> Email Form </h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Send Email</li>
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

        // Remove intval, assuming control_no is a string
        $control_no = $_GET['request'];
        $student_number = $_GET['student-number'];

        $sql = "SELECT * FROM `tbl_documentrequest` WHERE `control_no` = ? AND `student_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $control_no, $student_number); // "ss" indicates both are strings
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the single record
        if ($row = $result->fetch_assoc()) {
        ?>

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card influencer-profile-data">
                        <div class="card-body">
                            <div class="" id="message"></div>
                            <form id="validationform" name="docu_forms" data-parsley-validate="" novalidate="" method="POST" action="../init/controllers/email_sender.php">
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right"><i class="fa fa-file"></i> Email Form</label>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Send to: </label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="email" value="<?= $row['email_address']; ?>" name="email" required="" placeholder="Recipient email" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Subject: </label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="text" value="Request received for <?= $row['document_name']; ?>" name="subject" required="" placeholder="Subject" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Message: </label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <textarea name="body" required="" class="form-control" readonly>
Hello, 
This is to inform you that your request for <?= $row['document_name']; ?> has been received. 
Your Reference Number is <?= $row['control_no']; ?>.

Thank you!
                                        </textarea>
                                    </div>
                                </div>

                                <div class="form-group row text-right">
                                    <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                        <input name="submit" value="SEND" type="submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php } else { ?>
            <div class="alert alert-danger">No record found for this request.</div>
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
    $(document).ready(function() {
        var firstName = $('#firstName').text();
        var lastName = $('#lastName').text();
        var intials = firstName.charAt(0) + lastName.charAt(0);
        var profileImage = $('#profileImage').text(intials);
    });
</script>
</body>

</html>
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
        $student_number = $_GET['student-number']; // Assuming student-number is an integer
        $sql = "SELECT * FROM `tbl_students` WHERE `student_id`= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $student_number); // "i" for integer
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
        ?>

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card influencer-profile-data">
                        <div class="card-body">
                            <div id="message"></div>
                            <!-- Form starts here -->
                            <form id="validationform" name="docu_forms" data-parsley-validate="" novalidate="" method="POST" action="../init/controllers/email_sender2.php">
                                <!-- Form Title -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                        <i class="fa fa-envelope"></i> Email Form
                                    </label>
                                </div>

                                <!-- Recipient Name -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Recipient Name:</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="text" name="name" value="<?= htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']); ?>" required placeholder="Recipient Name" class="form-control">
                                    </div>
                                </div>

                                <!-- Send to Email (readonly) -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Send to:</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="email" name="email_address" value="<?= htmlspecialchars($row['email_address']); ?>" required placeholder="Recipient Email" class="form-control" readonly>
                                    </div>
                                </div>

                                <!-- Subject (readonly) -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Subject:</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="text" name="subject" value="Your Account is now Verified!" required placeholder="Email Subject" class="form-control" readonly>
                                    </div>
                                </div>

                                <!-- Message Body (Pre-filled with template) -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Message:</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <textarea name="body" required class="form-control" rows="5">
Panagdait! 
<?= htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']); ?>,

Your account has now been verified. Please check our site ecolumbanodocz.com

Email: <?= htmlspecialchars($row['email_address']); ?>

Password: <?= htmlspecialchars($row['password']); ?>
                            </textarea>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group row text-right">
                                    <div class="col-12 col-sm-8 col-lg-6 offset-sm-3">
                                        <button name="submit" value="SEND" type="submit" class="btn btn-primary">
                                            SEND
                                        </button>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>
                        <!-- Form ends here -->
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
            <script src="../assets/vendor/parsley/parsley.js"></script>
            <script src="../assets/libs/js/main-js.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    var firstName = $('#firstName').text();
                    var lastName = $('#lastName').text();
                    var intials = $('#firstName').text().charAt(0) + $('#lastName').text().charAt(0);
                    var profileImage = $('#profileImage').text(intials);
                });
            </script>

            <!-- JavaScript for Bootstrap form validation -->


            </body>

            </html>
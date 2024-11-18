<?php include('main_header/header.php'); ?>
<?php include('left_sidebar/sidebar.php'); ?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- Page Header -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="page-header">
                    <h2 class="pageheader-title"><i class="fa fa-fw fa-user-graduate"></i> Edit Student</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Student</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- Fetch Student Data -->
        <!-- ============================================================== -->
        <?php
        include '../init/model/config/connection2.php';

        $studentId = intval($_GET['student']);
        $studentNumber = $_GET['student-number'];

        $sql = "SELECT * FROM `tbl_students` WHERE `student_id` = ? AND `student_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $studentId, $studentNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
        ?>
            <!-- ============================================================== -->
            <!-- Student Edit Form -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-12">
                    <div class="card influencer-profile-data">
                        <div class="card-body">
                            <div id="message"></div>
                            <form id="validationform" name="student_form" method="POST" data-parsley-validate novalidate>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right"><i class="fa fa-user"></i> Student Info</label>
                                </div>

                                <!-- Student Number -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Student Number</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="text" name="student_id" value="<?= htmlspecialchars($row['student_id']); ?>" required class="form-control">
                                    </div>
                                </div>

                                <!-- First Name -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">First Name</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="text" name="first_name" value="<?= htmlspecialchars($row['first_name']); ?>" required class="form-control">
                                    </div>
                                </div>

                                <!-- Middle Name -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Middle Name</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="text" name="middle_name" value="<?= htmlspecialchars($row['middle_name']); ?>" required class="form-control">
                                    </div>
                                </div>

                                <!-- Last Name -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Last Name</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="text" name="last_name" value="<?= htmlspecialchars($row['last_name']); ?>" required class="form-control">
                                    </div>
                                </div>

                                <!-- Complete Address -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Complete Address</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <textarea name="complete_address" required class="form-control"><?= htmlspecialchars($row['complete_address']); ?></textarea>
                                    </div>
                                </div>

                                <!-- Email Address -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Email Address</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="email" name="email_address" value="<?= htmlspecialchars($row['email_address']); ?>" required class="form-control">
                                    </div>
                                </div>

                                <!-- Mobile Number -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Mobile Number</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="text" name="mobile_number" value="<?= htmlspecialchars($row['mobile_number']); ?>" minlength="11" maxlength="11" required class="form-control">
                                    </div>
                                </div>

                                <!-- Username -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Username</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="text" name="username" value="<?= htmlspecialchars($row['username']); ?>" required class="form-control">
                                    </div>
                                </div>

                                <!-- //translate the hashcode -->

                                <!-- Password -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Password</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="password" name="password" value="<?= htmlspecialchars($row['password']); ?>" required class="form-control">
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Status</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <select name="account_status" class="form-control" required>
                                            <option value="<?= htmlspecialchars($row['account_status']); ?>" hidden>
                                                <?= htmlspecialchars($row['account_status']); ?>
                                            </option>
                                            <option value="Active">Verified</option>
                                            <option value="Inactive">Declined</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group row text-right">
                                    <div class="col-12 col-sm-8 col-lg-6 offset-sm-3">
                                        <button type="submit" class="btn btn-space btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="alert alert-danger">No student data found!</div>
        <?php } ?>
    </div>
</div>

<!-- ============================================================== -->
<!-- JavaScript -->
<!-- ============================================================== -->
<script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../assets/vendor/parsley/parsley.js"></script>
<script src="../assets/libs/js/main-js.js"></script>
<script>
    $(document).ready(function() {
        $('form[name="student_form"]').on('submit', function(e) {
            e.preventDefault();

            const formData = $(this).serialize();

            $.ajax({
                url: '../init/controllers/edit_student.php',
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#message').html(response);
                    window.scrollTo(0, 0);
                },
                error: function() {
                    console.error("Error occurred during form submission.");
                }
            });
        });
    });
</script>
</body>

</html>
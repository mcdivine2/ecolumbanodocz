<?php include('main_header/header.php'); ?>
<?php include('left_sidebar/sidebar.php'); ?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title"><i class="fa fa-fw fa-user"></i> Profiles </h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $student_id = $_SESSION['student_id'];
        $conn = new class_model();
        $user = $conn->student_profile($student_id);
        ?>

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card influencer-profile-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="text-center">
                                    <div id="profileImage_2"></div>
                                </div>
                            </div>
                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8 col-12">
                                <div class="user-avatar-info">
                                    <div class="m-b-20">
                                        <div class="user-avatar-name">
                                            <h2 class="mb-1"><span id="firstName"><?= ucfirst($user['first_name']) . ' </span>' . ucfirst($user['middle_name']) . '<span id="lastName"> ' . ucfirst($user['last_name']); ?></span></h2>
                                        </div><br>
                                    </div>
                                    <div class="user-avatar-address">
                                        <p class="border-bottom pb-3">
                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-map-marker-alt mr-2 text-primary"></i><?= ucfirst($user['complete_address']); ?></span>
                                            <span class="mb-2 ml-xl-4 d-xl-inline-block d-block">Joined date: <?= date("M d, Y", strtotime($user['date_created'])); ?></span>
                                        </p>
                                        <div class="mt-3">
                                            <a href="#" class="badge badge-light mr-1"><i class="fa fa-fw fa-envelope"></i> <?= ucfirst($user['email_address']); ?></a>
                                            <a href="#" class="badge badge-light mr-1"><i class="fa fa-fw fa-phone"></i> <?= ucfirst($user['mobile_number']); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-top user-social-box">
                            <form id="validationform" data-parsley-validate="" novalidate="" method="POST">
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right"><i class="fa fa-user"></i> Account Info</label>
                                </div>
                                <div class="" id="message"></div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Username</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input data-parsley-type="alphanum" type="text" name="username" value="<?= $user['username']; ?>" required="" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Password</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input data-parsley-type="alphanum" type="password" name="password" value="<?= $user['password']; ?>" required="" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Email</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="email" name="email_address" value="<?= $user['email_address']; ?>" required="" placeholder="Email Address" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Phone Number</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input data-parsley-type="alphanum" type="text" name="mobile_number" value="<?= $user['mobile_number']; ?>" required="" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row text-right">
                                    <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                        <input name="student_id" value="<?= $user['student_id']; ?>" class="form-control" hidden>
                                        <button type="button" class="btn btn-space btn-primary" id="btn-change" style="background-color:#1269AF">Save Changes</button>
                                        <button class="btn btn-space btn-secondary" style="background-color:#272C4A">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../asset/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../asset/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../asset/vendor/parsley/parsley.js"></script>
<script src="../asset/libs/js/main-js.js"></script>
<script>
    $('#form').parsley();
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var firstName = $('#firstName').text();
        var lastName = $('#lastName').text();
        var intials = $('#firstName').text().charAt(0) + $('#lastName').text().charAt(0);
        $('#profileImage_2').text(intials);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let btn = document.querySelector('#btn-change');
        btn.addEventListener('click', () => {

            // Retrieve form field values
            const usernameField = document.querySelector('input[name="username"]');
            const passwordField = document.querySelector('input[name="password"]');
            const mobileNumberField = document.querySelector('input[name="mobile_number"]');
            const emailAddressField = document.querySelector('input[name="email_address"]');
            const studentIdField = document.querySelector('input[name="student_id"]');

            // Check if fields are found before accessing their values
            if (!usernameField || !passwordField || !mobileNumberField || !emailAddressField || !studentIdField) {
                console.error("One or more input fields are missing in the form.");
                $('#message').html('<div class="alert alert-danger">Required fields are missing in the form!</div>');
                return;
            }

            const username = usernameField.value.trim();
            const password = passwordField.value.trim();
            const mobile_number = mobileNumberField.value.trim();
            const email_address = emailAddressField.value.trim();
            const student_id = studentIdField.value.trim();

            // Validate fields
            if (username === '' || password === '' || mobile_number === '' || email_address === '') {
                $('#message').html('<div class="alert alert-danger">All fields are required!</div>');
                return;
            }

            // Create FormData and append values
            var data = new FormData();
            data.append('username', username);
            data.append('password', password);
            data.append('mobile_number', mobile_number);
            data.append('email_address', email_address);
            data.append('student_id', student_id);

            $.ajax({
                url: '../init/controllers/update_profile.php',
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    $("#message").html(response);
                    window.scrollTo(0, 0);
                },
                error: function() {
                    console.log("Update failed");
                    $('#message').html('<div class="alert alert-danger">Update failed. Please try again later.</div>');
                }
            });
        });
    });
</script>
</body>

</html>
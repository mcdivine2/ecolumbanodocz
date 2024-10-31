       <?php include('main_header/header.php');?>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
         <?php include('left_sidebar/sidebar.php');?>
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
                             <h2 class="pageheader-title"><i class="fa fa-fw fa-user-graduate"></i>  Create Student Account </h2>
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


                <style>
    .bg-gradient-primary {
        background: linear-gradient(90deg, #007bff 0%, #6610f2 100%);
    }

    .card-header {
        border-bottom: 0;
    }

    .form-control, .form-select {
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    }

    button:hover {
        transform: scale(1.05);
        transition: transform 0.2s ease-in-out;
    }

    #accountCreationSection {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->

                    <?php 
                    include '../init/model/config/connection2.php';
                    $GET_studid = intval($_GET['student']);
                    $student_number = $_GET['student-number'];
                    $sql = "SELECT * FROM `tbl_verification` WHERE `student_id`= ? AND student_id = ?";
                    $stmt = $conn->prepare($sql); 
                    $stmt->bind_param("is", $GET_studid, $student_number);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                    
                     $student_id = $row['student_id'];
                     $first_name = $row['first_name'];
                     $middle_name = $row['middle_name'];
                     $last_name = $row['last_name'];
                     $complete_address = $row['complete_address'];
                     $email_address = $row['email_address'];
                     $mobile_number = $row['mobile_number'];
                      
                     $account_status = $row['account_status']; 
                     $student_id = $row['student_id'];  
                   ?>
                    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-gradient-primary text-white text-center py-4">
                    <h4 class="mb-0"><i class="fa fa-user"></i> Student Information</h4>
                </div>
                <div class="card-body p-4">
                <div id="message"></div>
                    <form id="studentForm" name="student_form" data-parsley-validate="" novalidate="" method="POST"  action="../init/controllers/email_sender2.php">
                        <!-- Student Information Section -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">EDP Number</label>
                                <input type="text" name="student_id" value="<?= $student_id; ?>" readonly class="form-control shadow-sm border-0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">First Name</label>
                                <input type="text" name="first_name" value="<?= $first_name; ?>" readonly class="form-control shadow-sm border-0">
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Middle Name</label>
                                <input type="text" name="middle_name" value="<?= $middle_name; ?>" readonly class="form-control shadow-sm border-0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Last Name</label>
                                <input type="text" name="last_name" value="<?= $last_name; ?>" readonly class="form-control shadow-sm border-0">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Complete Address</label>
                                <input name="complete_address" value="<?= $complete_address; ?>" readonly class="form-control shadow-sm border-0"></input>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Email Address</label>
                                <input type="email" name="email_address" value="<?= $email_address; ?>" readonly class="form-control shadow-sm border-0">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Mobile Number</label>
                                <input type="text" name="mobile_number" value="<?= $mobile_number; ?>" readonly class="form-control shadow-sm border-0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Proof of ID</label><br>
                                <a href="../../student/<?php echo $row['id_upload']?>" target="_blank">
                                    <img src="../../student/<?php echo $row['id_upload']?>" class="img-thumbnail shadow-sm rounded" width="100">
                                </a>
                            </div>
                        </div>

                        <!-- Button to Show Account Creation Section -->
                        <div class="text-center mb-4">
                            <button type="button" id="createAccountBtn" class="btn btn-success btn-lg shadow-sm px-4">Create Account</button>
                        </div>

                        <!-- Account Creation Section (Initially Hidden) -->
                        <div id="accountCreationSection" class="mt-4" style="display: none;">
                            <div class="card border-secondary shadow-sm">
                                <div class="card-header bg-secondary text-white text-center py-3">
                                    <h5 class="mb-0"><i class="fa fa-user-lock"></i> Create Client Account</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label font-weight-bold">Email (Username)</label>
                                            <input data-parsley-type="email" type="text" name="username" value="<?= $email_address; ?>" required class="form-control shadow-sm border-0">
                                        </div>
                                        <?php 
                                    function createRandomcnumber() {
                                        $chars = "012345678909284848596439120580903";
                                        srand((double)microtime()*1000000);
                                        $i = 0;
                                        $control = '';
                                        while ($i <= 5) {
                                            $num = rand() % strlen($chars); // Ensure the correct range for the random number
                                            $tmp = substr($chars, $num, 1);
                                            $control .= $tmp;
                                            $i++;
                                        }
                                        return $control;
                                    }
                                    $cNumber = 'odrs' . createRandomcnumber();
                                    ?>
                                        <div class="col-md-6">
                                            <label class="form-label font-weight-bold">Password</label>
                                            <input type="text" value="<?php echo $cNumber; ?>" name="password" required class="form-control shadow-sm border-0">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label font-weight-bold">Account Status</label>
                                            <select class="form-select shadow-sm border-0" value="<?= $account_status; ?>" id="account_status" name="account_status" required>
                                                <option value="<?= $account_status; ?>" hidden> Verified</option>
                                                <option value="Active" class="bg-success text-white">Verified</option>
                                                <option value="Inactive" class="bg-danger text-white">Declined</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button (Inside the Account Creation Section) -->
                        <div class="text-center mt-6" id="submitSection" style="display: none;">
                            <input name="student_id" value="<?= $student_id; ?>" type="hidden">
                            <button data-id="<?= $row['student_id']; ?>" class="btn btn-primary btn-lg shadow-sm px-4 delete" type="submit">Submit</button>
                        </div>
                    </form>
                    <?php }?>
                </div>
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
        $(document).ready(function(){
          var firstName = $('#firstName').text();
          var lastName = $('#lastName').text();
          var intials = $('#firstName').text().charAt(0) + $('#lastName').text().charAt(0);
          var profileImage = $('#profileImage').text(intials);
        });
    </script>
    <script>
         document.getElementById('createAccountBtn').addEventListener('click', function() {
        document.getElementById('accountCreationSection').style.display = 'block';
        document.getElementById('submitSection').style.display = 'block';
        this.style.display = 'none'; // Hide the Create Account button after clicking
    });
    $('#form').parsley();
    </script>
    <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    </script>
    <script>
      $(document).ready(function() {
    $('form[name="student_form"]').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var requiredFields = ['student_id', 'first_name', 'middle_name', 'last_name', 'complete_address', 'email_address', 'mobile_number', 'username', 'password'];
        
        // Append account status manually
        formData.append('account_status', $('#account_status option:selected').val());

        // Validate required fields
        var isEmpty = requiredFields.some(field => !$(`input[name="${field}"], textarea[name="${field}"]`).val().trim());

        if (isEmpty) {
            $('#message').html('<div class="alert alert-danger">Required All Fields!</div>');
            window.scrollTo(0, 0);
        } else {
            $.ajax({
                url: '../init/controllers/create-account.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
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

$(document).ready(function() {

load_data();

var count = 1;

function load_data() {
    $(document).on('click', '.delete', function() {

        var student_id = $(this).attr("data-id");

        // Automatically delete without confirmation
        $.ajax({
            url: "../init/controllers/delete_student.php",
            method: "POST",
            data: {
                student_id: student_id
            },
            success: function(response) {
                $("#message").html(response);  // Display the response message
            },
            error: function(response) {
                console.log("Failed");
            }
        });
    });
}

});

 </script>
 
</body>
 
</html>
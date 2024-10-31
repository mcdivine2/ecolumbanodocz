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
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card influencer-profile-data">
                                        <div class="card-body">
                                            <div class="" id="message"></div>
                                            <form id="validationform" name="student_form" data-parsley-validate="" novalidate="" method="POST" enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right"><i class="fa fa-user"></i> Student Info</label>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">EDP Number</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                        <input data-parsley-type="alphanum" type="text" name="student_id" value="<?= $student_id; ?>" required="" placeholder="" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">First Name</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                        <input data-parsley-type="alphanum" type="text" name="first_name" value="<?= $first_name; ?>" required="" placeholder="" class="form-control">
                                                    </div>
                                                </div>
                                                  <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Middle Name</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                        <input data-parsley-type="alphanum" type="text" name="middle_name" value="<?= $middle_name; ?>" required="" placeholder="" class="form-control">
                                                    </div>
                                                </div>
                                                   <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Last Name</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                        <input data-parsley-type="alphanum" type="text" name="last_name" value="<?= $last_name; ?>" required="" placeholder="" class="form-control">
                                                    </div>
                                                </div>
                                              

                                               <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Complete Address</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                       <textarea rows="1" data-parsley-type="alphanum" type="text" name="complete_address" required="" placeholder="" class="form-control"><?= $complete_address; ?></textarea>
                                                    </div>
                                                </div>
                                                  <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Email Address</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                        <input data-parsley-type="alphanum" type="email" value="<?= $email_address; ?>" name="email_address" required="" placeholder="" class="form-control">
                                                    </div>
                                                </div>
                                                   <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Mobile Number</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                        <input data-parsley-type="alphanum" type="text" value="<?= $mobile_number;?>" name="mobile_number" minlength="11" maxlength="11" required="" placeholder="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Proof ID</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                    <a href="../../student/<?php echo $row['id_upload']?>" target="_blank"><img src="../../student/<?php echo $row['id_upload']?>" width=75></a>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-4 col-form-label text-sm-right"><i class="fa fa-user-lock"></i> Create Username & Password</label>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Username</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                        <input data-parsley-type="alphanum" type="text" value="" name="username" required="" placeholder="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Password</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                        <input data-parsley-type="alphanum" type="passwrd" value="" name="password" required="" placeholder="" class="form-control">
                                                    </div>
                                                </div>
                                                 <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Status</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                       <select data-parsley-type="alphanum" type="text" value="<?= $account_status; ?>" id="account_status" required="" placeholder="" class="form-control">
                                                           <option value="<?= $account_status; ?>" hidden><?= $account_status; ?></option>
                                                           <option value="Active" style="background-color: green;color: #fff">Verified</option>
                                                           <option value="Inactive" style="background-color: red;color: #fff">Declined</option>
                                                       </select>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="form-group row text-right">
                                                    <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                                       <input name="student_id" value="<?= $student_id; ?>" type="hidden">
                                                        <button  class="btn btn-space btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php } ?>
                                        </div>
                                    </div>
                             </div>
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
       $('form[name="student_form"]').on('submit', function(e){
          e.preventDefault();
        
          var a = $(this).find('input[name="student_id"]').val();
          var b = $(this).find('input[name="first_name"]').val();
          var c = $(this).find('input[name="middle_name"]').val();
          var d = $(this).find('input[name="last_name"]').val();
         
          var e = $(this).find('textarea[name="complete_address"]').val();
          var f = $(this).find('input[name="email_address"]').val();
          var g = $(this).find('input[name="mobile_number"]').val(); 
          var h = $(this).find('input[name="username"]').val();
          var i = $(this).find('input[name="password"]').val();
         
          var j = $('#account_status option:selected').val();

          var data = new FormData(this.form);
          
          data.append('student_id', a);
          data.append('first_name', b);
          data.append('middle_name', c);
          data.append('last_name', d);
          data.append('complete_address', e);
          data.append('email_address', f);
          data.append('mobile_number', g);
          data.append('username', h);
          data.append('password', i);
          
          data.append('account_status', j);
         


         if (a === '' &&  b ==='' &&  c==='' &&  d ==='' &&  e ==='' &&  f ==='' &&  g ==='' &&  h ==='' &&  i ==='' &&  j ===''){
              $('#message').html('<div class="alert alert-danger"> Required All Fields!</div>');
              window.scrollTo(0, 0);
            }else{
            $.ajax({
                url: '../init/controllers/create-account.php',
                method: 'POST',
                data: data,
                contentType: false,
                processData: false,
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
</body>
 
</html>
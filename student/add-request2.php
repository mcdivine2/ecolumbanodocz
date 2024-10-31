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
                             <h2 class="pageheader-title"><i class="fa fa-fw fa-file"></i> Add Request </h2>
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

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card influencer-profile-data">
                                        <div class="card-body">
                                             <div class="" id="message"></div>
                                            <form id="validationform" name="docu_forms" data-parsley-validate="" novalidate="" method="POST">
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right"><i class="fa fa-file"></i> Request Info</label>
                                                </div>
                                                <?php 

                                                  function createRandomcnumber() {
                                                      $chars = "003232303232023232023456789";
                                                      srand((double)microtime()*1000000);
                                                      $i = 0;
                                                      $control = '' ;
                                                      while ($i <= 3) {

                                                        $num = rand() % 33;

                                                        $tmp = substr($chars, $num, 1);

                                                        $control = $control . $tmp;

                                                        $i++;

                                                      }
                                                      return $control;
                                                     }
                                                     $cNumber ='CTRL-'.createRandomcnumber();


                                                ?>
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Control No.</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                        <input data-parsley-type="alphanum" type="text" value="<?= $cNumber.''.$_SESSION['student_id']; ?>" name="control_no" required="" placeholder="" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                 <?php
                                                      $conn = new class_model();
                                                      $getstudno = $conn->student_profile($student_id);
                                                   ?>
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Student ID</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                        <input data-parsley-type="alphanum"  name="studentID_no" value="<?= $getstudno['studentID_no']; ?>" type="text" required="" placeholder="" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                     
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Email Address</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                        <input data-parsley-type="alphanum"  name="email_address" value="<?= $getstudno['email_address']; ?>" type="text" required="" placeholder="" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Document Name</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                        <label>Select Document</label> <br>

                                                        <input type="checkbox" name="document_name[]" id="document_name1" value="Transcript of Records"> Transcript of Records <br>
                                                        <div id="quantity1" class="hidden mt-1">
                                                            <label for="Transcript of Records">Copies:</label>
                                                            <div class="spinner colorful">
                                                                <button class="btn btn-minus" type="button">-</button>
                                                                <input type="text" name="no_ofcopies[]" value="1" class="form-control">
                                                                <button class="btn btn-plus" type="button">+</button>
                                                            </div>
                                                        </div>

                                                        <input type="checkbox" name="document_name[]" id="document_name2" value="Evaluation of Grades"> Evaluation of Grades <br>
                                                        <div id="quantity2" class="hidden mt-1">
                                                            <label for="Evaluation of Grades">Copies:</label>
                                                            <div class="spinner colorful">
                                                                <button class="btn btn-minus" type="button">-</button>
                                                                <input type="text" name="no_ofcopies[]" value="1" class="form-control">
                                                                <button class="btn btn-plus" type="button">+</button>
                                                            </div>
                                                        </div>

                                                        <input type="checkbox" name="document_name[]" id="document_name3" value="Certificate of Grades"> Certificate of Grades <br>
                                                        <div id="quantity3" class="hidden mt-1">
                                                            <label for="Certificate of Grades">Copies:</label>
                                                            <div class="spinner colorful">
                                                                <button class="btn btn-minus" type="button">-</button>
                                                                <input type="text" name="no_ofcopies[]" value="1" class="form-control">
                                                                <button class="btn btn-plus" type="button">+</button>
                                                            </div>
                                                        </div>

                                                        <input type="checkbox" name="document_name[]" id="document_name4" value="Certificate of Registration"> Certificate of Registration <br>
                                                        <div id="quantity4" class="hidden mt-1">
                                                            <label for="Certificate of Registration">Copies:</label>
                                                            <div class="spinner colorful">
                                                                <button class="btn btn-minus" type="button">-</button>
                                                                <input type="text" name="no_ofcopies[]" value="1" class="form-control">
                                                                <button class="btn btn-plus" type="button">+</button>
                                                            </div>
                                                        </div>

                                                        <input type="checkbox" name="document_name[]" id="document_name5" value="Good Moral"> Good Moral <br>
                                                        <div id="quantity5" class="hidden mt-1">
                                                            <label for="Good Moral">Copies:</label>
                                                            <div class="spinner colorful">
                                                                <button class="btn btn-minus" type="button">-</button>
                                                                <input type="text" name="no_ofcopies[]" value="1" class="form-control">
                                                                <button class="btn btn-plus" type="button">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                 <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Date Request</label>
                                                    <div class="col-12 col-sm-8 col-lg-6">
                                                        <input data-parsley-type="alphanum"  type="text" name="date_request" required="" placeholder="" class="form-control" value="<?php echo date('M d Y');?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">Mode: </label>
                                                    <div class="col-12 col-sm-8 col-md-2">
                                                <select data-parsley-type="alphanum" type="text" name="mode_request" id="mode_request" required="" placeholder="" class="form-control">
                                                           <option value="">&larr;Select Mode &rarr;</option> 
                                                           <option value="Pick Up">Pick-Up</option>
                                                           <option value="Delivery">Delivery</option>
                                                       </select> 
                                                       </div>
                                                       <label class="col-12 col-md-1 col-form-label text-sm-right" style="color: red;">Delivery Additional: ₱50</label>
                                                    </div>


                                                </div>
                                                <div class="form-group row text-right">
                                                    <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                                        <input type="text" name="student_id" value="<?= $_SESSION['student_id'];?>" class="form-control" hidden>
                                                       <button type="button" class="btn btn-space btn-primary" id="add-request"style="background-color:#1269AF !important; color:white">Submit</button>
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
    $(document).ready(function(){
      $('.btn-minus').click(function(){
        var input = $(this).siblings('input');
        var value = parseInt(input.val());
        if (value > 1) {
          input.val(value - 1);
        }
      });

      $('.btn-plus').click(function(){
        var input = $(this).siblings('input');
        var value = parseInt(input.val());
        input.val(value + 1);
      });
    });
  </script>

<script>
    function updateQuantity(inputId, delta) {
      const input = document.getElementById(inputId);
      let value = parseInt(input.value) || 0;
      value += delta;
      if (value < 1) value = 1;
      input.value = value;
    }

    $(document).ready(function() {
      $('input[type="checkbox"][name="document_name[]"]').change(function() {
        const quantityId = '#quantity' + this.id.replace('document_name', '');
        if (this.checked) {
          $(quantityId).removeClass('hidden');
        } else {
          $(quantityId).addClass('hidden');
        }
      });
    });
  </script>
      <script>
     document.addEventListener('DOMContentLoaded', () => {
        let btn = document.querySelector('#add-request');
        btn.addEventListener('click', () => {
            // Create a new FormData object from the form
            const form = document.querySelector('form[name="docu_forms"]');
            var data = new FormData(form);

            // Ensure that each document has its corresponding number of copies
            $('input[type="checkbox"][name="document_name[]"]').each(function(index) {
                if (this.checked) {
                    let no_ofcopies = $(this).closest('.form-group').find('input[name="no_ofcopies[]"]').val();
                    data.append('document_name[]', this.value);
                    data.append('no_ofcopies[]', no_ofcopies);
                }
            });

            // Validate other required fields
            let allFieldsFilled = true;
            ['control_no', 'studentID_no', 'email_address', 'date_request', 'mode_request'].forEach(field => {
                if (!data.get(field)) {
                    allFieldsFilled = false;
                }
            });

            if (!allFieldsFilled) {
                $('#message').html('<div class="alert alert-danger">Required All Fields!</div>');
            } else {
                $.ajax({
                    url: '../init/controllers/add_request.php',
                    type: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
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



<!--     <script>
    $('#form').parsley();
    </script> -->
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

</body>
 
</html>
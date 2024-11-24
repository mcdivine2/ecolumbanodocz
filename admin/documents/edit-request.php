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
               <div class="row">
                   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                       <div class="page-header">
                           <h2 class="pageheader-title"><i class="fa fa-fw fa-file"></i> Edit Request & Send Email </h2>
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
                $sql = "SELECT tbl_documentrequest.*, tbl_students.email_address, tbl_students.first_name, tbl_students.last_name 
                FROM tbl_documentrequest 
                INNER JOIN tbl_students ON tbl_documentrequest.student_id = tbl_students.student_id 
                WHERE tbl_documentrequest.request_id = ? AND tbl_documentrequest.student_id = ?";
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
                                   <form id="validationform" name="docu_forms" data-parsley-validate="" novalidate="" method="POST" action="../init/controllers/edit_request.php">

                                       <!-- Request Info Section -->
                                       <h5><i class="fa fa-file"></i> Request Info</h5>
                                       <div class="form-group row">
                                           <label class="col-12 col-sm-3 col-form-label text-sm-right">Control No.</label>
                                           <div class="col-12 col-sm-8 col-lg-6">
                                               <input type="text" value="<?= $row['control_no']; ?>" name="control_no" class="form-control" readonly>
                                           </div>
                                       </div>
                                       <div class="form-group row">
                                           <label class="col-12 col-sm-3 col-form-label text-sm-right">Student EDP</label>
                                           <div class="col-12 col-sm-8 col-lg-6">
                                               <input type="text" value="<?= $row['studentID_no']; ?>" name="studentID_no" class="form-control" readonly>
                                           </div>
                                       </div>
                                       <input type="text" name="request_type" value="<?= $row['request_type']; ?>" hidden>
                                       <div class="form-group row">
                                           <label class="col-12 col-sm-3 col-form-label text-sm-right">Student Name</label>
                                           <div class="col-12 col-sm-8 col-lg-6">
                                               <input type="text" value="<?= $row['first_name']; ?> <?= $row['last_name']; ?>" class="form-control" readonly>
                                           </div>
                                       </div>
                                       <div class="form-group row">
                                           <label class="col-12 col-sm-3 col-form-label text-sm-right">Document Name</label>
                                           <div class="col-12 col-sm-8 col-lg-6">
                                               <input type="text" value="<?= $row['document_name']; ?>" name="document_name" class="form-control" readonly>
                                           </div>
                                       </div>
                                       <div class="form-group row">
                                           <label class="col-12 col-sm-3 col-form-label text-sm-right">Date Request</label>
                                           <div class="col-12 col-sm-8 col-lg-6">
                                               <input type="date" value="<?= strftime('%Y-%m-%d', strtotime($row['date_request'])); ?>" name="date_request" class="form-control" readonly>
                                           </div>
                                       </div>
                                       <?php
                                        $hideDateReleasing = (
                                            $row['library_status'] !== "Verified" ||
                                            $row['custodian_status'] !== "Verified" ||
                                            $row['accounting_status'] !== "Verified" ||
                                            !in_array($row['dean_status'], ["Verified", "Not Included"])
                                        );
                                        ?>

                                       <div class="form-group row">
                                           <?php if ($hideDateReleasing): ?>
                                               <label class="col-12 col-sm-3 col-form-label text-sm-right">Notice</label>
                                               <div class="col-12 col-sm-8 col-lg-6">
                                                   <p class="form-control-plaintext text-danger">
                                                       Date Releasing cannot be set because one or more statuses are not verified.
                                                   </p>
                                               </div>
                                           <?php else: ?>
                                               <label class="col-12 col-sm-3 col-form-label text-sm-right">Date Releasing</label>
                                               <div class="col-12 col-sm-8 col-lg-6">
                                                   <input type="date" value="<?= $row['date_releasing']; ?>" name="date_releasing" class="form-control">
                                               </div>
                                           <?php endif; ?>
                                       </div>

                                       <!-- Status Section -->
                                       <div class="form-group row">
                                           <label class="col-12 col-sm-3 col-form-label text-sm-right">Status</label>
                                           <div class="col-12 col-sm-8 col-lg-6">
                                               <select name="status" id="status" class="form-control" onchange="updateEmailBody()">
                                                   <option value="<?= $row['status']; ?>" hidden><?= $row['status']; ?></option>
                                                   <option value="Pending">Pending</option>
                                                   <option value="Declined">Declined</option>
                                                   <option value="Verified">Verified</option>
                                                   <option value="Released">Released</option>
                                               </select>
                                           </div>
                                       </div>

                                       <?php
                                            // Remove <br> tags from the database value before using it in the HTML
                                            $document_name_cleaned = preg_replace('/<br\s*\/?>/i', "\n", $row['document_name']);
                                        ?>

                                       <!-- Hidden Fields to Store PHP Data for JavaScript -->
                                       <input type="hidden" id="documentName" value="<?= htmlspecialchars($document_name_cleaned); ?>">
                                       <input type="hidden" id="controlNo" value="<?= $row['control_no']; ?>">

                                       <!-- Email Form Section -->
                                       <div class="form-group row">
                                           <label class="col-12 col-sm-3 col-form-label text-sm-right">Send to:</label>
                                           <div class="col-12 col-sm-8 col-lg-6">
                                               <input type="text" value="<?= $row['email_address']; ?>" name="email_address" class="form-control" readonly>
                                           </div>
                                       </div>
                                       <div class="form-group row">
                                           <label class="col-12 col-sm-3 col-form-label text-sm-right">Subject:</label>
                                           <div class="col-12 col-sm-8 col-lg-6">
                                               <input type="text" value="Request Update for <?= htmlspecialchars($document_name_cleaned); ?>" name="subject" class="form-control">
                                           </div>
                                       </div>

                                       <div class="form-group row">
                                           <label class="col-12 col-sm-3 col-form-label text-sm-right">Message:</label>
                                           <div class="col-12 col-sm-8 col-lg-6">
                                               <textarea name="body" id="emailBody" class="form-control"></textarea>
                                           </div>
                                       </div>

                                       <!-- Submit Button -->
                                       <div class="form-group row text-right">
                                           <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                               <input type="hidden" name="request_id" value="<?= $row['request_id']; ?>">
                                               <button type="submit" class="btn btn-space btn-primary">Update and Send Email</button>
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
       <!-- JavaScript for Updating the Textarea -->
       <script type="text/javascript">
           function updateEmailBody() {
               // Get status, document name, and control number from the hidden inputs and status dropdown
               const status = document.getElementById("status").value;
               const documentName = document.getElementById("documentName").value;
               const controlNo = document.getElementById("controlNo").value;

               let message = "Hello, This is a test! ";

               switch (status) {
                   case "Pending":
                       message += `Your request for ${documentName} has been marked as Pending with Reference # ${controlNo}.`;
                       break;
                   case "Declined":
                       message += `We regret to inform you that your request for ${documentName} has been Declined. Reference # ${controlNo}.`;
                       break;
                   case "Verified":
                       message += `Your request for ${documentName} has been Verified with Reference # ${controlNo}.`;
                       break;
                   case "Released":
                       message += `Your request for ${documentName} has been Released. Please check your email for further instructions. Reference # ${controlNo}.`;
                       break;
                   default:
                       message = "";
               }

               document.getElementById("emailBody").value = message;
           }

           // Initialize the email body with the current status when the page loads
           document.addEventListener("DOMContentLoaded", updateEmailBody);
       </script>



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
       <!-- dont ando -->

       <script>
           document.addEventListener('DOMContentLoaded', () => {
               let btn = document.querySelector('#edit-request');
               btn.addEventListener('click', () => {

                   const control_no = document.querySelector('input[name=control_no]').value;
                   const student_id = document.querySelector('input[name=studentID_no]').value;
                   const document_name = document.querySelector('input[name=document_name]').value;
                   const date_request = document.querySelector('input[name=date_request]').value;
                   const date_releasing = document.querySelector('input[name=date_releasing]').value;
                   const processing_officer = document.querySelector('input[name=processing_officer]').value;
                   const status = $('#status option:selected').val();
                   const request_id = document.querySelector('input[name=request_id]').value;

                   var data = new FormData(this.form);

                   data.append('control_no', control_no);
                   data.append('studentID_no', studentID_no);
                   data.append('document_name', document_name);
                   data.append('date_request', date_request);
                   data.append('date_releasing', date_releasing);
                   data.append('status', status);
                   data.append('request_id', request_id);


                   // Trimmed input values for accurate validation
                   if ($.trim(control_no) === '' ||
                       $.trim(studentID_no) === '' ||
                       $.trim(document_name) === '' ||
                       $.trim(date_request) === '' ||
                       $.trim(date_releasing) === '' ||
                       $.trim(processing_officer) === '') {

                       $('#message').html('<div class="alert alert-danger">All fields are required!</div>');
                       window.scrollTo(0, 0); // Ensure the user sees the alert
                   } else {
                       $.ajax({
                           url: '../init/controllers/edit_request.php',
                           type: "POST",
                           data: data,
                           processData: false,
                           contentType: false,
                           cache: false,
                           success: function(response) {
                               $('#message').html(response);
                               $('#message').html('<div class="alert alert-success">Edit Successfully.</div>');
                               window.scrollTo(0, 0); // Scroll to top to display the success message

                               // Add a 3-second delay before taking further action
                               setTimeout(function() {
                                   // Redirect or any other desired action after delay
                                   $('#message').html('Edit Successfuly'); // Clear the message after 3 seconds (optional)
                               }, 3000); // 3 seconds = 3000ms
                           },
                           error: function(xhr, status, error) {
                               console.error("Failed:", error);
                               $('#message').html('<div class="alert alert-danger">An error occurred while processing your request. Please try again later.</div>');
                               window.scrollTo(0, 0); // Ensure user sees the error message
                           }

                       });
                   }


               });
           });
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

       </body>

       </html>
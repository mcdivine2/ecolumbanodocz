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
                           <h2 class="pageheader-title"><i class="fa fa-fw fa-user-graduate"></i> Client Verification </h2>
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

               <div class="row">
                   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                       <div class="card">
                           <h5 class="card-header">Client Verification Information</h5>
                           <div class="card-body">
                               <div id="message"></div>
                               <div class="table-responsive">
                                   <!-- <a href="add-student.php" class="btn btn-sm" style="background-color:#1269AF !important; color:white"><i class="fa fa-fw fa-user-plus"></i> Add College Student</a><br><br> -->
                                   <table class="table table-striped table-bordered first">
                                       <thead>
                                           <tr>
                                               <th scope="col">Date Created</th>
                                               <th scope="col">EDP Number</th>
                                               <th scope="col">Complete Name</th>
                                               <th scope="col">Contact</th>
                                               <th scope="col">Email</th>
                                               <th scope="col">View Image</th>
                                               <th scope="col">Action</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           <?php
                                            $conn = new class_model();
                                            $student = $conn->fetchAll_verification();
                                            ?>
                                           <?php foreach ($student as $row) { ?>
                                               <tr>
                                                   <td><?= $row['date_created']; ?></td>
                                                   <td><?= $row['student_id']; ?></td>
                                                   <td><?= $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']; ?></td>
                                                   <td><?= $row['mobile_number']; ?></td>
                                                   <td><?= $row['email_address']; ?></td>
                                                   <td><a href="../../student/<?php echo $row['id_upload'] ?>" target="_blank"><img src="../../student/<?php echo $row['id_upload'] ?>" width=75></a></td>
                                                   <td class="align-right">
                                                       <a href="create-account.php?student=<?= $row['student_id']; ?>&student-number=<?php echo $row['student_id']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                           <i class="fa fa-edit"></i>
                                                       </a>
                                                       <a href="javascript:;" data-id="<?= $row['student_id']; ?>" class="text-secondary font-weight-bold text-xs delete" data-toggle="tooltip" data-original-title="Edit user">
                                                           <i class="fa fa-trash-alt"></i>
                                                       </a>
                                                   </td>
                                               </tr>
                                           <?php } ?>
                                   </table>
                               </div>
                           </div>
                       </div>
                   </div>
                   <!-- ============================================================== -->
                   <!-- end responsive table -->
                   <!-- ============================================================== -->
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
       <script src="../assets/vendor/custom-js/jquery.multi-select.html"></script>
       <script src="../assets/libs/js/main-js.js"></script>
       <script src="../assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
       <script src="../assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
       <script src="../assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
       <script src="../assets/vendor/datatables/js/data-table.js"></script>
       <script type="text/javascript">
           $(document).ready(function() {
               var firstName = $('#firstName').text();
               var lastName = $('#lastName').text();
               var intials = $('#firstName').text().charAt(0) + $('#lastName').text().charAt(0);
               var profileImage = $('#profileImage').text(intials);
           });
       </script>
       <script>
           $(document).ready(function() {

               load_data();

               var count = 1;

               function load_data() {
                   $(document).on('click', '.delete', function() {

                       var student_id = $(this).attr("data-id");
                       // console.log("================get course_id================");
                       // console.log(course_id);
                       if (confirm("Are you sure want to remove this data?")) {
                           $.ajax({
                               url: "../init/controllers/delete_student.php",
                               method: "POST",
                               data: {
                                   student_id: student_id
                               },
                               success: function(response) {

                                   $("#message").html(response);
                               },
                               error: function(response) {
                                   console.log("Failed");
                               }
                           })
                       }
                   });
               }

           });
       </script>

       </body>

       </html>
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
                           <h2 class="pageheader-title"><i class="fa fa-fw fa-certificate"></i> Manage Document </h2>
                           <div class="page-breadcrumb">
                               <nav aria-label="breadcrumb">
                                   <ol class="breadcrumb">
                                       <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                       <li class="breadcrumb-item active" aria-current="page">Manage Document</li>
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
                           <h5 class="card-header">Documents Information</h5>
                           <div class="card-body">
                               <div id="message"></div>
                               <div class="table-responsive">
                                   <a href="add-document.php" class="btn btn-sm" style="background-color:#1269AF !important; color:white"><i class="fa fa-fw fa-plus"></i> Add Document</a><br><br>
                                   <table class="table table-striped table-bordered first">
                                       <thead>
                                           <tr>
                                               <th scope="col">Document Name</th>
                                               <th scope="col">Description</th>
                                               <th scope="col">Days to Process</th>
                                               <th scope="col">Price</th>
                                               <th scope="col">Edit</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           <?php
                                            $conn = new class_model();
                                            $doc = $conn->fetchAll_document();
                                            ?>
                                           <?php foreach ($doc as $row) { ?>
                                               <tr>
                                                   <td><?= $row['document_name']; ?></td>
                                                   <td><?= $row['description']; ?></td>
                                                   <td><?= $row['daysto_process']; ?></td>
                                                   <td><?= $row['price']; ?></td>
                                                   <td class="align-right">
                                                       <a href="edit-document.php?document=<?= $row['document_id']; ?>&document-name=<?php echo $row['document_name']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                           <i class="fa fa-edit"></i>
                                                       </a>
                                                       <button class="btn btn-danger btn-sm delete-document" data-id="<?= $row['document_id']; ?>">Delete</button>
                                                   </td>
                                               </tr>
                                           <?php } ?>
                                       </tbody>
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
               // Handle Delete Button Click
               $(document).on('click', '.delete-document', function() {
                   var document_id = $(this).data('id');

                   if (confirm("Are you sure you want to delete this document?")) {
                       $.ajax({
                           url: "../init/controllers/delete_document.php", // Update path as needed
                           method: "POST",
                           data: {
                               document_id: document_id
                           },
                           success: function(response) {
                               $("#message").html(response);
                               location.reload(); // Reload the page to reflect changes
                           },
                           error: function(error) {
                               console.error("Error:", error);
                           }
                       });
                   }
               });
           });
       </script>

       <script>
           $(document).ready(function() {

               function load_unseen_notification(view = '') {
                   $.ajax({
                       url: "../init/controllers/fetch.php",
                       method: "POST",
                       data: {
                           view: view
                       },
                       dataType: "json",
                       success: function(data) {
                           $('.dropdown-menu_1').html(data.notification);
                           if (data.unseen_notification > 0) {
                               $('.count').html(data.unseen_notification);
                           }
                       }
                   });
               }

               load_unseen_notification();

               $(document).on('click', '.dropdown-toggle', function() {
                   $('.count').html('');
                   load_unseen_notification('yes');
               });

               setInterval(function() {
                   load_unseen_notification();;
               }, 5000);

           });
       </script>

       </body>

       </html>
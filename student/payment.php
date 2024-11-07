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
                           <h2 class="pageheader-title"><i class="fa fa-fw fa-money-bill-wave"></i> Payment </h2>
                           <div class="page-breadcrumb">
                               <nav aria-label="breadcrumb">
                                   <ol class="breadcrumb">
                                       <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                       <li class="breadcrumb-item active" aria-current="page">Payment</li>
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
                           <h5 class="card-header">Payment Information</h5>
                           <div class="card-body">
                               <div id="message"></div>
                               <div class="table-responsive">
                                   <table class="table table-striped table-bordered first">
                                       <thead>
                                           <tr>
                                               <th scope="col">Control No.</th>
                                               <th scope="col">Studemt ID</th>
                                               <th scope="col">Student Name</th>
                                               <th scope="col">Document Name</th>
                                               <th scope="col">Trace No.</th>
                                               <th scope="col">Reference No.</th>
                                               <th scope="col">Total Amount</th>
                                               <th scope="col">Date of Payment</th>
                                               <th scope="col">Proof of Payment</th>
                                               <th scope="col">Status</th>
                                               <th scope="col">Clearance</th>
                                               <th scope="col">View Info</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           <?php
                                            function formatMoney($number, $fractional = false)
                                            {
                                                if ($fractional) {
                                                    $number = sprintf('%.2f', $number);
                                                }
                                                while (true) {
                                                    $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
                                                    if ($replaced != $number) {
                                                        $number = $replaced;
                                                    } else {
                                                        break;
                                                    }
                                                }
                                                return $number;
                                            }
                                            $student_id = $_SESSION['student_id'];
                                            $conn = new class_model();
                                            $payment = $conn->fetchAll_payments($student_id);
                                            ?>
                                           <?php foreach ($payment as $row) { ?>
                                               <tr>
                                                   <td><?= $row['control_no']; ?></td>
                                                   <td><?= $row['student_id']; ?></td>
                                                   <td><?= ucwords($row['student_name']); ?></td>
                                                   <td><?= $row['document_name']; ?></td>
                                                   <td><?= $row['trace_no']; ?></td>
                                                   <td><?= $row['ref_no']; ?></td>
                                                   <td><?php $tamount = $row['total_amount'];
                                                        echo 'Php' . ' ' . formatMoney($tamount, true); ?></td>
                                                   <td>
                                                       <?php
                                                        if ($row['date_ofpayment'] === "") {
                                                            echo "";
                                                        } else if ($row['date_ofpayment'] === $row['date_ofpayment']) {
                                                            echo date("M d, Y", strtotime($row['date_ofpayment']));
                                                        }
                                                        ?>
                                                   </td>

                                                   <td><?= $row['proof_ofpayment']; ?></td>
                                                   <td>
                                                       <?php
                                                        if ($row['status'] === "Verified") {
                                                            echo '<span class="badge bg-warning text-white">Verified</span>';
                                                        } else if ($row['status'] === "Paid") {
                                                            echo '<span class="badge bg-success text-white">Paid</span>';
                                                        } else if ($row['status'] === "Declined") {
                                                            echo '<span class="badge bg-danger text-white">Rejected</span>';
                                                        }
                                                        ?>
                                                   </td>
                                                   <td class="align-right">
                                                       <div class="box">
                                                           <div class="three">
                                                               <!-- Converted to a button -->
                                                               <a href="Track-document.php?request=<?= $row['control_no']; ?>&student-number=<?= $row['student_id']; ?>" class="btn btn-sm btn-primary text-xs" data-toggle="tooltip" data-original-title="Clearance">
                                                                   Clearance
                                                               </a>
                                                           </div>
                                                   </td>

                                                   <td>
                                                       <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#paymentModal"
                                                           data-student-id="<?= $row['student_id']; ?>"
                                                           data-student-name="<?= $row['student_name']; ?>"
                                                           data-control-no="<?= $row['control_no']; ?>"
                                                           data-document-name="<?= $row['document_name']; ?>"
                                                           data-total-amount="<?= $row['total_amount']; ?>"
                                                           data-date-payment="<?= $row['date_ofpayment']; ?>"
                                                           data-status="<?= $row['status']; ?>"
                                                           data-proof-of-payment="../../student/<?= $row['proof_ofpayment']; ?>">
                                                           <i class="fa fa-eye"></i> View
                                                       </button>
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
       <script src="../asset/vendor/jquery/jquery-3.3.1.min.js"></script>
       <script src="../asset/vendor/bootstrap/js/bootstrap.bundle.js"></script>
       <script src="../asset/vendor/custom-js/jquery.multi-select.html"></script>
       <script src="../asset/libs/js/main-js.js"></script>
       <script src="../asset/vendor/datatables/js/jquery.dataTables.min.js"></script>
       <script src="../asset/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
       <script src="../asset/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
       <script src="../asset/vendor/datatables/js/data-table.js"></script>
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
               $('#paymentModal').on('show.bs.modal', function(event) {
                   var button = $(event.relatedTarget); // Button that triggered the modal
                   var studentID = button.data('student-id');
                   var studentName = button.data('student-name');
                   var controlNo = button.data('control-no');
                   var documentName = button.data('document-name');
                   var totalAmount = button.data('total-amount');
                   var datePayment = button.data('date-payment');
                   var status = button.data('status');
                   var proofOfPayment = button.data('proof-of-payment'); // Path of the image

                   // Update the modal's content
                   var modal = $(this);
                   modal.find('#modal-student-id').text(studentID);
                   modal.find('#modal-student-name').text(studentName);
                   modal.find('#modal-control-no').text(controlNo);
                   modal.find('#modal-document-name').text(documentName);
                   modal.find('#modal-total-amount').text(totalAmount);
                   modal.find('#modal-date-payment').text(datePayment);
                   modal.find('#modal-status').text(status);

                   // Display the proof of payment image if available
                   if (proofOfPayment) {
                       modal.find('#modal-proof-of-payment').attr('src', proofOfPayment);
                       modal.find('#modal-proof-of-payment').data('large-image', proofOfPayment); // Store large image URL
                   } else {
                       modal.find('#modal-proof-of-payment').attr('src', 'path-to-default-image.jpg'); // Set default image if no proof available
                   }
               });

               // Show large image in another modal
               $('#largeImageModal').on('show.bs.modal', function() {
                   var largeImage = $('#modal-proof-of-payment').data('large-image'); // Get the large image URL
                   $(this).find('#large-proof-of-payment').attr('src', largeImage);
               });
           });
       </script>

       <!-- Payment Information Modal -->
       <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title">Payment Information</h5>
                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                   </div>
                   <div class="modal-body d-flex align-items-start"> <!-- Use align-items-start for top alignment -->
                       <div class="mr-2"> <!-- Text container -->
                           <p><strong>Student ID:</strong> <span id="modal-student-id"></span></p>
                           <p><strong>Student Name:</strong> <span id="modal-student-name"></span></p>
                           <p><strong>Control No:</strong> <span id="modal-control-no"></span></p>
                           <p><strong>Document Name:</strong> <span id="modal-document-name"></span></p>
                           <p><strong>Total Amount:</strong> <span id="modal-total-amount"></span></p>
                           <p><strong>Date of Payment:</strong> <span id="modal-date-payment"></span></p>
                           <p><strong>Status:</strong> <span id="modal-status"></span></p>
                           <p><strong>Proof of Payment:</strong></p>
                       </div>
                       <div class="image-container">
                           <img id="modal-proof-of-payment" class="img-fluid" src="" alt="Proof of Payment" data-toggle="modal" data-target="#largeImageModal">
                       </div>
                   </div>
               </div>
           </div>
       </div>

       <!-- Large Image Modal -->
       <div class="modal fade" id="largeImageModal" tabindex="-1" role="dialog">
           <div class="modal-dialog modal-fullscreen" role="document"> <!-- Added modal-fullscreen class for larger view -->
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title">Proof of Payment</h5>
                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                   </div>
                   <div class="modal-body">
                       <img id="large-proof-of-payment" src="" alt="Proof of Payment" class="img-fluid" style="width: 100%; height: auto;">
                   </div>
               </div>
           </div>
       </div>
       </body>

       </html>
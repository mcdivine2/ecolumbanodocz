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
        <!-- CSS for Layout -->
        <style>
            .form-group {
                margin-bottom: 20px;
            }

            .section-title {
                font-size: 16px;
                font-weight: bold;
                color: #1269AF;
                border-bottom: 1px solid #ddd;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }

            .card-body {
                padding: 20px;
            }

            .form-control {
                padding: 5px;
                font-size: 14px;
            }

            .btn-primary {
                background-color: #1269AF;
                border-color: #1269AF;
                color: white;
            }

            .row {
                margin-left: 0;
                margin-right: 0;
            }

            .row>.col-md-6 {
                padding-left: 15px;
                padding-right: 15px;
            }

            .text-right {
                text-align: right;
            }

            .form-check-input {
                display: inline-block !important;
                visibility: visible !important;
            }
        </style>

        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                <div class="card influencer-profile-data">
                    <div class="card-body">
                        <div id="message"></div>
                        <form id="validationform" name="docu_forms" data-parsley-validate="" novalidate="" method="POST">

                            <!-- Applicant's Information Section -->
                            <div class="form-group">
                                <h4 class="section-title">Applicant's Information</h4>
                                <div class="row">
                                    <div class="col-md-4">

                                        <?php
                                        $conn = new class_model();
                                        $getstudno = $conn->student_profile($student_id);
                                        ?>
                                        <label>Firstname</label>
                                        <input type="text" name="first_name" value="<?= $getstudno['first_name']; ?>" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Maiden Name</label>
                                        <input type="text" name="middle_name" value="<?= $getstudno['middle_name']; ?>" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Lastname</label>
                                        <input type="text" name="last_name" value="<?= $getstudno['last_name']; ?>" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label>Address</label>
                                        <input type="text" name="complete_address" value="<?= $getstudno['complete_address']; ?>" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Birthdate</label>
                                        <input type="text" name="birthdate" class="form-control" placeholder="dd/mm/yyyy">
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label>Course</label>
                                        <select data-parsley-type="alphanum" type="text" id="course" required="" placeholder="" class="form-control">
                                            <?php
                                            $conn = new class_model();
                                            $course = $conn->fetchAll_course();
                                            ?>
                                            <option value="">&larr;Select Course &rarr;</option>
                                            <?php foreach ($course as $row) { ?>
                                                <option value="<?= $row['course_name']; ?>"><?= $row['course_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Email Address</label>
                                        <input type="email" name="email_address" value="<?= $getstudno['email_address']; ?>" class="form-control" placeholder="">
                                    </div>
                                </div>

                                <!-- Control Number Section -->
                                <?php
                                function createRandomcnumber()
                                {
                                    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                                    srand((float)microtime() * 1000000);
                                    $i = 0;
                                    $control = '';
                                    while ($i <= 3) {
                                        $num = rand() % 33;
                                        $tmp = substr($chars, $num, 1);
                                        $control = $control . $tmp;
                                        $i++;
                                    }
                                    return $control;
                                }
                                $cNumber = 'CTRL-' . createRandomcnumber();
                                ?>
                                <div class="row mt-2">
                                    <input type="hidden" value="<?= $cNumber . '' . $_SESSION['student_id']; ?>" name="control_no" class="form-control" readonly>
                                    <div class="col-md-3">
                                        <label>Date Request:</label>
                                        <input type="text" name="date_request" class="form-control" value="<?= date('M d Y'); ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Request For Section -->
                            <div class="form-group mt-4">
                                <h4 class="section-title">Request For</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Select Document</label>
                                        <br>
                                        <?php
                                        // Fetch all documents from the database
                                        $conn = new class_model();
                                        $doc = $conn->fetchAll_document();
                                        if ($doc && count($doc) > 0) {
                                            foreach ($doc as $index => $document) {
                                                echo '<div class="form-check">';

                                                // Checkbox for selecting the document
                                                echo '<input class="form-check-input document-checkbox" type="checkbox" name="document_name[]" id="document_name' . ($index + 1) . '" value="' . $document['document_name'] . '" data-price="' . $document['price'] . '">';
                                                echo '<label class="form-check-label" for="document_name' . ($index + 1) . '">' . $document['document_name'] . ' (₱' . $document['price'] . ')</label>';

                                                // Hidden quantity input associated with the document
                                                echo '<div id="quantity' . ($index + 1) . '" class="mt-2" style="display:none;">';
                                                echo '<div class="d-flex align-items-center">';
                                                echo '<label for="no_ofcopies' . ($index + 1) . '" class="mr-2">Copies:</label>';
                                                echo '<input type="number" name="no_ofcopies[]" value="1" class="form-control no-of-copies" min="1" id="no_ofcopies' . ($index + 1) . '" style="width: 80px;">';
                                                echo '</div>';
                                                echo '</div>'; // Close quantity div

                                                // Hidden div for request type radio buttons
                                                echo '<div id="requestType' . ($index + 1) . '" class="mt-2" style="display:none;">';

                                                // Radio buttons for 1st request and re-issuance
                                                echo '<div class="form-check">';
                                                echo '<input class="form-check-input" type="radio" name="request_type_' . ($index + 1) . '" id="request_type1_' . ($index + 1) . '" value="1st request" required>';
                                                echo '<label class="form-check-label" for="request_type1_' . ($index + 1) . '">1st Request</label>';
                                                echo '</div>';

                                                echo '<div class="form-check">';
                                                echo '<input class="form-check-input" type="radio" name="request_type_' . ($index + 1) . '" id="request_type2_' . ($index + 1) . '" value="re-issuance" required>';
                                                echo '<label class="form-check-label" for="request_type2_' . ($index + 1) . '">Re-Issuance</label>';
                                                echo '</div>';

                                                echo '</div>'; // Close request type div

                                                echo '</div>'; // Close form-check div
                                            }
                                        } else {
                                            echo "No documents found.";
                                        }
                                        ?>


                                    </div>
                                </div>

                                <!-- Request Date and Mode -->
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label>Mode:</label>
                                        <select name="mode_request" id="mode_request" class="form-control" required>
                                            <option value="">&larr; Select Mode &rarr;</option>
                                            <option value="Pick Up">Pick-Up</option>
                                            <option value="Delivery">Delivery</option>
                                        </select>
                                        <label id="deliveryFeeSection" style="display:none;">Delivery Fee: ₱50</label>
                                        <p id="deliveryFee" class="form-control-static"></p>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Total Amount:</label>
                                        <input type="text" name="price" id="totalAmount" class="form-control" placeholder="₱0" value="" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Purpose Section -->
                            <div class="form-group mt-4">
                                <h4 class="section-title">Purpose</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Select Purpose</label><br>
                                        <input type="checkbox" name="purpose[]" value="Evaluation"> Evaluation <br>
                                        <input type="checkbox" name="purpose[]" value="Employment"> Employment <br>
                                        <input type="checkbox" id="otherPurposeCheckbox" value="Other"> Other (specify) <br>
                                    </div>
                                </div>
                                <!-- Hidden input for "Other" -->
                                <div class="col-lg-5">
                                    <input type="text" id="otherPurposeInput" name="purpose[]" placeholder="Enter purpose" style="display:none;">
                                </div>
                            </div>

                            <!-- Submission Section -->
                            <div class="form-group mt-4 text-right">
                                <input type="hidden" name="student_id" value="<?= $_SESSION['student_id']; ?>" class="form-control">
                                <button type="button" id="submitForm" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Payment Details Modal (add this at the bottom of your main PHP file) -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Payment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Student Name: </strong> <span id="modalStudentName"></span></p>
                        <p><strong>Control No.: </strong> <span id="modalControlNo"></span></p>
                        <p><strong>Document Name: </strong> <span id="modalDocumentName"></span></p>
                        <p><strong>Mode: </strong> <span id="modalMode"></span></p>
                        <p><strong>Total Amount: </strong> <span id="modalTotalAmount"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="confirmSubmit" class="btn btn-primary">Confirm</button>
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
                let formData = null;
                const deliveryFee = 50;

                // Toggle visibility of quantity input and request type when checkbox is checked/unchecked
                $('input[name="document_name[]"]').change(function() {
                    const docIndex = this.id.replace('document_name', ''); // Get the document index
                    const qtyDiv = `#quantity${docIndex}`; // Quantity div
                    const requestTypeDiv = `#requestType${docIndex}`; // Request type div

                    if (this.checked) {
                        $(qtyDiv).show();
                        $(requestTypeDiv).show();
                    } else {
                        $(qtyDiv).hide().find('input').val(''); // Hide and clear quantity input
                        $(requestTypeDiv).hide(); // Hide request type div
                        $(`input[name="request_type_${docIndex}"]`).prop('checked', false); // Uncheck request type radio buttons
                    }

                    calculateTotal(); // Recalculate total
                });

                // Toggle other purpose input visibility
                $('#otherPurposeCheckbox').change(function() {
                    $('#otherPurposeInput').toggle(this.checked).val('');
                });

                // Show/hide delivery fee section and recalculate total
                $('#mode_request').change(function() {
                    $('#deliveryFeeSection').toggle($(this).val() === 'Delivery');
                    calculateTotal();
                });

                // Calculate total amount
                function calculateTotal() {
                    let total = $('input[name="document_name[]"]:checked').get().reduce((sum, doc) => {
                        const copies = +$(doc).closest('.form-check').find('input[name="no_ofcopies[]"]').val() || 1;
                        return sum + parseFloat($(doc).data('price')) * copies;
                    }, 0);

                    if ($('#mode_request').val() === 'Delivery') total += deliveryFee;
                    $('input[name="price"]').val(total.toFixed(2));
                    return total;
                }

                // Form submission logic
                $('#submitForm').click(function(e) {
                    e.preventDefault();
                    formData = new FormData($('form[name="docu_forms"]')[0]);

                    const selectedDocs = $('input[name="document_name[]"]:checked');
                    if (!selectedDocs.length) return showError('Please select at least one document.');
                    if (!$('#course').val()) return showError('Please select a course.');

                    formData.delete('document_name[]');
                    formData.delete('no_ofcopies[]');
                    formData.delete('request_type[]');

                    let formattedDocuments = [];

                    selectedDocs.each(function(index) {
                        const docIndex = this.id.replace('document_name', ''); // Get the index for each selected document

                        // Get document name and number of copies
                        const docName = this.value;
                        const copies = $(this).closest('.form-check').find('input[name="no_ofcopies[]"]').val() || 1;

                        // Get request type for this document, matching the unique index
                        const requestType = $(`input[name="request_type_${docIndex}"]:checked`).val();
                        if (!requestType) {
                            return showError(`Please select a request type for document ${docName}.`);
                        }

                        // Collect document name and request type separately
                        formData.append('document_name[]', docName); // Append document name
                        formData.append('no_ofcopies[]', copies); // Append number of copies
                        formData.append('request_type[]', requestType); // Append request type separately

                        // Format the document string for display in the modal
                        formattedDocuments.push(`${index + 1}. ${docName} (x${copies}), ${requestType}`);
                    });

                    const total = calculateTotal();
                    formData.append('price', total);
                    formData.append('course', $('#course').val());

                    // Populate and show the modal
                    $('#modalStudentName').text(`${getField('first_name')} ${getField('middle_name')} ${getField('last_name')}`);
                    $('#modalControlNo').text(getField('control_no'));
                    $('#modalDocumentName').html(formattedDocuments.join('<br>')); // Display formatted document list
                    $('#modalMode').text($('#mode_request').val());
                    $('#modalTotalAmount').text(`₱${total.toFixed(2)}`);
                    $('#paymentModal').modal('show');
                });

                $('#confirmSubmit').click(function() {
                    if (formData) {
                        $.ajax({
                            url: '../init/controllers/add_request.php',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success(response) {
                                $('#message').html(response);
                                $('#paymentModal').modal('hide');
                                window.scrollTo(0, 0);
                            },
                            error() {
                                console.error('Failed to submit the form.');
                            }
                        });
                    }
                });

                function getField(name) {
                    return $(`input[name="${name}"]`).val();
                }

                function showError(msg) {
                    $('#message').html(`<div class="alert alert-danger">${msg}</div>`);
                    setTimeout(() => $('#message').empty(), 3000); // Auto-hide error message after 3 seconds
                }

                $('.btn-secondary').click(function() {
                    $('#paymentModal').modal('hide');
                });
            });



            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    Array.prototype.filter.call(forms, function(form) {
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
            print_r($_POST); // This will help you inspect the incoming data
            exit;
        </script>


        </body>

        </html>
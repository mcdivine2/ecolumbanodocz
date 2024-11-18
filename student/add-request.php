<?php include('main_header/header.php'); ?>
<?php include('left_sidebar/sidebar.php'); ?>

<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">

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
                                        <input type="date" name="birthdate" class="form-control" placeholder="dd/mm/yyyy">
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label>Course</label>
                                        <select name="course" data-parsley-type="alphanum" id="course" required class="form-control">
                                            <option value="">&larr; Select Course &rarr;</option>
                                            <?php
                                            $conn = new class_model();
                                            $course = $conn->fetchAll_course();
                                            foreach ($course as $row) {
                                                echo '<option value="' . $row['course_name'] . '">' . $row['course_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Email Address</label>
                                        <input type="email" name="email_address" value="<?= $getstudno['email_address']; ?>" class="form-control">
                                    </div>
                                </div>

                                <!-- Control Number Section -->
                                <?php
                                function createRandomcnumber()
                                {
                                    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                                    $control = '';
                                    for ($i = 0; $i < 4; $i++) {
                                        $control .= $chars[rand(0, strlen($chars) - 1)];
                                    }
                                    return $control;
                                }
                                $cNumber = 'CTRL-' . createRandomcnumber();
                                ?>
                                <div class="row mt-2">
                                    <input type="hidden" name="control_no" value="<?= $cNumber . $_SESSION['student_id']; ?>" readonly>
                                </div>
                            </div>

                            <!-- Request For Section -->
                            <div class="form-group mt-4">
                                <h4 class="section-title">Request For</h4>
                                <div id="requestContainer">
                                    <!-- First Row (Default) -->
                                    <div class="row request-row" style="margin-bottom: 20px; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                        <div class="col-md-4" style="margin-bottom: 10px;">
                                            <label style="font-weight: bold;">Select Document:</label>
                                            <select name="document_name[]" class="form-control document-select" required style="border: 2px solid #007bff; border-radius: 5px; padding: 5px;">
                                                <option value="" disabled selected>&larr; Select Document &rarr;</option>
                                                <?php
                                                $conn = new class_model();
                                                $documents = $conn->fetchAll_document();
                                                if ($documents && count($documents) > 0) {
                                                    foreach ($documents as $doc) {
                                                        echo '<option value="' . $doc['document_name'] . '" data-price="' . $doc['price'] . '">' . $doc['document_name'] . ' (₱' . $doc['price'] . ')</option>';
                                                    }
                                                } else {
                                                    echo '<option value="">No documents available</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2" style="margin-bottom: 10px;">
                                            <label style="font-weight: bold;">Copies:</label>
                                            <input type="number" name="copies[]" class="form-control copies-input" min="1" value="1" required disabled style="border: 2px solid #007bff; border-radius: 5px; padding: 5px;">
                                        </div>
                                        <div class="col-md-4" style="margin-bottom: 10px;">
                                            <label style="font-weight: bold;">Request Type:</label>
                                            <div class="request-type-options d-flex" style="display: none; gap: 15px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="request_type_0" value="1st request" disabled>
                                                    <label class="form-check-label" style="font-size: 14px;">1st Request</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="request_type_0" value="re-issuance" disabled>
                                                    <label class="form-check-label" style="font-size: 14px;">Re-Issuance</label>
                                                </div>
                                                <button type="button" class="btn btn-danger btn-sm cancel-row-btn" style="margin-left: 15px;">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Amount -->
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label style="font-weight: bold;">Total Amount:</label>
                                        <input type="text" name="total_price" id="totalPrice" class="form-control" value="₱0" readonly style="border: 2px solid #007bff; border-radius: 5px; padding: 5px; font-size: 16px;">
                                    </div>
                                </div>


                                <!-- Add New Row Button -->
                                <div class="text-right" style="margin-top: 10px;">
                                    <button type="button" id="addRowBtn" class="btn btn-success" style="background-color: #28a745; border-color: #28a745; border-radius: 5px; padding: 10px 20px; font-size: 16px;"
                                        <?php echo (empty($documents) ? 'disabled' : ''); ?>>
                                        Add Another Document
                                    </button>
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
                        <p><strong>Total Amount: </strong> <span id="modalTotalAmount"></span></p>

                        <!-- Image Preview Section -->
                        <div id="imagePreviewContainer" style="display:none; margin-top: 15px;">
                            <h5>Image Preview:</h5>
                            <img id="imagePreview" src="" alt="Image Preview" style="max-width: 100%; max-height: 200px;" />
                        </div>
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
                const requestContainer = $('#requestContainer');
                const addRowBtn = $('#addRowBtn');
                const totalPriceField = $('#totalPrice');

                const deliveryFee = 50; // Adjust if needed

                // Function to calculate the total amount dynamically
                function updateTotalPrice() {
                    let total = 0;
                    requestContainer.find('.request-row').each(function() {
                        const documentSelect = $(this).find('.document-select');
                        const copiesInput = $(this).find('.copies-input');
                        const price = parseFloat(documentSelect.find(':selected').data('price')) || 0;
                        const copies = parseInt(copiesInput.val()) || 1;

                        if (documentSelect.val()) {
                            total += price * copies;
                        }
                    });

                    // Add delivery fee if delivery mode is selected
                    if ($('#mode_request').val() === 'Delivery') {
                        total += deliveryFee;
                    }

                    totalPriceField.val(`₱${total.toFixed(2)}`);
                }

                // Function to get selected document names
                function getSelectedDocuments() {
                    const selected = [];
                    requestContainer.find('.document-select').each(function() {
                        if ($(this).val()) {
                            selected.push($(this).val());
                        }
                    });
                    return selected;
                }

                // Function to update dropdown options and check if Add Row button should be enabled
                function updateDropdownOptionsAndButton() {
                    const selectedDocuments = getSelectedDocuments();
                    let availableOptions = 0;

                    requestContainer.find('.document-select').each(function() {
                        const currentSelect = $(this);
                        const currentValue = currentSelect.val();

                        currentSelect.find('option').each(function() {
                            const optionValue = $(this).val();
                            if (selectedDocuments.includes(optionValue) && optionValue !== currentValue) {
                                $(this).hide();
                            } else {
                                $(this).show();
                            }
                        });

                        // Count remaining available options
                        availableOptions += currentSelect.find('option:visible').not('[value=""]').length;
                    });

                    // Disable Add Row button if no more options are available
                    const allFieldsComplete = checkLastRowCompleteness();
                    addRowBtn.prop('disabled', availableOptions === selectedDocuments.length || !allFieldsComplete);
                }

                // Function to check if all fields in the last row are filled
                function checkLastRowCompleteness() {
                    const lastRow = requestContainer.find('.request-row:last');
                    const documentSelect = lastRow.find('.document-select');
                    const copiesInput = lastRow.find('.copies-input');
                    const requestTypeRadios = lastRow.find('input[name^="request_type"]:checked');

                    return documentSelect.val() && copiesInput.val() && requestTypeRadios.length > 0;
                }

                // Event listener for document selection
                requestContainer.on('change', '.document-select', function() {
                    const parentRow = $(this).closest('.request-row');
                    const copiesInput = parentRow.find('.copies-input');
                    const requestTypeOptions = parentRow.find('.request-type-options');

                    if ($(this).val()) {
                        copiesInput.prop('disabled', false);
                        requestTypeOptions.show();
                        requestTypeOptions.find('input').prop('disabled', false);
                    } else {
                        copiesInput.prop('disabled', true).val(1);
                        requestTypeOptions.hide();
                        requestTypeOptions.find('input').prop('checked', false);
                    }

                    updateTotalPrice();
                    updateDropdownOptionsAndButton();
                });

                // Event listener for copies input
                requestContainer.on('input', '.copies-input', function() {
                    updateTotalPrice();
                    updateDropdownOptionsAndButton();
                });

                // Event listener for request type selection
                requestContainer.on('change', 'input[name^="request_type"]', function() {
                    updateDropdownOptionsAndButton();
                });

                // Event listener for cancel button
                requestContainer.on('click', '.cancel-row-btn', function() {
                    const parentRow = $(this).closest('.request-row');
                    parentRow.remove(); // Remove the row
                    updateTotalPrice();
                    updateDropdownOptionsAndButton();
                });

                // Event listener for "Add Another Document" button
                addRowBtn.on('click', function() {
                    const newRow = $('.request-row:first').clone();
                    const newIndex = requestContainer.children().length;

                    newRow.find('.document-select').val('');
                    newRow.find('.copies-input').val(1).prop('disabled', true);
                    newRow.find('.request-type-options').hide().find('input').prop('checked', false).prop('disabled', true);

                    // Update radio button names for the new row
                    newRow.find('input[name^="request_type"]').each(function() {
                        const name = `request_type_${newIndex}`;
                        $(this).attr('name', name);
                    });

                    requestContainer.append(newRow);
                    updateDropdownOptionsAndButton();
                });

                // Event listener for mode of request
                $('#mode_request').on('change', function() {
                    $('#deliveryFeeSection').toggle($(this).val() === 'Delivery');
                    updateTotalPrice();
                });

                // Initial setup
                updateTotalPrice();
                updateDropdownOptionsAndButton();

                $(document).ready(function() {
                    $('#submitForm').on('click', function(e) {
                        e.preventDefault(); // Prevent default form submission

                        // Collect form data
                        const formData = new FormData($('#validationform')[0]);
                        const course = $('select[name="course"]').val();

                        if (!course) {
                            $('#message').html('<div class="alert alert-danger">Please select a course!</div>');
                            window.scrollTo(0, 0);
                            return;
                        }

                        // Validate required fields
                        const controlNo = $('input[name="control_no"]').val();
                        const totalAmount = $('input[name="total_price"]').val();
                        const studentId = $('input[name="student_id"]').val();
                        const birthdate = $('input[name="birthdate"]').val();
                        const email = $('input[name="email_address"]').val();

                        // Collect document names and validate
                        const documentNames = [];
                        $('.document-select').each(function() {
                            const selectedValue = $(this).val();
                            if (selectedValue) {
                                documentNames.push(selectedValue);
                            }
                        });

                        if (
                            !controlNo ||
                            !totalAmount ||
                            !studentId ||
                            !birthdate ||
                            !email ||
                            documentNames.length === 0
                        ) {
                            $('#message').html('<div class="alert alert-danger">All fields are required, including at least one document!</div>');
                            window.scrollTo(0, 0);
                            return;
                        }

                        // Make AJAX request
                        // Make AJAX request
                        $.ajax({
                            url: '../init/controllers/add_request.php', // Update this to your server-side script
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            cache: false,
                            async: false,
                            beforeSend: function() {
                                // Show a loading message while the request is processing
                                $('#message').html('<div class="alert alert-info">Submitting your request, please wait...</div>');
                                window.scrollTo(0, 0);
                            },
                            success: function(response) {
                                // Check for a "success" keyword in the response
                                if (response.includes('success')) {
                                    $('#message').html('<div class="alert alert-success">Your request has been successfully submitted! Redirecting to the dashboard...</div>');
                                    window.scrollTo(0, 0);
                                    setTimeout(function() {
                                        window.location.href = 'index.php'; // Redirect after a short delay
                                    }, 3000); // 3-second delay before redirect
                                } else {
                                    // Handle other responses (e.g., validation errors)
                                    $('#message').html('<div class="alert alert-warning">There was an issue with your submission: ' + response + '</div>');
                                    window.scrollTo(0, 0);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX request failed: ' + status + ', ' + error);
                                $('#message').html('<div class="alert alert-danger">An unexpected error occurred. Please try again later.</div>');
                                window.scrollTo(0, 0);
                            }
                        });

                    });
                });


            });

            function showSpecifyInput(index) {
                // Toggle visibility of the "Other" input when "Other (please specify)" radio button is selected
                const specifyInput = $(`#other_specify${index}`);
                specifyInput.toggle(); // Show or hide the input
            }
        </script>


        </body>

        </html>
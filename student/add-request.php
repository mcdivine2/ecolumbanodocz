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
                                        <input type="hidden" name="studentID_no" value="<?= $getstudno['studentID_no']; ?>" class="form-control">
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
                                        <label>Civil Status</label>
                                        <select name="civil_status" class="form-control" required>
                                            <option value="" disabled selected>&larr; Select Civil Status &rarr;</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Widow">Widow</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label>Course</label>
                                        
                                        <select name="course" id="course" class="form-control"  required>
                                            <option value="" disabled selected>&larr; Select Course &rarr;</option>
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
                                <script>
                                    document.getElementById('courseSearch').addEventListener('input', function() {
                                        const searchValue = this.value.toLowerCase();
                                        const courseDropdown = document.getElementById('courseDropdown');
                                        const options = courseDropdown.getElementsByTagName('option');

                                        for (let i = 0; i < options.length; i++) {
                                            const optionText = options[i].textContent.toLowerCase();
                                            if (optionText.includes(searchValue) || options[i].value === "") {
                                                options[i].style.display = "";
                                            } else {
                                                options[i].style.display = "none";
                                            }
                                        }
                                    });

                                    // Automatically select the option when clicked or when the user types and presses Enter
                                    document.getElementById('courseDropdown').addEventListener('change', function() {
                                        const selectedOption = this.options[this.selectedIndex].text;
                                        document.getElementById('courseSearch').value = selectedOption;
                                    });
                                </script>

                                <div class="row mt-2">
                                    
                                    <div class="col-md-6">
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
                                        <input type="hidden" name="control_no" value="<?= $cNumber . $_SESSION['student_id']; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>


                            <!-- Request For Section -->
                            <div class="form-group mt-4">
                                <h4 class="section-title">Request For</h4>
                                <div id="requestContainer">
                                    <!-- First Row (Default) -->
                                    <div class="row request-row" style="margin-bottom: 20px; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                        <!-- Document Selection -->
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
                                    <input type="text" id="docsPurposeInput" name="purpose[]" placeholder="Enter purpose" style="display:none;">
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
                const totalPriceField = $('#totalPrice');
                const deliveryFee = 50; // Example delivery fee

                // Function to reset the default row
                function resetDefaultRow(parentRow) {
                    parentRow.find('.document-select').val(''); // Reset document selection
                    parentRow.find('.copies-input').val(1).prop('disabled', true); // Reset and disable copies input
                    parentRow.find('.request-type-options').hide().find('input').prop('checked', false).prop('disabled', true); // Reset request type options
                    parentRow.find('.additional-inputs').remove(); // Remove any additional dynamic inputs
                }

                // Toggle "Other (specify)" input field for Certification Type
                $('input[name="certification_type"]').on('change', function() {
                    const certOtherInput = $('#certOtherInput');
                    if ($(this).val() === 'Other') {
                        certOtherInput.show().prop('required', true); // Show and make required
                    } else {
                        certOtherInput.hide().val('').prop('required', false); // Hide and reset
                    }
                });

                // Event listener for document selection change
                requestContainer.on('change', '.document-select', function() {
                    const parentRow = $(this).closest('.request-row');
                    const copiesInput = parentRow.find('.copies-input');
                    const requestTypeOptions = parentRow.find('.request-type-options');

                    if ($(this).val()) {
                        // Enable copies input and show request type options
                        copiesInput.prop('disabled', false);
                        requestTypeOptions.show().find('input').prop('disabled', false);
                    } else {
                        // Disable and reset fields if no document is selected
                        copiesInput.prop('disabled', true).val(1);
                        requestTypeOptions.hide().find('input').prop('checked', false).prop('disabled', true);
                    }

                    updateTotalPrice();
                });

                // Event listener for request type radio button change
                requestContainer.on('change', 'input[type="radio"]', function() {
                    updateTotalPrice();
                });

                // Event listener for changes in the copies input
                requestContainer.on('input', '.copies-input', function() {
                    updateTotalPrice();
                });

                // Add new document row
                $('#addRowBtn').on('click', function() {
                    const newRow = $('.request-row:first').clone();
                    newRow.find('.document-select').val('');
                    newRow.find('.copies-input').val(1).prop('disabled', true);
                    newRow.find('.request-type-options').hide().find('input').prop('checked', false).prop('disabled', true);
                    newRow.find('.additional-inputs').remove();
                    requestContainer.append(newRow);
                });

                // Cancel button to remove rows
                requestContainer.on('click', '.cancel-row-btn', function() {
                    $(this).closest('.request-row').remove();
                    updateTotalPrice();
                });

                // Toggle "Other (specify)" input field for purpose
                $('#otherPurposeCheckbox').on('change', function() {
                    const docsPurposeInput = $('#docsPurposeInput');
                    if ($(this).is(':checked')) {
                        docsPurposeInput.show().prop('required', true);
                    } else {
                        docsPurposeInput.hide().val('').prop('required', false);
                    }
                });

                // Function to calculate the total amount dynamically
                function updateTotalPrice() {
                    let total = 0;

                    requestContainer.find('.request-row').each(function() {
                        const documentSelect = $(this).find('.document-select');
                        const copiesInput = $(this).find('.copies-input');
                        const requestType = $(this).find('input[type="radio"]:checked').val(); // Selected request type
                        const price = parseFloat(documentSelect.find(':selected').data('price')) || 0;
                        const copies = parseInt(copiesInput.val()) || 1;

                        if (documentSelect.val()) {
                            if (requestType === '1st request' && copies > 1) {
                                // First copy is free, charge for additional copies
                                total += price * (copies - 1);
                            } else if (requestType !== '1st request') {
                                // Charge for all copies if not 1st Request
                                total += price * copies;
                            }
                        }
                    });

                    if ($('#mode_request').val() === 'Delivery') {
                        total += deliveryFee; // Add delivery fee if applicable
                    }

                    totalPriceField.val(`₱${total.toFixed(2)}`);
                }

                // Initial setup
                updateTotalPrice();

                // Function to handle dynamic inputs for specific documents
                function handleDynamicInputs(documentName, parentRow) {
                    // Remove any existing dynamic inputs
                    parentRow.find('.additional-inputs').remove();

                    const createInputField = (label, name, type, value = '', options = []) => {
                        let inputHTML = `
                            <label style="font-weight: bold; font-size: 14px;">${label}:</label>
                            ${type === 'radio' ? options.map(option => `
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="${name}" value="${option}" required>
                                    <label class="form-check-label" style="font-size: 13px;">${option}</label>
                                </div>
                            `).join('') : `<input type="${type}" name="${name}" class="form-control" value="${value}" required style="border: 2px solid #007bff; border-radius: 5px; padding: 5px; width: 100%;">`}
                        `;
                        return inputHTML;
                    };

                    let additionalInputs = '';
                    if (['Special Order', 'Diploma', 'Transcript of Records', 'Certification'].includes(documentName)) {
                        const copiesField = createInputField('Copies', 'copies[]', 'number', 1);
                        const cancelButton = `<button type="button" class="btn btn-danger btn-sm cancel-row-btn" style="width: 100%;">Cancel</button>`;
                        const docNameField = `<p style="font-size: 14px; margin: 0;">${documentName}</p>`;
                        let requestTypeField = '';
                        let extraFields = '';

                        if (documentName === 'Special Order' || documentName === 'Diploma') {
                            requestTypeField = createInputField('Request Type', `${documentName[0]}request_type`, 'radio', '', ['1st request', 'Re-Issuance']);
                        } else if (documentName === 'Transcript of Records') {
                            requestTypeField = createInputField('Request Type', 'TOR_request_type', 'radio', '', ['1st request', 'Re-Issuance']);
                            extraFields = `
                                ${createInputField('Purpose', 'TORpurpose', 'radio', '', ['Evaluation', 'Employment', 'CBE BOARD EXAM', 'Other'])}
                                <input type="text" id="otherPurposeInput" name="TORpurpose" placeholder="Specify here" class="form-control" style="display:none; margin-top: 10px; font-size: 13px; padding: 5px; width: 100%;">
                                <input type="file" name="photo_attachment[]" accept="image/*" class="form-control-file" style="display: none; margin-top: 10px;">
                            `;
                        } else if (documentName === 'Certification') {
                            requestTypeField = createInputField('Certification Type', 'certification_type', 'radio', '', ['Unit Earned', 'As Graduate', 'Other']);
                            extraFields = `<input type="text" id="certOtherInput" name="certification_type_other" placeholder="Please specify" class="form-control" style="margin-top: 10px; display: none;">`;
                        }

                        additionalInputs = `
                            <div class="additional-inputs" style="margin-top: 15px; border-top: 1px solid #ddd; padding-top: 15px;">
                                <div class="responsive-row" style="display: flex; flex-wrap: wrap; align-items: center; gap: 15px;">
                                    <div style="flex: 1; min-width: 150px;">
                                        <label style="font-weight: bold; font-size: 14px;">Document Name:</label>
                                        ${docNameField}
                                    </div>
                                    <div style="flex: 1; min-width: 120px;">
                                        ${copiesField}
                                    </div>
                                    <div style="flex: 2; min-width: 250px;">
                                        ${requestTypeField}
                                    </div>
                                    <div style="flex: 0; min-width: 100px; text-align: center;">
                                        ${cancelButton}
                                    </div>
                                    ${extraFields}
                                </div>
                            </div>
                        `;
                    }

                    parentRow.append(additionalInputs);

                    // Event listeners for dynamic input changes
                    if (documentName === 'Transcript of Records') {
                        parentRow.on('change', 'input[name="TORpurpose"]', function () {
                            const otherPurposeInput = parentRow.find('#otherPurposeInput');
                            const photoAttachmentInput = parentRow.find('input[name="photo_attachment[]"]');
                            const value = $(this).val();

                            // Show/hide and set required attribute for "Other Purpose" input
                            if (value === 'Other') {
                                otherPurposeInput.show().prop('required', true);
                            } else {
                                otherPurposeInput.hide().val('').prop('required', false);
                            }

                            // Show/hide and set required attribute for "CBE BOARD EXAM" photo attachment
                            if (value === 'CBE BOARD EXAM') {
                                photoAttachmentInput.show().prop('required', true);
                            } else {
                                photoAttachmentInput.hide().val('').prop('required', false);
                            }
                        });
                    }


                    if (documentName === 'Certification') {
                        parentRow.on('change', 'input[name="certification_type"]', function () {
                            const certOtherInput = parentRow.find('#certOtherInput');
                            certOtherInput.toggle($(this).val() === 'Other').prop('required', $(this).val() === 'Other');
                        });
                    }
                }

                $('input[name="certification_type"]').on('change', function() {
                    if ($(this).val() === 'Other') {
                        $('#certOtherInput').show().prop('required', true); // Show the input field and make it required
                    } else {
                        $('#certOtherInput').hide().val('').prop('required', false); // Hide and reset the input field
                    }
                });

                requestContainer.on('change', '.document-select', function() {
                    const parentRow = $(this).closest('.request-row');
                    const copiesInput = parentRow.find('.copies-input');
                    const requestTypeOptions = parentRow.find('.request-type-options');

                    const selectedValue = $(this).val();

                    if (selectedValue) {
                        // Enable copies input
                        copiesInput.prop('disabled', false);

                        // Show and enable request type options
                        requestTypeOptions.show();
                        requestTypeOptions.find('input').prop('disabled', false);

                        // Handle dynamic inputs for specific documents
                        handleDynamicInputs(selectedValue, parentRow);
                    } else {
                        // Disable and reset fields if no document is selected
                        copiesInput.prop('disabled', true).val(1);
                        requestTypeOptions.hide();
                        requestTypeOptions.find('input').prop('checked', false).prop('disabled', true);

                        // Remove dynamic inputs if any
                        parentRow.find('.additional-inputs').remove();
                    }

                    updateTotalPrice();
                    updateDropdownOptionsAndButton();
                });
                // Event listener for cancel button
                requestContainer.on('click', '.cancel-row-btn', function() {
                    const parentRow = $(this).closest('.request-row');
                    parentRow.remove(); // Remove the row
                    updateTotalPrice(); // Update the total price after removing the row
                    updateDropdownOptionsAndButton(); // Refresh dropdown and button states
                });
                docsPurposeInput
                // Toggle "Other (specify)" input field
                $('#otherPurposeCheckbox').on('change', function() {
                    if ($(this).is(':checked')) {
                        // Show the "Other (specify)" input and make it required
                        $('#docsPurposeInput').show().prop('required', true);
                    } else {
                        // Hide the "Other (specify)" input, clear its value, and make it not required
                        $('#docsPurposeInput').hide().val('').prop('required', false);
                    }
                });

                // Event listener for "Add Another Document" button
                addRowBtn.on('click', function() {
                    const newRow = $('.request-row:first').clone();
                    newRow.find('.document-select').val('');
                    newRow.find('.copies-input').val(1).prop('disabled', true);
                    newRow.find('.request-type-options').hide().find('input').prop('checked', false).prop('disabled', true);
                    newRow.find('.additional-inputs').remove();
                    requestContainer.append(newRow);
                });

                // Initial setup
                updateTotalPrice();
            });
            
        </script>

        <script>
            $(document).on('click', '#submitForm', function(e) {
                e.preventDefault();

                let formData = new FormData();
                formData.append('studentID_no', $('input[name="studentID_no"]').val());
                formData.append('first_name', $('input[name="first_name"]').val());
                formData.append('middle_name', $('input[name="middle_name"]').val());
                formData.append('last_name', $('input[name="last_name"]').val());
                formData.append('complete_address', $('input[name="complete_address"]').val());
                formData.append('course', $('select[name="course"]').val());
                formData.append('civil_status', $('select[name="civil_status"]').val());
                formData.append('email_address', $('input[name="email_address"]').val());
                formData.append('control_no', $('input[name="control_no"]').val());
                formData.append('student_id', $('input[name="student_id"]').val());
                formData.append('total_price', $('#totalPrice').val());

                // Collect documents
                $('.request-row').each(function() {
                    const documentName = $(this).find('select[name="document_name[]"]').val();
                    const requestType = $(this).find('input[type="radio"]:checked').val();
                    const copies = $(this).find('input[name="copies[]"]').val();

                    if (documentName && requestType && copies) {
                        formData.append('document_name[]', documentName);
                        formData.append('request_type[]', requestType);
                        formData.append('copies[]', copies);
                    }
                });


                if (!formData.has('civil_status')) {
                    const civilStatus = $('select[name="civil_status"]').val();
                    if (!civilStatus) {
                        alert("Please select your civil status.");
                        return; // Stop submission if not selected
                    }
                    formData.append('civil_status', civilStatus);
                }

                // Debugging output
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }
                // Collect purposes
                $('input[name="purpose[]"]:checked').each(function() {
                    formData.append('purpose[]', $(this).val());
                });

                // Handle file uploads
                $('input[name="photo_attachment[]"]').each(function() {
                    if ($(this)[0].files[0]) {
                        formData.append('photo_attachment[]', $(this)[0].files[0]);
                    }
                });

                $.ajax({
                    url: '../init/controllers/add_request.php',
                    type: 'POST',
                    data: formData,
                    processData: false, // Required for FormData
                    contentType: false, // Required for FormData
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            $('#message').html('<div class="alert alert-success">' + res.message + '</div>');
                            window.scrollTo(0, 0)
                            setTimeout(() => window.location.reload(), 4000);
                        } else {
                            window.scrollTo(0, 0)
                            $('#message').html('<div class="alert alert-danger">' + (res.errors ? res.errors.join('<br>') : 'An error occurred.') + '</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        $('#message').html('<div class="alert alert-danger">An unexpected error occurred.</div>');
                    },
                });
            });
        </script>
        </body>

        </html>
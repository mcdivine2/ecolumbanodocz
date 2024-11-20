<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<?php include('documents/main_header/header.php'); ?>
<!-- ============================================================== -->
<!-- end navbar -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- left sidebar -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- end left sidebar -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->

<div class="container-fluid  dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">


                <div class="page-breadcrumb">

                </div>
            </div>
        </div>
    </div>

    <style>
        html,
        body {
            height: 100%;
            min-height: 125%;
            background: linear-gradient(0deg, rgba(2, 115, 1), rgba(24, 44, 25, 0.5)), url("assets/images/scc-bg2.png");
            background-size: cover;


        }

        body {

            justify-content: flex-start;
            align-items: flex-start;
            padding-bottom: 40px;
        }

    </style>
    <!-- ============================================================== -->
    <!-- end pageheader -->
    <!-- ============================================================== -->
    <?php
    $conn = new class_model();

    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10 col-md-10 col-sm-12">
                <div class="card influencer-profile-data">
                    <div class="card-body">
                        <h2 class="pageheader-title text-center">
                            <i class="fa fa-fw fa-user-graduate"></i><strong> Registration Form </strong>
                        </h2>
                        <div class="" id="message"></div>

                        <!-- Parsley validation -->
                        <form id="validationform" name="student_form" data-parsley-validate novalidate method="POST" enctype="multipart/form-data">

                            <!-- First Row: EDP Number and First Name -->
                            <div class="form-row">
                                <!-- EDP Number -->
                                <div class="form-group col-md-6">
                                    <label for="studentID_no"><i class="fa fa-id-card"></i> EDP Number</label>
                                    <input type="text" name="studentID_no" class="form-control" placeholder="Enter EDP Number (Optional)">
                                </div>

                                <!-- First Name -->
                                <div class="form-group col-md-6">
                                    <label for="first_name"><i class="fa fa-user"></i> First Name</label>
                                    <input type="text" name="first_name" class="form-control" required data-parsley-required-message="First name is required" placeholder="Enter your first name">
                                </div>
                            </div>

                            <!-- Second Row: Middle Name and Last Name -->
                            <div class="form-row">
                                <!-- Middle Name -->
                                <div class="form-group col-md-6">
                                    <label for="middle_name"><i class="fa fa-user"></i> Maiden Name</label>
                                    <input type="text" name="middle_name" class="form-control" required data-parsley-required-message="Maiden name is required" placeholder="Enter your middle name">
                                </div>

                                <!-- Last Name -->
                                <div class="form-group col-md-6">
                                    <label for="last_name"><i class="fa fa-user"></i> Last Name</label>
                                    <input type="text" name="last_name" class="form-control" required data-parsley-required-message="Last name is required" placeholder="Enter your last name">
                                </div>
                            </div>

                            <!-- Third Row: Complete Address -->
                            <div class="form-group">
                                <label for="complete_address"><i class="fa fa-map-marker-alt"></i> Complete Address</label>
                                <textarea name="complete_address" rows="2" class="form-control" required data-parsley-required-message="Address is required" placeholder="Enter your complete address"></textarea>
                            </div>

                            <!-- Fourth Row: Email Address and Mobile Number -->
                            <div class="form-row">
                                <!-- Email Address -->
                                <div class="form-group col-md-6">
                                    <label for="email_address"><i class="fa fa-envelope"></i> Email Address</label>
                                    <input type="email" name="email_address" class="form-control" required data-parsley-type="email" data-parsley-required-message="Valid email is required" placeholder="Enter your email address">
                                </div>

                                <!-- Mobile Number -->
                                <div class="form-group col-md-6">
                                    <label for="mobile_number"><i class="fa fa-phone"></i> Mobile Number</label>
                                    <input type="text" name="mobile_number" class="form-control" required minlength="11" maxlength="11" data-parsley-required-message="Mobile number is required" placeholder="Enter your mobile number">
                                </div>
                            </div>

                            <!-- Fifth Row: Upload Valid ID -->
                            <div class="form-group">
                                <label for="id_upload"><i class="fa fa-id-badge"></i> Upload Valid ID</label>
                                <input type="file" name="id_upload" class="form-control" accept=".jpeg, .jpg, .png, .gif" required data-parsley-required-message="Valid ID is required">
                                <small class="form-text text-muted">Accepted formats: .jpg, .png, .gif</small>
                            </div>

                            <!-- Terms and Conditions Checkbox -->
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="terms_conditions" name="terms_conditions" required data-parsley-required-message="You must agree to the terms and conditions.">
                                    <label class="custom-control-label" for="terms_conditions">
                                        I agree to the <a href="#" data-toggle="modal" data-target="#termsModal"><u>terms and conditions</u></a>.
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-warning btn-block">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<!-- Modal Structure (Success Message) -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <!-- Success Icon -->
                <div class="success-icon" style="font-size: 50px; color: green;">
                    <i class="bi bi-check-circle-fill"></i> <!-- Bootstrap check-circle icon -->
                </div>
                <!-- Success Message -->
                <h4>Registration completed successfully</h4>
                <p>Please check your registered email and wait for us to verify</p>
                <!-- Ok Button -->
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

        <!-- Terms and Conditions Modal -->
        <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="termsModalLabel" style="color:white"><strong>Terms and Conditions</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6><strong>NON-DISCLOSURE AGREEMENT</strong></h6>
                        <p>This Non-Disclosure Agreement is entered into by and between ST. COLUMBAN COLLEGE-PAGADIAN CITY, represented by REV. FR. RICO P. SAYSON, herein referred to as the “CLIENT” and ARNOLD N. ESTORES, hereinafter referred to as the “SERVICE PROVIDER”.</p>

                        <h6 class="mt-4"><strong>WITNESSETH:</strong></h6>
                        <p>WHEREAS, the CLIENT and the SERVICE PROVIDER mutually agree to work together for the development and implementation of a Student Information Management System;</p>
                        <p>WHEREAS, in the process, certain confidential information may be exchanged and disclosed between the CLIENT and the SERVICE PROVIDER;</p>

                        <h6 class="mt-4"><strong>NOW, THEREFORE, the parties hereto agree, as follows:</strong></h6>

                        <h6 class="mt-4">1. DEFINITION OF CONFIDENTIAL INFORMATION</h6>
                        <p>All communications or data, in any form, whether tangible or intangible, which are disclosed or furnished by any director, officer, employee, agent, or consultant of any party hereto, including their affiliates and subsidiaries, (hereinafter referred to as “Disclosing Party”) to the other party, including their affiliates and subsidiaries, (hereinafter referred to as “Receiving Party) and which are to be protected hereunder against unrestricted disclosure or competitive use by the Receiving Party shall be deemed to be “Confidential Information.”</p>

                        <h6 class="mt-4">2. EXCEPTIONS TO THE SCOPE OF CONFIDENTIAL INFORMATION</h6>
                        <p>Confidential information does not include information which:</p>
                        <ul>
                            <li>2.1 has been or becomes now or in the future published in the public domain without breach of this Agreement or breach of a similar agreement by a third party;</li>
                            <li>2.2 prior to disclosure hereunder, is properly within the legitimate possession of the Receiving Party;</li>
                            <li>2.3 subsequent to disclosure hereunder, is lawfully received from a third party having rights therein;</li>
                            <li>2.4 is independently developed by the Receiving Party;</li>
                            <li>2.5 is disclosed with the written approval of the other party.</li>
                        </ul>

                        <h6 class="mt-4">3. SCOPE OF USE</h6>
                        <p>Both parties agree that all or any portion of the confidential information exchanged shall not be used except in the manner set forth in this Agreement.</p>

                        <h6 class="mt-4">4. OBLIGATIONS OF THE RECEIVING PARTY</h6>
                        <p>The Receiving Party shall:</p>
                        <ul>
                            <li>4.1 hold the confidential information with confidentiality;</li>
                            <li>4.2 restrict disclosure of the confidential information solely to those persons with a need to know;</li>
                            <li>4.3 advise those persons of, and ensure their compliance with, their obligations;</li>
                            <li>4.4 not use the confidential information for its own benefit;</li>
                            <li>4.5 use the confidential information only for the purposes set forth herein.</li>
                        </ul>

                        <h6 class="mt-4">5. PROPERTY OF THE DISCLOSING PARTY</h6>
                        <p>All confidential information shall remain the sole and exclusive property of the Disclosing Party.</p>

                        <h6 class="mt-4">6. RETURN OF CONFIDENTIAL INFORMATION</h6>
                        <p>All confidential information shall be returned to the Disclosing Party or destroyed upon request.</p>

                        <h6 class="mt-4">7. REPRESENTATION OR WARRANTY</h6>
                        <p>The Disclosing Party makes no representation or warranty as to the accuracy or completeness of the confidential information.</p>

                        <h6 class="mt-4">8. MISCELLANEOUS</h6>
                        <p>No waiver or modification of this Agreement shall be valid unless in writing and signed by both parties.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- end main wrapper -->
        <!-- ============================================================== -->
        <!-- Optional JavaScript -->
        <script>
            $(document).ready(function() {
                $('#registerAs').change(function() {
                    var selectedOption = $(this).val();
                    if (selectedOption === 'student') {
                        $('#studentForm').show();
                        $('#adminForm').hide();
                    } else if (selectedOption === 'admin') {
                        $('#studentForm').hide();
                        $('#adminForm').show();
                    } else {
                        $('#studentForm').hide();
                        $('#adminForm').hide();
                    }
                });
            });
        </script>
        <script src="../asset/vendor/jquery/jquery-3.3.1.min.js"></script>
        <script src="../asset/vendor/bootstrap/js/bootstrap.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
        <script src="../asset/vendor/parsley/parsley.js"></script>
        <script src="../asset/libs/js/main-js.js"></script>

        <script type="text/javascript">
    // Restrict input for the given textbox to the given inputFilter.
    function setInputFilter(textbox, inputFilter) {
        [
            "input", "keydown", "keyup", "mousedown", "mouseup",
            "select", "contextmenu", "drop"
        ].forEach(function(event) {
            textbox.addEventListener(event, function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        });
    }

    // Install input filters.
    const inputs = [
        { id: "intTextBox", filter: value => /^-?\d*$/.test(value) },
        { id: "latinTextBox", filter: value => /^[a-z]*$/i.test(value) },
        { id: "latinTextBox1", filter: value => /^[a-z]*$/i.test(value) },
        { id: "latinTextBox2", filter: value => /^[a-z]*$/i.test(value) },
    ];
    inputs.forEach(input => {
        const element = document.getElementById(input.id);
        if (element) setInputFilter(element, input.filter);
    });
</script>

<script>
    $(document).ready(function() {
        // Initialize Parsley for form validation
        $('form[name="student_form"]').parsley();

        // Form submission handler
        $('form[name="student_form"]').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Grab all form field values
            const formData = new FormData(this);

            // Custom validation for required fields
            const missingFields = [];
            ['first_name', 'last_name', 'complete_address', 'email_address', 'mobile_number', 'id_upload'].forEach(field => {
                if (!formData.get(field)) {
                    missingFields.push(field);
                }
            });

            // Show error if any field is missing
            if (missingFields.length > 0) {
                $('#messageModalBody').html(
                    `<div class="alert alert-danger">
                        Please fill in the required fields: ${missingFields.join(', ').replace(/_/g, ' ')}.
                     </div>`
                );
                $('#messageModal').modal('show'); // Show modal
                return;
            }

            // AJAX Request
            $.ajax({
                url: 'init/controllers/add_student.php', // Your server-side script
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Display success message in modal
                    $('#messageModalBody').html(
                        `<div class="success-icon" style="font-size: 50px; color: green;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <h4>Registration completed successfully</h4>
                        <p>Please check your registered email for email verification</p>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>`
                    );
                    $('#messageModal').modal('show'); // Show modal
                    $('form[name="student_form"]')[0].reset(); // Reset form
                },
                error: function() {
                    // Display error message in modal
                    $('#messageModalBody').html(
                        `<div class="alert alert-danger">An error occurred. Please try again.</div>`
                    );
                    $('#messageModal').modal('show'); // Show modal
                }
            });
        });
    });
</script>

<script>
    // Bootstrap validation logic
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms to apply validation
            const forms = document.getElementsByClassName('needs-validation');
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
</script>



        </body>

        </html>
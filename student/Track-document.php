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
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title"><i class="fa fa-fw fa-eye"></i> Track Document</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Track Document</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->


        <style>
    .container-fluid {
        padding: 20px;
    }
    .card {
        border-radius: 20px;
    }
    .status-card {
        background-color: #ffffff;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        border: 1px solid #e3e6f0;
        transition: all 0.3s;
        height: 100%;
    }
    .status-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }
    .department-name {
        font-size: 1.4rem;
        color: #333;
    }
    .badge {
        font-size: 1.2rem;
        padding: 10px 15px;
    }
    .badge-lg {
        font-size: 1.3rem;
    }
    .comment-section {
        font-size: 1rem;
        color: #555;
    }
    .alert {
        margin-top: 20px;
        font-size: 1.3rem;
    }
    .card-header {
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }
    .department-icon {
        color: #007bff;
    }
    @media (max-width: 768px) {
        .department-name {
            font-size: 1.3rem;
        }
        .badge {
            font-size: 1.1rem;
        }
        .comment-section {
            font-size: 1rem;
        }
    }
    @media (max-width: 576px) {
        .department-name {
            font-size: 1.2rem;
        }
        .badge {
            font-size: 1rem;
        }
        .comment-section {
            font-size: 0.9rem;
        }
    }
</style>

<div class="container-fluid my-5">
    <div class="card shadow-lg border-0 rounded-xl">
        <div class="card-header bg-primary text-white text-center py-4 rounded-top">
            <h2 class="font-weight-bold">Document Request Status</h2>
        </div>
        <div class="card-body p-5">
            <div id="message"></div>
            <form id="validationform" name="docu_forms" data-parsley-validate="" novalidate="" method="POST">
                <?php
                if (isset($_GET['request']) && isset($_GET['student-number'])) {
                    $request_id = $_GET['request'];
                    $student_id = $_GET['student-number'];

                    $conn = new class_model();
                    $document = $conn->fetch_document_by_id($student_id, $request_id);

                    if ($document) {
                        // Display student details at the top
                        echo '<div class="student-details mb-5">';
                        echo '<div class="card p-4 mb-5 shadow-sm rounded-lg bg-light">';
                        echo '<h4 class="font-weight-bold mb-3 text-center">Student Information</h4>';
                        echo '<div class="row">';
                        echo '<div class="col-md-6 mb-3">';
                        echo '<p><strong>Name:</strong> ' . htmlspecialchars($document['first_name']) . ' ' . htmlspecialchars($document['last_name']) . '</p>';
                        echo '</div>';
                        echo '<div class="col-md-6 mb-3">';
                        echo '<p><strong>Control Number:</strong> ' . htmlspecialchars($document['control_no']) . '</p>';
                        echo '</div>';
                        echo '<div class="col-md-12 mb-3">';
                        echo '<p><strong>Document Requested:</strong> ' . htmlspecialchars($document['document_name']) . '</p>';
                        echo '</div>';
                        echo '</div>';

                        // Check if document matches the criteria and display recent image
                        if (preg_match("/Honorable Dismissal/i", $document['document_name']) && !empty($document['recent_image']) && $document['recent_image'] !== "Not Required") {
                            echo '<div class="form-group text-center">';
                            echo '<label for="recent_image_preview"><strong>Recent Image:</strong></label>';
                            echo '<div><img src="../../' . htmlspecialchars($document['recent_image']) . '" alt="Recent Image Preview" class="img-thumbnail mt-3" style="max-width:200px; max-height:200px; cursor:pointer;" onclick="toggleModal(this)"/></div>';
                            echo '</div>';
                        }
                        echo '</div>';

                        // Display each department's status
                        $departments = [
                            'library' => 'Library',
                            'custodian' => 'Custodian',
                            'accounting' => 'Accounting',
                            'registrar' => 'Registrar'
                        ];
                        if (preg_match("/Honorable Dismissal w\/ TOR for evaluation/i", $document['document_name'])) {
                            $departments['dean'] = 'Dean';
                        }

                        echo '<div class="row">';
                        foreach ($departments as $key => $label) {
                            $status = $document[$key . '_status'];
                            echo '<div class="col-md-6 col-lg-4 mb-4">';
                            echo '    <div class="card status-card h-100 p-4 rounded-lg text-center">';
                            echo '        <h5 class="department-name text-uppercase font-weight-bold mb-3">' . $label . '</h5>';

                            switch ($status) {
                                case "Pending":
                                    echo '<span class="badge bg-warning text-white mb-3">Pending</span>';
                                    break;
                                case "Waiting for Payment":
                                    echo '<span class="badge bg-info text-white mb-3">Waiting for Payment</span>';
                                    break;
                                case "Releasing":
                                    echo '<span class="badge bg-success text-white mb-3">Releasing</span>';
                                    break;
                                case "Paid":
                                    echo '<span class="badge bg-success text-white mb-3">Paid</span>';
                                    break;
                                case "Verified":
                                    echo '<span class="badge bg-success text-white mb-3">Verified</span>';
                                    break;
                                case "Released":
                                    echo '<span class="badge bg-success text-white mb-3">Released</span>';
                                    break;
                                case "Declined":
                                    echo '<span class="badge bg-danger text-white mb-3">Declined</span>';
                                    break;
                                default:
                                    echo '<span class="badge bg-secondary text-white mb-3">To Be Assigned</span>';
                            }
                            echo '<div class="comment-section mt-3">';
                            echo '<label><strong>Comment:</strong></label>';
                            echo '<textarea class="form-control mt-2" readonly>Request for ' . htmlspecialchars($document['document_name']) . ' is ' . htmlspecialchars($status) . ', please comply with the requirements to proceed further.</textarea>';
                            echo '</div>';
                            echo '    </div>';
                            echo '</div>';
                        }
                        echo '</div>';
                    } else {
                        echo '<div class="alert alert-danger text-center">No document found!</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger text-center">Invalid request!</div>';
                }
                ?>
            </form>
        </div>
    </div>
</div>



<script src="../asset/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../asset/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../asset/vendor/slimscroll/jquery.slimscroll.js"></script>
<script src="../asset/vendor/charts/charts-bundle/Chart.bundle.js"></script>
<script src="../asset/vendor/charts/charts-bundle/chartjs.js"></script>
<script src="../asset/libs/js/main-js.js"></script>
<script src="../asset/libs/js/dashboard-sales.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var firstName = $('#firstName').text();
        var lastName = $('#lastName').text();
        var initials = firstName.charAt(0) + lastName.charAt(0);
        $('#profileImage').text(initials);
    });
</script>


<!-- ============================================================== -->
<!-- end main wrapper -->
<!-- ============================================================== -->
<!-- Optional JavaScript -->
</body>

</html>
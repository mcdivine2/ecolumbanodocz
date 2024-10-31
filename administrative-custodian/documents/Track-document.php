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

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card influencer-profile-data">
                    <div class="card-body">
                        <div id="message"></div>
                        <form id="validationform" name="docu_forms" data-parsley-validate="" novalidate="" method="POST">
                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label text-sm-left"><i class="fa fa-building"></i> Departments</label>
                                <label class="col-12 col-sm-1 col-form-label text-sm-right"><i class="fa fa-file"></i> Status</label>
                                <label class="col-12 col-sm-2 col-form-label text-sm-right"><i class="fa fa-comment"></i> Comment</label>
                            </div>

                            <?php
                            // Check if request and student ID are passed in URL
                            if (isset($_GET['request']) && isset($_GET['student-number'])) {
                                $request_id = $_GET['request'];
                                $student_id = $_GET['student-number'];

                                // Instantiate the class and fetch the specific document request
                                $conn = new class_model();
                                $document = $conn->fetch_document_by_id($student_id, $request_id);

                                // Check if data is retrieved
                                if ($document) {
                                    // Display each department's status
                                    $departments = [
                                        'library' => 'LIBRARY',
                                        'custodian' => 'CUSTODIAN',
                                        'dean' => 'DEAN',
                                        'accounting' => 'ACCOUNTING',
                                        'registrar' => 'REGISTRAR'
                                    ];

                                    foreach ($departments as $key => $label) {
                                        echo '<div class="form-group row">';
                                        echo '<label class="col-12 col-sm-2 col-form-label text-sm-left">' . $label . ':</label>';
                                        echo '<div class="col-12 col-form-label col-sm-1 col-sm-1">';

                                        $status = $document[$key . '_status'];
                                        switch ($status) {
                                            case "Pending":
                                                echo '<span class="badge bg-warning text-white">Pending</span>';
                                                break;
                                            case "Waiting for Payment":
                                                echo '<span class="badge bg-info text-white">Waiting for Payment</span>';
                                                break;
                                            case "Processing":
                                                echo '<span class="badge bg-success text-white">Processing</span>';
                                                break;
                                            case "Verified":
                                                echo '<span class="badge bg-success text-white">Verified</span>';
                                                break;
                                            case "Received":
                                                echo '<span class="badge bg-warning text-white">Pending Request</span>';
                                                break;
                                            case "Declined":
                                                echo '<span class="badge bg-danger text-white">Declined</span>';
                                                break;
                                            default:
                                                echo '<span class="badge bg-secondary text-white">Unknown Status</span>';
                                        }

                                        echo '</div>';
                                        echo '<div class="col-12 col-sm-6 ml-5">';
                                        echo '<input data-parsley-type="alphanum" type="text" value="Your request for ' . htmlspecialchars($document['document_name']) . ' is ' . htmlspecialchars($status) . ', please comply." name="subject" required="" class="form-control" readonly>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>No document found!</p>';
                                }
                            } else {
                                echo '<p>Invalid request!</p>';
                            }
                            ?>
                        </form>
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
</body>
</html>

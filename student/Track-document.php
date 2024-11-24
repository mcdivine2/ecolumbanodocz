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

        <div class="container-fluid my-5">
    <div class="card shadow-lg border-0 rounded-xl w-100">
        <div class="card-header bg-primary text-white text-center py-4 rounded-top">
            <h2 class="font-weight-bold">Document Request Status</h2>
        </div>
        <div class="card-body p-4">
            <div id="message"></div>
            <form id="validationform" name="docu_forms" data-parsley-validate="" novalidate="" method="POST">
                <?php
                if (isset($_GET['request']) && isset($_GET['student-number'])) {
                    $request_id = $_GET['request'];
                    $student_id = $_GET['student-number'];

                    $conn = new class_model();
                    $document = $conn->fetch_document_by_id($student_id, $request_id);

                    if ($document) {
                        $departments = [
                            'library' => 'Library',
                            'custodian' => 'Custodian',
                            'accounting' => 'Accounting',
                            'registrar' => 'Registrar'
                        ];
                        if (preg_match("/Honorable Dismissal w\/ TOR for evaluation/i", $document['document_name'])) {
                            $departments['dean'] = 'Dean';
                        }

                        echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">';
                        foreach ($departments as $key => $label) {
                            $status = $document[$key . '_status'];
                            echo '<div class="col">';
                            echo '    <div class="status-card h-100 p-4 d-flex flex-column align-items-center rounded-lg text-center">';
                            echo '        <div class="department-icon mb-4">';
                            echo '            <i class="fas fa-building fa-4x text-primary"></i>';
                            echo '        </div>';
                            echo '        <h4 class="department-name text-uppercase font-weight-bold mb-3">' . $label . '</h4>';

                            switch ($status) {
                                case "Pending":
                                    echo '<span class="badge badge-warning badge-lg mb-3">Pending</span>';
                                    break;
                                case "Waiting for Payment":
                                    echo '<span class="badge badge-info badge-lg mb-3">Waiting for Payment</span>';
                                    break;
                                case "Processing":
                                    echo '<span class="badge badge-primary badge-lg mb-3">Processing</span>';
                                    break;
                                case "Paid":
                                    echo '<span class="badge badge-success badge-lg mb-3">Paid</span>';
                                    break;
                                case "Verified":
                                    echo '<span class="badge badge-success badge-lg mb-3">Verified</span>';
                                    break;
                                case "Released":
                                    echo '<span class="badge badge-success badge-lg mb-3">Released</span>';
                                    break;
                                case "Declined":
                                    echo '<span class="badge badge-danger badge-lg mb-3">Declined</span>';
                                    break;
                                default:
                                    echo '<span class="badge badge-secondary badge-lg mb-3">Unknown Status</span>';
                            }
                            echo '        <div class="comment-section">';
                            echo '            <p class="mb-2"><strong>Request:</strong> ' . htmlspecialchars($document['document_name']) . '</p>';
                            echo '            <p class="mb-2"><strong>Status:</strong> ' . htmlspecialchars($status) . '</p>';
                            echo '            <p class="mt-3 text-muted">Please comply with the necessary requirements to proceed further.</p>';
                            echo '        </div>';
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





<!-- ============================================================== -->
<!-- end main wrapper -->
<!-- ============================================================== -->
<!-- Optional JavaScript -->
</body>

</html>
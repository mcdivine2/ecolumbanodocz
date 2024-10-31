<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
        
        .card {
            border: none;
            border-radius: 10px;
        }
        .card-header {
            background: linear-gradient(45deg, #1de099, #1dc8cd);
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .btn-custom {
            background-color: #ffffff;
            color: #333333;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            background-color: #f8f8f8;
        }
        .badge-custom {
            font-size: 0.9rem;
            padding: 0.5em 0.75em;
            border-radius: 15px;
        }
        .info-text {
            font-size: 0.8rem;
            color: #666;
        }
        .form-control-plaintext {
            background-color: #e9ecef;
            border-radius: 5px;
            padding: 10px;
            font-size: 0.9rem;
        }
    </style>
        <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header">
                <h4><i class="fas fa-file-alt"></i> Document Status Overview</h4>
            </div>
            <div class="card-body">
                <div id="message"></div>
                <form id="validationform" name="docu_forms" method="POST">
                    <?php
                    if (isset($_GET['request']) && isset($_GET['student-number'])) {
                        $request_id = $_GET['request'];
                        $student_id = $_GET['student-number'];

                        $conn = new class_model();
                        $document = $conn->fetch_document_by_id($student_id, $request_id);

                        if ($document) {
                            $departments = [
                                'library' => ['Library', 'fa-book'],
                                'custodian' => ['Custodian', 'fa-user-shield'],
                                'dean' => ['Dean', 'fa-chalkboard-teacher'],
                                'accounting' => ['Accounting', 'fa-calculator'],
                                'registrar' => ['Registrar', 'fa-clipboard-list']
                            ];

                            echo '<div class="d-flex justify-content-between flex-wrap">';
                            foreach ($departments as $key => $info) {
                                echo '<button class="btn btn-custom mb-2" type="button" data-toggle="collapse" data-target="#'.$key.'Details" aria-expanded="false" aria-controls="'.$key.'Details"><i class="fas '.$info[1].' pr-2"></i>'.$info[0].'</button>';
                            }
                            echo '</div>';

                            foreach ($departments as $key => $info) {
                                $status = $document[$key . '_status'];
                                $badgeColor = match($status) {
                                    "Pending", "Received" => 'bg-warning',
                                    "Waiting for Payment" => 'bg-info',
                                    "Processing", "Verified", "Released" => 'bg-success',
                                    "Declined" => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                                $badgeClass = 'badge badge-custom ' . $badgeColor;
                                echo '<div class="collapse" id="'.$key.'Details">';
                                echo '<div class="card card-body">';
                                echo '<span class="'.$badgeClass.'">'.$status.'</span>';
                                echo '<input type="text" class="form-control-plaintext mt-2" value="Request for ' . htmlspecialchars($document['document_name']) . ' is ' . htmlspecialchars($status) . ', please comply." readonly>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p class="text-danger">No document found!</p>';
                        }
                    } else {
                        echo '<p class="text-danger">Invalid request!</p>';
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
<script src="../asset/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../asset/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../asset/vendor/custom-js/jquery.multi-select.html"></script>
    <script src="../asset/libs/js/main-js.js"></script>
    <script src="../asset/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../asset/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../asset/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="../asset/vendor/datatables/js/data-table.js"></script>


<!-- ============================================================== -->
<!-- end main wrapper -->
<!-- ============================================================== -->
<!-- Optional JavaScript -->
</body>
</html>

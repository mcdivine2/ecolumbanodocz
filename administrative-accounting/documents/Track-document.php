<?php include('main_header/header.php'); ?>
<?php include('left_sidebar/sidebar.php'); ?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
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

        <div class="card influencer-profile-data">
            <div class="card-body">
                <div id="message"></div>
                <form id="validationform" name="docu_forms" method="POST" novalidate="">
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-sm-left"><i class="fa fa-building"></i> Departments</label>
                        <label class="col-12 col-sm-1 col-form-label text-sm-right"><i class="fa fa-file"></i> Status</label>
                        <label class="col-12 col-sm-2 col-form-label text-sm-right"><i class="fa fa-comment"></i> Comment</label>
                    </div>

                    <?php
                    if (isset($_GET['request']) && isset($_GET['student-number'])) {
                        $request_id = $_GET['request'];
                        $student_id = $_GET['student-number'];

                        $conn = new class_model();
                        $document = $conn->fetch_document_by_id($student_id, $request_id);


                        if ($document) {
                            $departments = [
                                'library' => 'LIBRARY',
                                'custodian' => 'CUSTODIAN',
                                // 'dean' => 'DEAN',
                                'accounting' => 'ACCOUNTING',
                                'registrar' => 'REGISTRAR'
                            ];
                            if (preg_match("/Honorable Dismissal w\/ TOR for evaluation/i", $document['document_name'])) {
                                $departments['dean'] = 'DEAN';
                            }

                            foreach ($departments as $key => $label) {
                                echo '<div class="form-group row">';
                                echo '<label class="col-12 col-sm-2 col-form-label text-sm-left">' . $label . ':</label>';
                                echo '<div class="col-12 col-form-label col-sm-1">';

                                $status = $document[$key . '_status'];
                                $statusBadge = match ($status) {
                                    "Pending" => "bg-warning",
                                    "Waiting for Payment" => "bg-info",
                                    "Processing", "Verified" => "bg-success",
                                    "Received" => "bg-warning",
                                    "Declined" => "bg-danger",
                                    default => "bg-secondary"
                                };
                                echo '<span class="badge ' . $statusBadge . ' text-white">' . htmlspecialchars($status) . '</span>';

                                echo '</div>';
                                echo '<div class="col-12 col-sm-6 ml-5">';
                                echo '<input type="text" value="Your request for ' . htmlspecialchars($document['document_name']) . ' is ' . htmlspecialchars($status) . ', please comply." name="subject" class="form-control" readonly>';
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
</body>

</html>
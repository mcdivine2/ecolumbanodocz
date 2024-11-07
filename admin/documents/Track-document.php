<?php include('main_header/header.php'); ?>
<?php include('left_sidebar/sidebar.php'); ?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-12">
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

        <div class="row">
            <div class="col-12">
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
                            if (isset($_GET['request']) && isset($_GET['student-number'])) {
                                $request_id = $_GET['request'];
                                $student_id = $_GET['student-number'];

                                $conn = new class_model();
                                $document = $conn->fetch_document_by_id($student_id, $request_id);

                                if ($document) {
                                    $departments = [
                                        'library' => 'LIBRARY',
                                        'custodian' => 'CUSTODIAN',
                                        'dean' => 'DEAN',
                                        'accounting' => 'ACCOUNTING',
                                        'registrar' => 'REGISTRAR'
                                    ];

                                    foreach ($departments as $key => $label) {
                                        $status = $document[$key . '_status'];
                                        $badge_classes = [
                                            "Pending" => "bg-warning",
                                            "Waiting for Payment" => "bg-info",
                                            "Processing" => "bg-success",
                                            "Verified" => "bg-success",
                                            "Released" => "bg-success",
                                            "Pending Request" => "bg-warning",
                                            "Declined" => "bg-danger"
                                        ];
                                        $badge_class = $badge_classes[$status] ?? 'bg-secondary';
                            ?>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-2 col-form-label text-sm-left"><?= $label; ?>:</label>
                                            <div class="col-12 col-sm-1">
                                                <span class="badge <?= $badge_class; ?> text-white"><?= htmlspecialchars($status); ?></span>
                                            </div>
                                            <div class="col-12 col-sm-6 ml-5">
                                                <input type="text" value="Your request for <?= htmlspecialchars($document['document_name']); ?> is <?= htmlspecialchars($status); ?>, please comply." class="form-control" readonly>
                                            </div>
                                        </div>
                            <?php
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
</body>

</html>
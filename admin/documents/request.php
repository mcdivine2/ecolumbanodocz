<?php include('main_header/header.php'); ?>
<?php include('left_sidebar/sidebar.php'); ?>

<style>
    .card-header {
        font-weight: bold;
        font-size: 1.2em;
    }
    .form-control.custom-select {
        border: 1px solid #ced4da;
        transition: border-color 0.2s ease-in-out;
    }
    .form-control.custom-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .card.shadow-sm {
        border: none;
        border-radius: 0.5rem;
    }
    .card-header i {
        margin-right: 0.5rem;
    }
    label i {
        margin-right: 0.25rem;
        color: #6c757d;
    }
</style>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-12">
                <div class="page-header">
                    <h2 class="pageheader-title"><i class="fa fa-fw fa-file"></i> Document Request</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Document Request</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Filter Form -->
<div class="card shadow-sm mb-4">
    <h5 class="card-header text-white bg-primary"><i class="fa fa-filter"></i> Filter by Date</h5>
    <div class="card-body">
        <form method="GET" action="" id="filterForm">
            <div class="row">
                <div class="col-md-4">
                    <label for="day"><i class="fa fa-calendar-day"></i> Day</label>
                    <select name="day" id="day" class="form-control custom-select" onchange="document.getElementById('filterForm').submit();">
                        <option value="">All</option>
                        <?php for ($d = 1; $d <= 31; $d++): ?>
                            <option value="<?= $d; ?>" <?= isset($_GET['day']) && $_GET['day'] == $d ? 'selected' : ''; ?>><?= $d; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="month"><i class="fa fa-calendar-alt"></i> Month</label>
                    <select name="month" id="month" class="form-control custom-select" onchange="document.getElementById('filterForm').submit();">
                        <option value="">All</option>
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?= $m; ?>" <?= isset($_GET['month']) && $_GET['month'] == $m ? 'selected' : ''; ?>><?= date('F', mktime(0, 0, 0, $m, 10)); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="year"><i class="fa fa-calendar"></i> Year</label>
                    <select name="year" id="year" class="form-control custom-select" onchange="document.getElementById('filterForm').submit();">
                        <option value="">All</option>
                        <?php for ($y = date('Y'); $y >= 2000; $y--): ?>
                            <option value="<?= $y; ?>" <?= isset($_GET['year']) && $_GET['year'] == $y ? 'selected' : ''; ?>><?= $y; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>


        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Request Information</h5>
                    <div class="card-body">
                        <div id="message"></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered first" data-show-print="true">
                                <thead>
                                    <tr>
                                        <th>Date Requested</th>
                                        <th>Control No.</th>
                                        <th>Student EDP</th>
                                        <th>Student Name</th>
                                        <th>Document Name</th>
                                        <th>Mode Request</th>
                                        <th>Date Releasing</th>
                                        <th>Request Type</th>
                                        <th>Status</th>
                                        <th>Clearance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $conn = new class_model();
                                    
                                    // Fetch filter values
                                    $day = isset($_GET['day']) ? $_GET['day'] : '';
                                    $month = isset($_GET['month']) ? $_GET['month'] : '';
                                    $year = isset($_GET['year']) ? $_GET['year'] : '';

                                    // Fetch filtered document requests
                                    $docrequest = $conn->fetchAll_documentrequest($day, $month, $year);
                                    foreach ($docrequest as $row) {
                                        // Determine clearance button properties
                                        $all_verified = ($row['library_status'] === 'Verified' &&
                                            $row['dean_status'] === 'Verified' or 'Not Included' && 
                                            $row['custodian_status'] === 'Verified' &&
                                            $row['accounting_status'] === 'Verified');
                                        $clearance_text = $row['registrar_status'] === 'Declined' ? 'Cancel' : ($all_verified ? 'Complete' : 'Incomplete');
                                        $clearance_class = $row['registrar_status'] === 'Declined' ? 'btn-danger' : ($all_verified ? 'btn-success' : 'btn-primary');

                                        // Define status badge classes
                                        $status_badges = [
                                            "Pending Request" => "primary",
                                            "Released" => "success",
                                            "Pending" => "warning",
                                            "Verified" => "success",
                                            "Declined" => "danger"
                                        ];
                                        $status_text = $row['registrar_status'];
                                        $badge_class = $status_badges[$status_text] ?? 'secondary';

                                    ?>
                                    
                                        <tr>
                                            <td><?= $row['date_request']; ?></td>
                                            <td><?= $row['control_no']; ?></td>
                                            <td><?= $row['studentID_no'] ?? 'N/A'; ?></td>
                                            <td><?= htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></td>
                                            <td><?= $row['document_name']; ?></td>
                                            <td><?= htmlspecialchars($row['mode_request']); ?></td>
                                            <td><?= $row['date_releasing']; ?></td>
                                            <td><?=($row['request_type']); ?></td>
                                            <td><span class='badge bg-<?= $badge_class; ?> text-white'><?= $status_text; ?></span></td>
                                            <td>
                                                <a href="Track-document.php?request=<?= $row['request_id']; ?>&student-number=<?= $row['student_id']; ?>"
                                                    class="btn btn-sm <?= $clearance_class; ?> text-xs"
                                                    data-toggle="tooltip" title="Clearance">
                                                    <?= $clearance_text; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?php if ($status_text !== 'Released'): ?>
                                                    <a href="edit-request.php?request=<?= $row['request_id']; ?>&student-number=<?= $row['student_id']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" title="Edit request">
                                                        <i class="fa fa-edit"></i>
                                                    </a> |
                                                <?php endif; ?>
                                                <a href="email-form-r.php?request=<?= $row['request_id']; ?>&student-number=<?= $row['student_id']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" title="Send email">
                                                    <i class="fa fa-envelope"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Scripts -->
<script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../assets/vendor/custom-js/jquery.multi-select.html"></script>
    <script src="../assets/libs/js/main-js.js"></script>
    <script src="../assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="../assets/vendor/datatables/js/data-table.js"></script>

<script>
    $(document).ready(function() {
        // Display initials in profile image
        let initials = $('#firstName').text().charAt(0) + $('#lastName').text().charAt(0);
        $('#profileImage').text(initials);

        // Handle delete request
        $('.delete').on('click', function() {
            let request_id = $(this).data("id");
            if (confirm("Are you sure you want to remove this data?")) {
                $.post("../init/controllers/delete_request.php", {
                    request_id
                }, function(response) {
                    $("#message").html(response);
                }).fail(function() {
                    console.log("Failed");
                });
            }
        });

        // Load unseen notifications
        function load_unseen_notification(view = '') {
            $.post("../init/controllers/fetch.php", {
                view
            }, function(data) {
                $('.dropdown-menu_1').html(data.notification);
                if (data.unseen_notification > 0) $('.count').html(data.unseen_notification);
            }, 'json');
        }

        load_unseen_notification();
        $('.dropdown-toggle').on('click', function() {
            $('.count').html('');
            load_unseen_notification('yes');
        });

        setInterval(load_unseen_notification, 5000);
    });
</script>
</body>

</html>
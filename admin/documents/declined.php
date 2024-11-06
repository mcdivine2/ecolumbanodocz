<?php include('main_header/header.php'); ?>
<?php include('left_sidebar/sidebar.php'); ?>

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

        <div class="row">
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
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Document Name</th>
                                        <th>Mode Request</th>
                                        <th>Date Releasing</th>
                                        <th>Processing Officer</th>
                                        <th>Status</th>
                                        <th>Clearance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $conn = new class_model();
                                    $docrequest = $conn->fetchAll_declined();
                                    foreach ($docrequest as $row) {
                                        // Check if all required statuses are verified
                                        $all_verified = ($row['library_status'] === 'Verified' &&
                                            $row['dean_status'] === 'Verified' &&
                                            $row['custodian_status'] === 'Verified' &&
                                            $row['accounting_status'] === 'Verified');

                                        $clearance_text = $all_verified ? 'Complete' : 'Incomplete';
                                        $clearance_class = $all_verified ? 'btn-success' : 'btn-primary';
                                    ?>
                                        <tr>
                                            <td><?= date("M d, Y", strtotime($row['date_request'])); ?></td>
                                            <td><?= $row['control_no']; ?></td>
                                            <td><?= $row['student_id']; ?></td>
                                            <td><?= $row['first_name'] . " " . $row['last_name']; ?></td>
                                            <td><?= $row['document_name']; ?></td>
                                            <td><?= $row['mode_request']; ?></td>
                                            <td><?= $row['date_releasing'] ? date("M d, Y", strtotime($row['date_releasing'])) : ''; ?></td>
                                            <td><?= $row['processing_officer']; ?></td>
                                            <td>
                                                <?php
                                                $status_badges = [
                                                    "Processing" => "primary",
                                                    "Releasing" => "info",
                                                    "Waiting for Payment" => "warning",
                                                    "Verified" => "success",
                                                    "Declined" => "danger"
                                                ];
                                                $status_text = $row['registrar_status'];
                                                $badge_class = isset($status_badges[$status_text]) ? $status_badges[$status_text] : 'secondary';
                                                echo "<span class='badge bg-{$badge_class} text-white'>{$status_text}</span>";
                                                ?>
                                            </td>
                                            <td>
                                                <a href="Track-document.php?request=<?= $row['request_id']; ?>&student-number=<?= $row['student_id']; ?>"
                                                    class="btn btn-sm <?= $clearance_class; ?> text-xs"
                                                    data-toggle="tooltip"
                                                    title="Clearance">
                                                    <?= $clearance_text; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="edit-request.php?request=<?= $row['request_id']; ?>&student-number=<?= $row['student_id']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" title="Edit request">
                                                    <i class="fa fa-edit"></i>
                                                </a> |
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
<script src="../assets/libs/js/main-js.js"></script>
<script src="../assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>

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
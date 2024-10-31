<?php 
include('main_header/header.php'); 
include('left_sidebar/sidebar.php'); 
?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-header">
                    <h2 class="pageheader-title">
                        <i class="fa fa-fw fa-file"></i> Document Request
                    </h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item">Document Requests</li>
                                <li class="breadcrumb-item active" aria-current="page">Processing</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <h5 class="card-header">Request Information</h5>
                    <div class="card-body">
                        <div id="message"></div>
                        <div class="table-responsive">
                            <a href="add-request.php" class="btn btn-sm" 
                               style="background-color:rgb(235, 151, 42); color: rgb(243, 245, 238);">
                                <i class="fa fa-fw fa-plus"></i> Add Request
                            </a><br><br>

                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th>Control No.</th>
                                        <th>Student ID</th>
                                        <th>Document Name</th>
                                        <th>Date Request</th>
                                        <th>Date Releasing</th>
                                        <th>Processing Officer</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $student_id = $_SESSION['student_id'];
                                    $conn = new class_model();
                                    $docrequest = $conn->fetchAll_processing($student_id);

                                    foreach ($docrequest as $row): ?>
                                    <tr>
                                        <td><?= $row['control_no']; ?></td>
                                        <td><?= $row['student_id']; ?></td>
                                        <td><?= $row['document_name']; ?></td>
                                        <td><?= date("M d, Y", strtotime($row['date_request'])); ?></td>
                                        <td>
                                            <?= $row['date_releasing'] ? date("M d, Y", strtotime($row['date_releasing'])) : ''; ?>
                                        </td>
                                        <td><?= $row['processing_officer']; ?></td>
                                        <td>
                                            <?php 
                                            $statusClass = [
                                                "Pending Request" => "info",
                                                "Processing" => "danger",
                                                "Verified" => "success",
                                                "Received" => "warning"
                                            ];
                                            $status = $row['registrar_status'];
                                            echo "<span class='badge bg-{$statusClass[$status]} text-white'>{$status}</span>";
                                            ?>
                                        </td>
                                        <td>
                                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#paymentModal"
                                        data-control-no="<?= $row['control_no']; ?>"
                                         data-document-name="<?= $row['document_name']; ?>"
                                        data-total-amount="<?= $row['price']; ?>">
                                        <i class="fa fa-credit-card"></i> Pay
                                    </button>
                                    </td>
                                        <td>
                                            <a href="Track-document.php?request=<?= $row['request_id']; ?>&student-number=<?= $row['student_id']; ?>" 
                                               class="btn btn-sm btn-primary text-xs" data-toggle="tooltip" data-original-title="Clearance">
                                                Clearance
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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

<script>
$(document).ready(function () {
    // Initialize profile image with initials
    var initials = $('#firstName').text().charAt(0) + $('#lastName').text().charAt(0);
    $('#profileImage').text(initials);

    // Load unseen notifications
    function load_unseen_notification(view = '') {
        $.ajax({
            url: "../init/controllers/fetch.php",
            method: "POST",
            data: { view: view },
            dataType: "json",
            success: function (data) {
                $('.dropdown-menu_1').html(data.notification);
                if (data.unseen_notification > 0) {
                    $('.count').html(data.unseen_notification);
                }
            }
        });
    }

    load_unseen_notification();

    // Mark notifications as seen on click
    $(document).on('click', '.dropdown-toggle', function () {
        $('.count').html('');
        load_unseen_notification('yes');
    });

    // Auto-refresh notifications every 4 seconds
    setInterval(load_unseen_notification, 4000);

    // Delete request on click
    $(document).on('click', '.delete', function () {
        var request_id = $(this).data('id');
        if (confirm("Are you sure want to remove this data?")) {
            $.ajax({
                url: "../init/controllers/delete_request.php",
                method: "POST",
                data: { request_id: request_id },
                success: function (response) {
                    $("#message").html(response);
                },
                error: function () {
                    console.error("Failed to delete request.");
                }
            });
        }
    });
});
</script>

</body>
</html>

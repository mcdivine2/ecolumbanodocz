<?php include('main_header/header.php'); ?>
<?php include('left_sidebar/sidebar.php'); ?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <!-- Page Header -->
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
                                <li class="breadcrumb-item active" aria-current="page">Pending Requests</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Request Information Table -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <h5 class="card-header">Request Information</h5>
                    <div class="card-body">
                        <div id="message"></div>
                        <div class="table-responsive">
                            <a href="add-request.php" class="btn btn-sm" style="background-color:rgb(235, 151, 42); color: rgb(243, 245, 238);">
                                <i class="fa fa-fw fa-plus"></i> Add Request
                            </a>
                            <br><br>
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th>Control No.</th>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Document Name</th>
                                        <th>Date Request</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $student_id = $_SESSION['student_id'];
                                        $conn = new class_model();
                                        $docrequest = $conn->fetchAll_pendingrequest($student_id);
                                        foreach ($docrequest as $row): 
                                    ?>
                                        <tr>
                                            <td><?= $row['control_no']; ?></td>
                                            <td><?= $row['student_id']; ?></td>
                                            <td><?= $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                            <td><?= $row['document_name']; ?></td>
                                            <td><?= date("M d, Y", strtotime($row['date_request'])); ?></td>
                                            <td>
                                                <?php 
                                                    $status = $row['registrar_status'];
                                                    $badge_class = match ($status) {
                                                        "Processing" => "info",
                                                        "Waiting for Payment" => "danger",
                                                        "Releasing" => "success",
                                                        "Received" => "warning",
                                                        default => "secondary"
                                                    };
                                                    echo "<span class='badge bg-$badge_class text-white'>$status</span>";
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
                                                <a href="javascript:;" data-id="<?= $row['request_id']; ?>" class="text-secondary delete">
                                                    <i class="fa fa-trash-alt"></i>
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

<!-- JavaScript -->
<script src="../asset/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../asset/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../asset/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../asset/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="../asset/libs/js/main-js.js"></script>

<script>
    $(document).ready(function () {
        // Generate initials for profile image
        const firstName = $('#firstName').text();
        const lastName = $('#lastName').text();
        const initials = firstName.charAt(0) + lastName.charAt(0);
        $('#profileImage').text(initials);

        // Delete request
        $('.delete').on('click', function () {
            const request_id = $(this).data('id');
            if (confirm("Are you sure you want to remove this data?")) {
                $.post("../init/controllers/delete_request.php", { request_id }, function (response) {
                    $("#message").html(response);
                }).fail(function () {
                    console.error("Failed to delete request.");
                });
            }
        });

        // Load unseen notifications
        function loadUnseenNotifications(view = '') {
            $.post("../init/controllers/fetch.php", { view }, function (data) {
                $('.dropdown-menu_1').html(data.notification);
                if (data.unseen_notification > 0) {
                    $('.count').html(data.unseen_notification);
                }
            }, 'json');
        }

        loadUnseenNotifications();
        $('.dropdown-toggle').on('click', function () {
            $('.count').html('');
            loadUnseenNotifications('yes');
        });

        setInterval(loadUnseenNotifications, 4000);
    });
</script>

</body>
</html>

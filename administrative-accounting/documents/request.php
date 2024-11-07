<?php include('main_header/header.php'); ?>
<?php include('left_sidebar/sidebar.php'); ?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-12">
                <div class="page-header">
                    <h2 class="pageheader-title"><i class="fa fa-fw fa-file-image"></i> Proof of Payment </h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Document</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .modal-body {
                display: flex;
                align-items: flex-start;
                flex-wrap: wrap;
                padding: 20px;
            }

            .modal-title {
                font-weight: bold;
            }

            #modal-proof-of-payment {
                max-width: 100%;
                width: 400px;
                border: 1px solid #ddd;
                border-radius: 5px;
                margin: auto;
                cursor: pointer;
            }

            #modal-proof-of-payment:hover {
                transform: scale(1.05);
                transition: 0.3s ease;
            }

            .image-container {
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            #largeImageModal img {
                width: 100%;
                height: auto;
            }

            .modal-fullscreen {
                max-width: 90%;
                width: 90%;
                height: 90%;
                margin: auto;
            }
        </style>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Payment Information</h5>
                    <div class="card-body">
                        <div id="message"></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Control No.</th>
                                        <th>Document Name</th>
                                        <th>Trace No.</th>
                                        <th>Reference No.</th>
                                        <th>Total Amount</th>
                                        <th>Date of Payment</th>
                                        <th>Proof of Payment</th>
                                        <th>Status</th>
                                        <th>Clearance</th>
                                        <th>View Information</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    function formatMoney($number, $fractional = false)
                                    {
                                        return $fractional ? number_format($number, 2) : number_format($number);
                                    }

                                    $conn = new class_model();
                                    $payments = $conn->fetchAll_paymentrequest();
                                    foreach ($payments as $row) { ?>
                                        <tr>
                                            <td><?= ucwords($row['student_id']); ?></td>
                                            <td><?= ucwords($row['student_name']); ?></td>
                                            <td><?= $row['control_no']; ?></td>
                                            <td><?= $row['document_name']; ?></td>
                                            <td><?= $row['trace_no']; ?></td>
                                            <td><?= $row['ref_no']; ?></td>
                                            <td>Php <?= formatMoney($row['total_amount'], true); ?></td>
                                            <td><?= $row['date_ofpayment'] ? date("M d, Y", strtotime($row['date_ofpayment'])) : ""; ?></td>
                                            <td><?= $row['proof_ofpayment']; ?></td>
                                            <td>
                                                <?php
                                                switch ($row['status']) {
                                                    case 'Paid':
                                                        echo '<span class="badge bg-warning text-white">Paid</span>';
                                                        break;
                                                    case 'Pending':
                                                        echo '<span class="badge bg-warning text-white">Pending</span>';
                                                        break;
                                                    case 'Declined':
                                                        echo '<span class="badge bg-danger text-white">Declined</span>';
                                                        break;
                                                    case 'Verified':
                                                        echo '<span class="badge bg-success text-white">Verified</span>';
                                                        break;
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="Track-document.php?request=<?= $row['control_no']; ?>&student-number=<?= $row['student_id']; ?>" class="btn btn-sm btn-primary text-xs">Clearance</a>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#paymentModal"
                                                    data-student-id="<?= $row['student_id']; ?>"
                                                    data-student-name="<?= $row['student_name']; ?>"
                                                    data-control-no="<?= $row['control_no']; ?>"
                                                    data-document-name="<?= $row['document_name']; ?>"
                                                    data-total-amount="<?= $row['total_amount']; ?>"
                                                    data-date-payment="<?= $row['date_ofpayment']; ?>"
                                                    data-status="<?= $row['status']; ?>"
                                                    data-proof-of-payment="../../student/<?= $row['proof_ofpayment']; ?>">
                                                    <i class="fa fa-eye"></i> View
                                                </button>
                                            </td>
                                            <td>
                                                <a href="edit-request.php?request=<?= $row['control_no']; ?>&student-number=<?= $row['student_id']; ?>" class="text-secondary"><i class="fa fa-edit"></i></a>
                                                <a href="email-form-r.php?request=<?= $row['control_no']; ?>&student-number=<?= $row['student_id']; ?>" class="text-secondary"><i class="fa fa-envelope"></i></a>
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

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Information</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body d-flex align-items-start">
                <div class="mr-2">
                    <p><strong>Student ID:</strong> <span id="modal-student-id"></span></p>
                    <p><strong>Student Name:</strong> <span id="modal-student-name"></span></p>
                    <p><strong>Control No:</strong> <span id="modal-control-no"></span></p>
                    <p><strong>Document Name:</strong> <span id="modal-document-name"></span></p>
                    <p><strong>Total Amount:</strong> <span id="modal-total-amount"></span></p>
                    <p><strong>Date of Payment:</strong> <span id="modal-date-payment"></span></p>
                    <p><strong>Status:</strong> <span id="modal-status"></span></p>
                </div>
                <div class="image-container">
                    <img id="modal-proof-of-payment" class="img-fluid" src="" alt="Proof of Payment" data-toggle="modal" data-target="#largeImageModal">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="largeImageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Proof of Payment</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <img id="large-proof-of-payment" src="" alt="Proof of Payment" class="img-fluid" style="width: 100%; height: auto;">
            </div>
        </div>
    </div>
</div>

<script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script>
    $(document).ready(function() {
        $('#paymentModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#modal-student-id').text(button.data('student-id'));
            modal.find('#modal-student-name').text(button.data('student-name'));
            modal.find('#modal-control-no').text(button.data('control-no'));
            modal.find('#modal-document-name').text(button.data('document-name'));
            modal.find('#modal-total-amount').text(button.data('total-amount'));
            modal.find('#modal-date-payment').text(button.data('date-payment'));
            modal.find('#modal-status').text(button.data('status'));
            modal.find('#modal-proof-of-payment').attr('src', button.data('proof-of-payment') || 'path-to-default-image.jpg');
        });

        $('#largeImageModal').on('show.bs.modal', function() {
            var largeImage = $('#modal-proof-of-payment').data('large-image');
            $(this).find('#large-proof-of-payment').attr('src', largeImage);
        });
    });
</script>
</body>

</html>
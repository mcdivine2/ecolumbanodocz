<?php include('main_header/header.php');?>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
         <?php include('left_sidebar/sidebar.php');?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
            <div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title"><i class="fa fa-fw fa-money-bill-wave"></i> Add Payment </h2>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Payment</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Payment Form -->




<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card influencer-profile-data">
            <div class="card-body">
                <form id="addPaymentForm" method="POST" action="submit_payment.php">
                    <div class="form-group row">
                        <div class="col-12 col-sm-6">
                            <label>Reference No.</label>
                            <input type="text" value="<?= uniqid('ref_'); ?>" name="reference_no" readonly class="form-control">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Student Name</label>
                            <input type="text" name="student_name" required class="form-control" placeholder="Enter student name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-6">
                            <label>Control No.</label>
                            <input type="text" name="control_no" required class="form-control" placeholder="Enter control number">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Document Name</label>
                            <input type="text" name="document_name" required class="form-control" placeholder="Enter document name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-6">
                            <label>Date of Payment</label>
                            <input type="date" name="date_ofpayment" required class="form-control">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Total Amount</label>
                            <input type="text" name="total_amount" required class="form-control" placeholder="Enter total amount">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-6">
                            <label>Amount Paid</label>
                            <input type="text" name="amount_paid" required class="form-control" placeholder="Enter amount paid">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Proof of Payment</label>
                            <input type="text" name="proof_ofpayment" required class="form-control" placeholder="Enter proof of payment">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-6">
                            <label>Status</label>
                            <select name="status" required class="form-control">
                                <option value="Verified">Verified</option>
                                <option value="Paid">Paid</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row text-right">
                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                            <button type="submit" class="btn btn-space btn-primary">Submit Payment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
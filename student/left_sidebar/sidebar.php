<?php
// Assume $student_id is already defined or retrieved, e.g., from session or another source
$student_id = $_SESSION['student_id']; // Replace with actual retrieval method

// Fetch the total request count
$totalRequestData = $conn->count_numberoftotalrequest($student_id);
$totalRequestCount = !empty($totalRequestData) ? $totalRequestData[0]['count_request'] : 0;

// Fetch the total payment count
$totalPaymentData = $conn->count_Allpayments($student_id);
$totalPaymentCount = !empty($totalPaymentData) ? $totalPaymentData[0]['count_payment'] : 0;
?>

<?php
// Assume $student_id is already defined or retrieved, e.g., from session or another source
$student_id = $_SESSION['student_id']; // Replace with actual retrieval method

// Fetch the total request count
$totalRequestData = $conn->count_numberoftotalrequest($student_id);
$totalRequestCount = !empty($totalRequestData) ? $totalRequestData[0]['count_request'] : 0;

// Fetch the total payment count
$totalPaymentData = $conn->count_numberoftotalpending($student_id);
$totalPaymentCount = !empty($totalPaymentData) ? $totalPaymentData[0]['count_pending'] : 0;
?>

<style>
    .navbar-nav .nav-item .nav-link[data-toggle="collapse"]::after {
    display: none;
}



/* Navbar and Collapsible Items */
.nav-left-sidebar .navbar {
    padding: 0 15px;
}

.nav-left-sidebar .navbar-toggler {
    border: none;
    background: none;
    color: #fff;
    font-size: 20px;
    outline: none;
}

.nav-left-sidebar .navbar-toggler-icon {
    color: #fff;
}




/* Nav Links Styling */
.nav-left-sidebar .nav-link {
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    display: flex;
    align-items: center;
    transition: all 0.3s;
    padding: 10px 15px;
    border-radius: 5px;
}

.nav-left-sidebar .nav-link:hover {
    background-color: #026639; /* Hover highlight */
    color: #fff;
    text-decoration: none;
}

.nav-left-sidebar .nav-link i {
    font-size: 18px;
    margin-right: 10px;
}

/* Badge Styling */
.nav-left-sidebar .nav-link .badge {
    margin-left: auto;
    font-size: 12px;
    padding: 5px 10px;
    background-color: #28a745; /* Green color for badges */
    color: #fff;
    border-radius: 12px;
}

/* Submenu Styling */
.nav-left-sidebar .collapse .nav-link {
    padding-left: 30px;
    font-size: 13px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .nav-left-sidebar {
        width: 100%;
        position: relative;
        height: auto;
    }

    .nav-left-sidebar .navbar {
        padding: 0 10px;
    }
}

</style>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../asset/libs/css/style.css">
<div class="nav-left-sidebar sidebar-light" style="background-color: rgb(1,50,32); padding-top: 25px; font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="index.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fa fa-fw fa-tachometer-alt"></i>Dashboard <span class="badge badge-success"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#historyRequestSubmenu" role="button" aria-expanded="false" aria-controls="historyRequestSubmenu">
                            <i class="fa fa-fw fa-file"></i>Requests <span class="badge badge-success"><?= $totalRequestCount ?></span>
                        </a>
                        <div class="collapse" id="historyRequestSubmenu">
                            <ul class="navbar-nav flex-column ml-3">
                                <li class="nav-item">
                                    <a class="nav-link" href="request-list.php">
                                        <i class="fa fa-check-circle"></i>All Request
                                    </a>
                                </li>
        
                                <li class="nav-item">
                                    <a class="nav-link" href="add-request.php"><i class="fa fa-fw fa-plus">
                                        </i>Request Document <span class="badge badge-success"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#PaymentSubmenu" role="button" aria-expanded="false" aria-controls="PaymentSubmenu">
                            <i class="fa fa-fw fa-money-bill-wave"></i>Payments <span class="badge badge-success"><?= $totalPaymentCount ?></span>
                        </a>
                        <div class="collapse" id="PaymentSubmenu">
                            <ul class="navbar-nav flex-column ml-3">
                                <li class="nav-item">
                                    <a class="nav-link" href="pending-payment.php">
                                        <i class="fa fa-clock"></i>Waiting for Payment <span class="badge badge-success"><?= $totalPaymentCount ?></span>
                                    </a>
                                </li>
                
                                <li class="nav-item">
                                    <a class="nav-link" href="payment.php"><i class="fa fa-fw fa-money-bill-wave">
                                        </i>Proof of Payment 
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php"><i class="fas fa-id-card">
                            </i>Profile <span class="badge badge-success"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

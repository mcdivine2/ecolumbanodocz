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
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fa fa-fw fa-tachometer-alt"></i>Dashboard <span class="badge badge-success"></span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="request-list.php">
                            <i class="fa fa-fw fa-file"></i>History Request <span class="badge badge-success"><?= $totalRequestCount ?></span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="payment.php"><i class="fa fa-fw fa-money-bill-wave">
                            </i>Proof of Payment <span class="badge badge-success"><?= $totalPaymentCount ?></span>
                        </a>
                        </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="add-request.php"><i class="fa fa-fw fa-plus">
                            </i>Request Document <span class="badge badge-success"></span>
                        </a>
                    
                        
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
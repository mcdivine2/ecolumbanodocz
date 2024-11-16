
<?php include('main_header/header.php'); ?>
<!-- ============================================================== -->
<!-- end navbar -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- left sidebar -->
<!-- ============================================================== -->
<?php include('left_sidebar/sidebar.php'); ?>
<!-- ============================================================== -->
<!-- end left sidebar -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<style>

.dashboard {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    width: 100%;
}

.cards {
    height: 250px;
    overflow: hidden;  /* Ensures content does not overflow the card */
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;  /* Set a fixed height for each card */
}
.card-body {
    height: calc(100% - 50px); /* Adjust to subtract the header height */
    overflow: hidden;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.card-header h3 {
    font-size: 1.1em;
    color: #333;
    margin: 0;
}

.btn-options {
    background: none;
    border: none;
    color: #e74c3c;
    font-size: 1.2em;
    cursor: pointer;
}

canvas {
    height: 100% !important;
    width: 100% !important;
}

        </style>
<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title"><i class="fa fa-fw fa-tachometer-alt"></i> Dashboard</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Home</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- pageheader  -->
        <!-- ============================================================== -->
        <div class="row">
            <style>
                .row {
                    display: flex;
                    justify-content: center;
                }
            </style>
            <!-- metric -->
            <div class="col-xl-6 col-lg-6 col-md-4 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $conn = new class_model();
                        $cstudent = $conn->count_numberoftotalreceived();
                        ?>
                        <?php foreach ($cstudent as $row): ?>
                            <div class="d-inline-block">
                                <h5 class="text-muted"><b>New Request</b></h5>
                                <h2 class="mb-0"><?= $row['count_received']; ?></h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg  mt-1" style="background-color:#1269AF">
                                <i class="fa fa-bell fa-fw fa-sm text-info" style="color: white !important"></i>
                            </div>
                        <?php endforeach; ?>

                    </div>
                    <a href="new-request.php" class="btn btn-primary" style="background-color:#1269AF">View</a>
                </div>
            </div>
            <!-- /. metric -->
            <!-- metric -->

            <!-- /. metric -->
            <!-- metric -->
            <div class="col-xl-6 col-lg-6 col-md-4 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $conn = new class_model();
                        $cstudent = $conn->count_numberofverified();
                        ?>
                        <?php foreach ($cstudent as $row): ?>
                            <div class="d-inline-block">
                                <h5 class="text-muted"><b>Processing</b></h5>
                                <h2 class="mb-0"><?= $row['count_verified']; ?></h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg mt-1" style="background-color:#1269AF">
                                <i class="fa fa-calendar-check fa-fw fa-sm text-info" style="color:white !important"></i>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="processing.php" class="btn btn-primary" style="background-color:#1269AF">View</a>
                </div>
            </div>
            <!-- /. metric -->
        </div>
        <div class="row ">
            <!-- here -->
            <div class="col-xl-6 col-lg-6 col-md-4 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $conn = new class_model();
                        $cstudent = $conn->count_complete();
                        ?>
                        <?php foreach ($cstudent as $row): ?>
                            <div class="d-inline-block">
                                <h5 class="text-muted"><b>Complete</b></h5>
                                <h2 class="mb-0"><?= $row['count_complete']; ?></h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg mt-1" style="background-color:#1269AF">
                                <i class="fa fa-calendar-check fa-fw fa-sm text-info" style="color:white !important"></i>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="complete.php" class="btn btn-primary" style="background-color:#1269AF">View</a>
                </div>

            </div>
            <div class="col-xl-6 col-lg-6 col-md-4 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $conn = new class_model();
                        $cstudent = $conn->count_declined();
                        ?>
                        <?php foreach ($cstudent as $row): ?>
                            <div class="d-inline-block">
                                <h5 class="text-muted"><b>Declined</b></h5>
                                <h2 class="mb-0"><?= $row['count_declined']; ?></h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg mt-1" style="background-color:#1269AF">
                                <i class="fa fa-calendar-check fa-fw fa-sm text-info" style="color:white !important"></i>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="declined.php" class="btn btn-primary" style="background-color:#1269AF">View</a>
                </div>

            </div>

        </div>
        </div>
        
        <?php
$conn = new class_model();

// Weekly Data: Grouped by day of the current week
$weeklyData = [];
for ($day = 1; $day <= 7; $day++) {
    $date = date('Y-m-d', strtotime("this week +$day days"));
    $weeklyData[$date] = count($conn->fetchAll_documentrequest(date('d', strtotime($date)), date('m', strtotime($date)), date('Y', strtotime($date))));
}


// Monthly Data (grouped by month for the current year)
$monthlyData = [];
for ($i = 1; $i <= 12; $i++) {
    $monthlyData[$i] = count($conn->fetchAll_documentrequest(null, $i, date('Y')));
}

// Yearly Data (last 5 years as an example)
$yearlyData = [];
$currentYear = date('Y');
for ($i = $currentYear - 4; $i <= $currentYear; $i++) {
    $yearlyData[$i] = count($conn->fetchAll_documentrequest(null, null, $i));
}

// Encode the data for JavaScript
$weeklyDataJSON = json_encode($weeklyData);
$monthlyDataJSON = json_encode($monthlyData);
$yearlyDataJSON = json_encode($yearlyData);
?>

        <div class="col">
        <h5 class="card-header">Request Status Reports</h5>
        
        <div class="dashboard">
    <div class="cards" style="border-top: 5px solid #4a90e2;">
        <div class="card-header">
            <h3>Weekly Record</h3>
        </div>
        <canvas id="weeklyChart"></canvas>
    </div>

    <div class="cards" style="border-top: 5px solid #d9534f;">
        <div class="card-header">
            <h3>Monthly Record</h3>
        </div>
        <canvas id="monthlyChart"></canvas>
    </div>

    <div class="cards" style="border-top: 5px solid #8e44ad;">
        <div class="card-header">
            <h3>Yearly Record</h3>
        </div>
        <canvas id="yearlyChart"></canvas>
    </div>
</div>




<!-- ============================================================== -->
<!-- end main wrapper -->
<!-- ============================================================== -->

<!-- Optional JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
<script src="../assets/libs/js/main-js.js"></script>
<script type="text/javascript" src="../assets/js/loader.js"></script>

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
    });
</script>
<script>

    // Weekly Chart
    const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
    const weeklyData = <?= $weeklyDataJSON ?>;
    new Chart(weeklyCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(weeklyData),
            datasets: [{
                label: 'Weekly Document Requests',
                data: Object.values(weeklyData),
            }]
        }
    });

    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = <?= $monthlyDataJSON ?>;
    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            datasets: [{
                label: 'Monthly Document Requests (Current Year)',
                data: [
                    monthlyData[1] || 0,
                    monthlyData[2] || 0,
                    monthlyData[3] || 0,
                    monthlyData[4] || 0,
                    monthlyData[5] || 0,
                    monthlyData[6] || 0,
                    monthlyData[7] || 0,
                    monthlyData[8] || 0,
                    monthlyData[9] || 0,
                    monthlyData[10] || 0,
                    monthlyData[11] || 0,
                    monthlyData[12] || 0
                ],
            }]
        }
    });

    // Yearly Chart
    const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
    const yearlyData = <?= $yearlyDataJSON ?>;
    new Chart(yearlyCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(yearlyData),
            datasets: [{
                label: 'Yearly Document Requests',
                data: Object.values(yearlyData),
            }]
        }
    });
</script>




</body>

</html>
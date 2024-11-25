<?php include('main_header/header.php'); ?>

<?php include('left_sidebar/sidebar.php'); ?>

<style>
    .dashboard {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        width: 100%;
    }

    .cards {
        height: 250px;
        overflow: hidden;
        /* Ensures content does not overflow the card */
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        position: relative;
        /* Set a fixed height for each card */
    }

    .card-body {
        height: calc(100% - 50px);
        /* Adjust to subtract the header height */
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

        <!-- new request and processing -->
        <div class="row">
            <!-- New Request -->
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
            <!-- Declined Request -->
            <div class="col-xl-6 col-lg-6 col-md-4 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $conn = new class_model();
                        $cstudent = $conn->count_declined();
                        ?>
                        <?php foreach ($cstudent as $row): ?>
                            <div class="d-inline-block">
                                <h5 class="text-muted"><b>Declined Request</b></h5>
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
            <!-- Clearance Processing -->
            <div class="col-xl-6 col-lg-6 col-md-4 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $conn = new class_model();
                        $cstudent = $conn->count_numberofverified();
                        ?>
                        <?php foreach ($cstudent as $row): ?>
                            <div class="d-inline-block">
                                <h5 class="text-muted"><b>Clearance Processing</b></h5>
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
            <!-- Document Processing -->
            <div class="col-xl-6 col-lg-6 col-md-4 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $conn = new class_model();
                        $cstudent = $conn->count_numberoftotalprocessing();
                        ?>
                        <?php foreach ($cstudent as $row): ?>
                            <div class="d-inline-block">
                                <h5 class="text-muted"><b>Document Processing</b></h5>
                                <h2 class="mb-0"><?= $row['count_processing']; ?></h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg mt-1" style="background-color:#1269AF">
                                <i class="fa fa-calendar-check fa-fw fa-sm text-info" style="color:white !important"></i>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="document-processing.php" class="btn btn-primary" style="background-color:#1269AF">View</a>
                </div>
            </div>
            <!-- To Be Release -->
            <div class="col-xl-6 col-lg-6 col-md-4 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $conn = new class_model();
                        $cstudent = $conn->count_numberoftotalreleasing();
                        ?>
                        <?php foreach ($cstudent as $row): ?>
                            <div class="d-inline-block">
                                <h5 class="text-muted"><b>To Be Release</b></h5>
                                <h2 class="mb-0"><?= $row['count_releasing']; ?></h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg  mt-1" style="background-color:#1269AF">
                                <i class="fa fa-bell fa-fw fa-sm text-info" style="color: white !important"></i>
                            </div>
                        <?php endforeach; ?>

                    </div>
                    <a href="releasing.php" class="btn btn-primary" style="background-color:#1269AF">View</a>
                </div>
            </div>
            <!-- Complete -->
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

        </div>
        <div class="container-fluid dashboard-content">

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title"><i class="fa fa-fw fa-chart-bar"></i> Reports </h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Reports</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $conn = new class_model();

            // Weekly Data: Grouped by Monday-Sunday of the current week
            $weeklyData = [];
            $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $startOfWeek = strtotime('monday this week'); // Start of the current week (Monday)

            for ($day = 0; $day < 7; $day++) {
                $currentDate = strtotime("+$day day", $startOfWeek);
                $dayNum = date('d', $currentDate);
                $monthNum = date('m', $currentDate);
                $yearNum = date('Y', $currentDate);
                $weeklyData[$weekdays[$day]] = count($conn->fetchAll_documentrequest($dayNum, $monthNum, $yearNum));
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

            <!-- Dropdown for Report Type -->
            <div class="row">
                <div class="col-12">
                    <select id="filterType" class="form-control" style="width: 200px; margin-bottom: 20px;">
                        <option value="weekly" selected>Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Document Request Statistic</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="chart-title">
                                                <h4>Document Request Report</h4>
                                            </div>
                                            <table class="table table-bordered mytable">
                                                <thead>
                                                    <tr>
                                                        <th>Name of Documents</th>
                                                        <th>Number of Requests</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="courseRequestTable">
                                                    <!-- AJAX-loaded data will populate here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="chart-title">
                                                <h4>Number of Requests</h4><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div id="piechart" style="width: 100%; height: 500px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>




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
    // Weekly Chart
    const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
    const weeklyData = <?= json_encode($weeklyData) ?>; // Convert PHP array to JSON
    new Chart(weeklyCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(weeklyData), // Directly use 'Monday', 'Tuesday', etc.
            datasets: [{
                label: 'Weekly Document Requests',
                data: Object.values(weeklyData),
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Optional: Bar background color
                borderColor: 'rgba(75, 192, 192, 1)', // Optional: Bar border color
                borderWidth: 1 // Optional: Bar border width
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,

                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Days of the Week'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
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
    $(document).ready(function() {
        // Display initials in profile image
        let initials = $('#firstName').text().charAt(0) + $('#lastName').text().charAt(0);
        $('#profileImage').text(initials);
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        // Event listener for filter change
        $('#filterType').on('change', function() {
            const filterType = $(this).val();
            loadCourseRequests(filterType);
        });

        function loadCourseRequests(filterType = 'weekly') {
            $.ajax({
                url: "../init/controllers/fetch.php", // Fetch data from the PHP backend
                method: "GET",
                data: {
                    filterType
                }, // Send the filter type (weekly, monthly, yearly)
                dataType: "json",
                success: function(data) {
                    if (data.length > 0) {
                        var tableBody = '';
                        var formattedData = [
                            ['Document Name', 'Number of Requests']
                        ]; // Google Chart data format

                        $.each(data, function(index, row) {
                            tableBody += '<tr><td>' + row[0] + '</td><td>' + row[1] + '</td></tr>';
                            formattedData.push([row[0], parseInt(row[1])]);
                        });

                        $('#courseRequestTable').html(tableBody); // Populate the table

                        // Draw the pie chart with fetched data
                        drawChart(formattedData);
                    } else {
                        $('#courseRequestTable').html('<tr><td colspan="2">No data available for this period.</td></tr>');
                        drawChart([
                            ['Document Name', 'Number of Requests']
                        ]);
                    }
                },
                error: function(error) {
                    console.error('AJAX Error:', error);
                    alert('Failed to fetch data.');
                },
            });
        }

        function drawChart(data) {
            var chartData = google.visualization.arrayToDataTable(data);
            var options = {
                title: 'Document Request Statistics',
                is3D: true,
                pieSliceText: 'value',
                legend: {
                    position: 'bottom'
                },
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(chartData, options);
        }

        // Load Google Charts library
        google.charts.load('current', {
            packages: ['corechart']
        });

        // Load default (weekly) data on page load
        google.charts.setOnLoadCallback(function() {
            loadCourseRequests('weekly');
        });
    });
</script>

</body>

</html>
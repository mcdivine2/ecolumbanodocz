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
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
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
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
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
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $conn = new class_model();
                        $cstudent = $conn->count_numberoftotalrequest();
                        ?>
                        <?php foreach ($cstudent as $row): ?>
                            <div class="d-inline-block">
                                <h5 class="text-muted"><b>Number of total request</b></h5>
                                <h2 class="mb-0"><?= $row['count_request']; ?></h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg mt-1" style="background-color:#1269AF">
                                <i class="fa fa-layer-group fa-fw fa-sm text-info" style="color:white !important"></i>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="request.php" class="btn btn-primary" style="background-color:#1269AF">View</a>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
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



            <!-- Additional Metrics Sections (repeat for other metrics as per original code) -->

        </div>

        <h5 class="card-header">Request Status Reports</h5>

        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="chart-title">
                                <h4>Request Status</h4>
                            </div>
                            <table class="table table-bordered mytable">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Number of Request</th>
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
                        <div id="piechart" style="width: 500px; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- end main wrapper -->
<!-- ============================================================== -->

<!-- Optional JavaScript -->
<script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
<script src="../assets/libs/js/main-js.js"></script>
<script type="text/javascript" src="../assets/js/loader.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        function loadCourseRequests() {
            $.ajax({
                url: "../init/controllers/fetch.php", // Your PHP file to fetch course data
                method: "GET",
                dataType: "json",
                success: function(data) {
                    if (data.length > 0) {
                        var tableBody = '';
                        var formattedData = [
                            ['Course', 'Request']
                        ];

                        // Log the data received for debugging
                        // console.log("Data received:", data);

                        $.each(data, function(index, row) {
                            tableBody += '<tr><td>' + row[0] + '</td><td>' + row[1] + '</td></tr>';
                            formattedData.push([row[0], parseInt(row[1])]);
                        });

                        $('#courseRequestTable').html(tableBody);

                        // Draw the pie chart with fetched data
                        drawChart(formattedData);
                    } else {
                        console.error('No data received or invalid data format');
                    }
                },
                error: function(error) {
                    console.error('Error fetching course data:', error);
                }
            });
        }

        function drawChart(data) {
            var chartData = google.visualization.arrayToDataTable(data);
            var options = {
                title: 'Requests by Course'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(chartData, options);
        }

        google.charts.load('current', {
            'packages': ['corechart']
        });

        google.charts.setOnLoadCallback(loadCourseRequests);
    });
</script>

</body>

</html>
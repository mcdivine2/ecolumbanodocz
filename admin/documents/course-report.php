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
          <div class="container-fluid  dashboard-content">
             <!-- ============================================================== -->
             <!-- pageheader -->
             <!-- ============================================================== -->
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
             <!-- ============================================================== -->
             <!-- end pageheader -->
             <!-- ============================================================== -->

             <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                   <div class="card">
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
                <!-- end responsive table -->
                <!-- ============================================================== -->
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
       <script src="../assets/vendor/custom-js/jquery.multi-select.html"></script>
       <script src="../assets/libs/js/main-js.js"></script>
       <script src="../assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
       <script src="../assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
       <script src="../assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
       <script src="../assets/vendor/datatables/js/data-table.js"></script>
       <script type="text/javascript" src="../assets/js/loader.js"></script>
       <script type="text/javascript">
          $(document).ready(function() {
             var firstName = $('#firstName').text();
             var lastName = $('#lastName').text();
             var intials = $('#firstName').text().charAt(0) + $('#lastName').text().charAt(0);
             var profileImage = $('#profileImage').text(intials);
          });
       </script>
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
                        //  console.log("Data received:", data);

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
<?php include('main_header/header.php'); ?>
<?php include('left_sidebar/sidebar.php'); ?>

<div class="dashboard-wrapper">
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
<script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../assets/js/loader.js"></script>
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
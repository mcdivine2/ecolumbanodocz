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
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title"><i class="fa fa-fw fa-eye"></i> Track Document</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Track Document</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->


        <style>
    .container-fluid {
        padding: 20px;
    }
    .card {
        border-radius: 20px;
    }
    .status-card {
        background-color: #ffffff;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        border: 1px solid #e3e6f0;
        transition: all 0.3s;
        height: 100%;
    }
    .status-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }
    .department-name {
        font-size: 1.4rem;
        color: #333;
    }
    .badge {
        font-size: 1.2rem;
        padding: 10px 15px;
    }
    .badge-lg {
        font-size: 1.3rem;
    }
    .comment-section {
        font-size: 1rem;
        color: #555;
    }
    .alert {
        margin-top: 20px;
        font-size: 1.3rem;
    }
    .card-header {
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }
    .department-icon {
        color: #007bff;
    }
    @media (max-width: 768px) {
        .department-name {
            font-size: 1.3rem;
        }
        .badge {
            font-size: 1.1rem;
        }
        .comment-section {
            font-size: 1rem;
        }
    }
    @media (max-width: 576px) {
        .department-name {
            font-size: 1.2rem;
        }
        .badge {
            font-size: 1rem;
        }
        .comment-section {
            font-size: 0.9rem;
        }
    }
</style>

        <div class="container">
  <div class="row">
    <div class="col-12">
      <div class="card influencer-profile-data">
        <div class="card-body">
          <h3 class="text-center mb-4" style="background-color: #5069e7; color: white; padding: 10px;">Document Request Status</h3>
          <div id="message"></div>
          <form id="validationform" name="docu_forms" data-parsley-validate="" novalidate="" method="POST">
            <?php
              // Check if request and student ID are passed in URL
              if (isset($_GET['request']) && isset($_GET['student-number'])) {
                  $request_id = $_GET['request'];
                  $student_id = $_GET['student-number'];

                  // Instantiate the class and fetch the specific document request
                  $conn = new class_model();
                  $document = $conn->fetch_document_by_id($student_id, $request_id);
                  if ($document) {
                      // Display student details at the top
                      echo "<h4>Student Name: " . htmlspecialchars($document['first_name']) . " " . htmlspecialchars($document['last_name']) . "</h4>";
                      echo "<p>Control Number: " . htmlspecialchars($document['control_no']) . "</p>";
                      echo "<p>Document Requested: " . htmlspecialchars($document['document_name']) . "</p>";

                      // Check if document matches the criteria and display recent image
                      if (preg_match("/Honorable Dismissal/i", $document['document_name']) && !empty($document['recent_image']) && $document['recent_image'] !== "Not Required") {
                          echo '<div class="form-group">';
                          echo '<label for="recent_image_preview">Recent Image:</label>';
                          echo '<div><img src="../../' . htmlspecialchars($document['recent_image']) . '" alt="Recent Image Preview" style="max-width:200px; max-height:200px; cursor:pointer;" onclick="toggleModal(this)"/></div>';
                          echo '</div>';
                      }
                  }

                 
                  
              } else {
                  echo '<p>Invalid request!</p>';
              }
            ?>
          </form>
          <div class="row justify-content-center">
            <!-- LIBRARY -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card shadow">
                <div class="card-body text-center">
                  <i class="fa fa-building fa-3x mb-3" style="color: #5069e7;"></i>
                  <h5 class="card-title">LIBRARY</h5>
                  <span class="badge bg-warning text-white mb-3" style="font-size: 1.2em;">Pending</span>
                  <p class="card-text">Request: Honorable Dismissal (x1)<br>Diploma (x1)</p>
                  <p class="card-text">Status: Pending</p>
                  <p class="text-muted">Please comply with the necessary requirements to proceed further.</p>
                </div>
              </div>
            </div>

            <!-- CUSTODIAN -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card shadow">
                <div class="card-body text-center">
                  <i class="fa fa-building fa-3x mb-3" style="color: #5069e7;"></i>
                  <h5 class="card-title">CUSTODIAN</h5>
                  <span class="badge bg-warning text-white mb-3" style="font-size: 1.2em;">Pending</span>
                  <p class="card-text">Request: Honorable Dismissal (x1)<br>Diploma (x1)</p>
                  <p class="card-text">Status: Pending</p>
                  <p class="text-muted">Please comply with the necessary requirements to proceed further.</p>
                </div>
              </div>
            </div>

            <!-- ACCOUNTING -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card shadow">
                <div class="card-body text-center">
                  <i class="fa fa-building fa-3x mb-3" style="color: #5069e7;"></i>
                  <h5 class="card-title">ACCOUNTING</h5>
                  <span class="badge bg-success text-white mb-3" style="font-size: 1.2em;">Paid</span>
                  <p class="card-text">Request: Honorable Dismissal (x1)<br>Diploma (x1)</p>
                  <p class="card-text">Status: Paid</p>
                  <p class="text-muted">Please comply with the necessary requirements to proceed further.</p>
                </div>
              </div>
            </div>

            <!-- REGISTRAR -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card shadow">
                <div class="card-body text-center">
                  <i class="fa fa-building fa-3x mb-3" style="color: #5069e7;"></i>
                  <h5 class="card-title">REGISTRAR</h5>
                  <span class="badge bg-success text-white mb-3" style="font-size: 1.2em;">Verified</span>
                  <p class="card-text">Request: Honorable Dismissal (x1)<br>Diploma (x1)</p>
                  <p class="card-text">Status: Verified</p>
                  <p class="text-muted">Please comply with the necessary requirements to proceed further.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="../asset/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../asset/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../asset/vendor/slimscroll/jquery.slimscroll.js"></script>
<script src="../asset/vendor/charts/charts-bundle/Chart.bundle.js"></script>
<script src="../asset/vendor/charts/charts-bundle/chartjs.js"></script>
<script src="../asset/libs/js/main-js.js"></script>
<script src="../asset/libs/js/dashboard-sales.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var firstName = $('#firstName').text();
        var lastName = $('#lastName').text();
        var initials = firstName.charAt(0) + lastName.charAt(0);
        $('#profileImage').text(initials);
    });
</script>


<!-- ============================================================== -->
<!-- end main wrapper -->
<!-- ============================================================== -->
<!-- Optional JavaScript -->
</body>

</html>
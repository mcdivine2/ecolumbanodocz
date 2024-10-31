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
               <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                             <h2 class="pageheader-title"><i class="fa fa-fw fa-file-word"></i> Edit Document </h2>
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
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
                <?php 
                include '../init/model/config/connection2.php';
                $GET_id = intval($_GET['document']);
                $document_name = $_GET['document-name'];
                $sql = "SELECT * FROM `tbl_document` WHERE `document_id` = ? AND `document_name` = ?";
                $stmt = $conn->prepare($sql); 
                $stmt->bind_param("is", $GET_id, $document_name);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                ?>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card influencer-profile-data">
                                <div class="card-body">
                                    <div class="" id="message"></div>
                                    <form id="validationform" name="docu_form" data-parsley-validate="" novalidate="" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right"><i class="fa fa-file-word"></i> Document Info</label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Course Name</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input data-parsley-type="alphanum" name="document_name" value="<?= htmlspecialchars($row['document_name']); ?>" type="text" required placeholder="" class="form-control document_name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Description</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input data-parsley-type="alphanum" name="description" value="<?= htmlspecialchars($row['description']); ?>" type="text" required placeholder="" class="form-control description">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Days to Process:</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input data-parsley-type="alphanum" name="daysto_process" value="<?= htmlspecialchars($row['daysto_process']); ?>" type="text" required placeholder="" class="form-control daysto_process">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Price:</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input data-parsley-type="alphanum" name="price" value="<?= htmlspecialchars($row['price']); ?>" type="text" required placeholder="" class="form-control price">
                                            </div>
                                        </div>
                                        <div class="form-group row text-right">
                                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                                <input type="hidden" name="document_id" value="<?= htmlspecialchars($row['document_id']); ?>">
                                                <button type="submit" class="btn btn-space btn-primary" id="btn-docu">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php 
                }  
                ?>

            </div>  
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../assets/vendor/parsley/parsley.js"></script>
    <script src="../assets/libs/js/main-js.js"></script>
    <script>
    $('#form').parsley();
    </script>
    <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    </script>
     <script type="text/javascript">
        $(document).ready(function(){
          var firstName = $('#firstName').text();
          var lastName = $('#lastName').text();
          var intials = $('#firstName').text().charAt(0) + $('#lastName').text().charAt(0);
          var profileImage = $('#profileImage').text(intials);
        });

        $(document).ready(function() {
        $('form[name="docu_form"]').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Collect input values
            var document_name = $(this).find('input[name="document_name"]').val();
            var description = $(this).find('input[name="description"]').val();
            var daysto_process = $(this).find('input[name="daysto_process"]').val();
            var price = $(this).find('input[name="price"]').val();
            var document_id = $(this).find('input[name="document_id"]').val();

            // Check for empty fields
            if (!document_name || !description || !daysto_process || !price) {
                $('#message').html('<div class="alert alert-danger">All fields are required!</div>');
                return;
            }

            // Make an AJAX request to edit the document
            $.ajax({
                url: '../init/controllers/edit_document.php',
                method: 'post',
                data: {
                    document_name: document_name,
                    description: description,
                    daysto_process: daysto_process,
                    price: price,
                    document_id: document_id
                },
                success: function(response) {
                    $("#message").html(response);
                },
                error: function() {
                    console.log("Failed to submit form.");
                    $('#message').html('<div class="alert alert-danger">An error occurred while processing your request.</div>');
                }
            });
        });
    });
    </script>




</body>
 
</html>
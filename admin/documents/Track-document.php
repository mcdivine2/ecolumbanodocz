<?php include('main_header/header.php'); ?>
<?php include('left_sidebar/sidebar.php'); ?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-12">
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

        <div class="row">
            <div class="col-12">
                <div class="card influencer-profile-data">
                    <div class="card-body">
                        <?php
                        if (isset($_GET['request']) && isset($_GET['student-number'])) {
                            $request_id = $_GET['request'];
                            $student_id = $_GET['student-number'];

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
                        }
                        ?>

                        <form id="validationform" name="docu_forms" data-parsley-validate="" novalidate="" method="POST">
                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label text-sm-left"><i class="fa fa-building"></i> Departments</label>
                                <label class="col-12 col-sm-1 col-form-label text-sm-right"><i class="fa fa-file"></i> Status</label>
                                <label class="col-12 col-sm-2 col-form-label text-sm-right"><i class="fa fa-comment"></i> Comment</label>
                            </div>

                            <?php
                            if ($document) {
                                // Define departments
                                $departments = [
                                    'library' => 'LIBRARY',
                                    'custodian' => 'CUSTODIAN',
                                    'accounting' => 'ACCOUNTING',
                                    'registrar' => 'REGISTRAR'
                                ];

                                if (preg_match("/CPA BOARD EXAM/i", $document['request_type'])) {
                                    $departments['dean'] = 'DEAN';
                                }

                                // Display department statuses and comments
                                foreach ($departments as $key => $label) {
                                    $status = $document[$key . '_status'];
                                    $badge_classes = [
                                        "Pending" => "bg-warning",
                                        "Waiting for Payment" => "bg-info",
                                        "Processing" => "bg-success",
                                        "Verified" => "bg-success",
                                        "Released" => "bg-success",
                                        "To Be Release" => "bg-success",
                                        "Pending Request" => "bg-warning",
                                        "Declined" => "bg-danger"
                                    ];
                                    $badge_class = $badge_classes[$status] ?? 'bg-secondary';
                            ?>
                                    <div class="form-group row">
                                        <label class="col-12 col-sm-2 col-form-label text-sm-left"><?= $label; ?>:</label>
                                        <div class="col-12 col-sm-1">
                                            <span class="badge <?= $badge_class; ?> text-white"><?= htmlspecialchars($status); ?></span>
                                        </div>
                                        <div class="col-12 col-sm-6 ml-5">
                                            <input type="text" value="Your request for <?= htmlspecialchars($document['document_name']); ?> is <?= htmlspecialchars($status); ?>, please comply." class="form-control" readonly>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo '<p>No document found!</p>';
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.9);">
    <img id="modalImage" style="margin:auto; display:block; max-width:80%; max-height:80%;" onclick="toggleModal()">
</div>

<script>
    // Function to toggle the modal visibility
    function toggleModal(img = null) {
        const modal = document.getElementById("imageModal");
        const modalImage = document.getElementById("modalImage");

        if (modal.style.display === "block") {
            // Hide the modal if it's currently visible
            modal.style.display = "none";
        } else {
            // Show the modal with the clicked image
            modal.style.display = "block";
            modalImage.src = img.src;
        }
    }
</script>

</body>

</html>
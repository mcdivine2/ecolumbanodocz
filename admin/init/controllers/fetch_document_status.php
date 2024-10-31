<?php
require_once "../model/class_model.php";

$conn = new class_model(); 
if (isset($_GET['request']) && isset($_GET['student_number'])) {
    $request_id = $_GET['request'];
    $student_id = $_GET['student_number'];

    $document = $conn->fetch_document_by_id($student_id, $request_id);

    if ($document) {
        $departments = [
            'library' => ['Library', 'fa-book'],
            'custodian' => ['Custodian', 'fa-user-shield'],
            'dean' => ['Dean', 'fa-chalkboard-teacher'],
            'accounting' => ['Accounting', 'fa-calculator'],
            'registrar' => ['Registrar', 'fa-clipboard-list']
        ];

        echo '<div class="d-flex justify-content-between flex-wrap">';
        foreach ($departments as $key => $info) {
            echo '<button class="btn btn-custom mb-2" type="button" data-toggle="collapse" data-target="#'.$key.'Details" aria-expanded="false" aria-controls="'.$key.'Details"><i class="fas '.$info[1].' pr-2"></i>'.$info[0].'</button>';
        }
        echo '</div>';

        foreach ($departments as $key => $info) {
            $status = $document[$key . '_status'];
            $badgeColor = match($status) {
                "Pending", "Received" => 'bg-warning',
                "Waiting for Payment" => 'bg-info',
                "Processing", "Verified", "Released" => 'bg-success',
                "Declined" => 'bg-danger',
                default => 'bg-secondary'
            };
            $badgeClass = 'badge badge-custom ' . $badgeColor;
            echo '<div class="collapse" id="'.$key.'Details">';
            echo '<div class="card card-body">';
            echo '<span class="'.$badgeClass.'">'.$status.'</span>';
            echo '<input type="text" class="form-control-plaintext mt-2" value="Request for ' . htmlspecialchars($document['document_name']) . ' is ' . htmlspecialchars($status) . ', please comply." readonly>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p class="text-danger">No document found!</p>';
    }
} else {
    echo '<p class="text-danger">Invalid request!</p>';
}

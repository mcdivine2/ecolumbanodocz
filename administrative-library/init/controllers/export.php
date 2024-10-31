<?php

include '../init/model/config/connection2.php';


$query =$conn->query("SELECT * FROM documentrequest ORDER BY date_created DESC");

if ($query->num_rows > 0) 
{
    
    $delimiter =",";
    $filename = "documentrequest_" . date('Y-m-d') . ".csv";

    $f = fopen('php//memory', 'w');

    $fields = array ('ID', 'Control Number', 'Student ID_no', 'Email Address', 'Document Name', 'Number of Copies', 'Date Requested', 'Date Releasing', 'Processing Officer', 'Status');
    fputcsv = ($f, $fields, $delimiter);

    while($row = $query->fetch_assoc())
    {
        $lineData = array($row['request_id'], $row['control_no'], $row['studentID_no'], $row['email_address'], , $row['document_name'], $row['no_ofcopies'], $row['date_request'], $row['date_releasing'], $row['processing_officer'], $row['status']);
        fputcsv($f, $lineData, $delimiter);
    }
    fseek($f, 0);

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    fpassthru($f);

}
exit;

?>
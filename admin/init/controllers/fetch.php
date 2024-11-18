<?php
include '../model/config/connection2.php';

// Get the filter type from the AJAX request (weekly, monthly, yearly)
$filterType = isset($_GET['filterType']) ? $_GET['filterType'] : 'weekly';

// Initialize an empty array to store document counts
$documentCounts = [];

// Build the base query to fetch rows from tbl_documentrequest based on the filter type
switch ($filterType) {
  case 'monthly':
    $query = "
            SELECT document_name 
            FROM tbl_documentrequest 
            WHERE MONTH(date_request) = MONTH(CURRENT_DATE()) 
            AND YEAR(date_request) = YEAR(CURRENT_DATE())
        ";
    break;

  case 'yearly':
    $query = "
            SELECT document_name 
            FROM tbl_documentrequest 
            WHERE YEAR(date_request) = YEAR(CURRENT_DATE())
        ";
    break;

  default: // Weekly by default
    $query = "
            SELECT document_name 
            FROM tbl_documentrequest 
            WHERE WEEK(date_request) = WEEK(CURRENT_DATE()) 
            AND YEAR(date_request) = YEAR(CURRENT_DATE())
        ";
    break;
}

// Execute the query
$result = $conn->query($query);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    // Get the concatenated document names with quantities
    $documents = $row['document_name'];

    // Split the string into individual documents using <br> as the separator
    $docArray = explode('<br>', $documents);

    // Loop through each document and extract its name and quantity
    foreach ($docArray as $doc) {
      // Use regex to extract the document name and quantity (e.g., "Transfer Credential (x2)")
      if (preg_match('/^(.*)\s\(x(\d+)\)$/', $doc, $matches)) {
        $docName = trim($matches[1]); // Document name
        $quantity = (int)$matches[2]; // Quantity

        // Add the quantity to the document's count
        if (!isset($documentCounts[$docName])) {
          $documentCounts[$docName] = 0;
        }
        $documentCounts[$docName] += $quantity;
      }
    }
  }
}

// Prepare the data for JSON output
$data = [];
foreach ($documentCounts as $docName => $count) {
  $data[] = [$docName, $count];
}

// Output the data as JSON
header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);

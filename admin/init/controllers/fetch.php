<?php
include '../model/config/connection2.php';  // Include your connection file

$stmt = $conn->prepare('SELECT c.course_name, COUNT(dr.course) as request_count 
                        FROM tbl_course c 
                        LEFT JOIN tbl_documentrequest dr ON c.course_name = dr.course 
                        GROUP BY c.course_name');
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $data[] = [$row['course_name'], (int)$row['request_count']];
  }
}

echo json_encode($data);

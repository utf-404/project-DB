<?php
$user = 'S13_502';
$pw = 'pw1234';
$servername = '203.249.87.57/orcl';

$conn = oci_connect($user, $pw, $servername);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$sql = "SELECT * FROM review_time";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);

$reviews = array();

while ($row = oci_fetch_assoc($stmt)) {
    array_push($reviews, $row);
}

if (count($reviews) > 0) {
    echo json_encode($reviews);
} else {
    $response = array("status" => "error", "message" => "No reviews found");
    echo json_encode($response);
}

oci_close($conn);
?>

<?php
putenv("NLS_LANG=AMERICAN_AMERICA.AL32UTF8");

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
    $reviews[] = $row;
}

if (count($reviews) > 0) {
    echo json_encode($reviews);
} else {
    echo "리뷰가 없습니다.";
}

oci_free_statement($stmt);
oci_close($conn);
?>

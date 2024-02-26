<?php
$user = 'S13_502';
$pw = 'pw1234';
$servername = '203.249.87.57/orcl';

$conn = oci_connect($user, $pw, $servername);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

if(isset($_GET['id'])) {
    $review_id = $_GET['id'];

    $sql = "DELETE FROM REVIEW_TIME WHERE REVIEW_TIME_ID = :review_id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":review_id", $review_id);
    oci_execute($stmt);

    $rowsAffected = oci_num_rows($stmt);
    if ($rowsAffected > 0) {
        echo "<script>alert('리뷰가 성공적으로 삭제되었습니다.'); window.history.back();</script>";
    } else {
        echo "<script>alert('리뷰 삭제에 실패했습니다.'); window.history.back();</script>";
    }

    oci_free_statement($stmt);
}

oci_close($conn);
?>

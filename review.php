<?php
$user = 'S13_502';
$pw = 'pw1234';
$servername = '203.249.87.57/orcl';

$conn = oci_connect($user, $pw, $servername);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $rating = $_POST['rating'];
    $checklist = isset($_POST['price']) ? implode(', ', (array)$_POST['price']) : '';
    $productQuality = isset($_POST['product_quality']) ? implode(', ', (array)$_POST['product_quality']) : '';
    $reviewContent = $_POST['reviewContent'];

    // 데이터베이스에 데이터 삽입
    $sql = "INSERT INTO review_time (review_time_logid, review_time_title, review_time_score, review_time_checklist, review_time_text) VALUES (:id, :title, :rating, :checklist, :reviewContent)";

    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":id", $id);
    oci_bind_by_name($stmt, ":title", $title);
    oci_bind_by_name($stmt, ":rating", $rating);
    oci_bind_by_name($stmt, ":checklist", $checklist);
    oci_bind_by_name($stmt, ":reviewContent", $reviewContent);

    if (oci_execute($stmt)) {
        echo "리뷰가 성공적으로 등록되었습니다.";
        echo '<script>window.location.href = "index.php";</script>';
    } else {
        $e = oci_error($stmt);
        echo "Error: " . $e['message'];
    }

    oci_free_statement($stmt); // Statement 해제
}

oci_close($conn); // 데이터베이스 연결 해제
?>

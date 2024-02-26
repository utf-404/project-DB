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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['post-title'];
    $content = $_POST['post-content'];
    $category = $_POST['volunteer-field'];
    $date = $_POST['volunteer-date'];
    $local = $_POST['location-field'];
    $agree = isset($_POST['agreeCheck']) ? 'y' : 'n';

    
    

    // Prepared Statements를 사용하여 데이터베이스에 데이터 삽입
    $sql = "INSERT INTO NoticeBoard (NoticeBoard_title, NoticeBoard_text, NoticeBoard_category, NoticeBoard_date, NoticeBoard_local, NoticeBoard_agree) 
        VALUES (:bv_title, :bv_content, :bv_category, TO_DATE(:bv_date, 'YYYY-MM-DD'), :bv_local, :bv_agree)";

    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":bv_title", $title);
    oci_bind_by_name($stmt, ":bv_content", $content);
    oci_bind_by_name($stmt, ":bv_category", $category);
    oci_bind_by_name($stmt, ":bv_date", $date);
    oci_bind_by_name($stmt, ":bv_local", $local);
    oci_bind_by_name($stmt, ":bv_agree", $agree);


    if (oci_execute($stmt)) {
        echo "게시물이 성공적으로 추가되었습니다.";
        header("Location: index.php");
    } else {
        $e = oci_error($stmt);
        echo "Error: " . $e['message'];
    }

    oci_free_statement($stmt); // Prepared Statements 해제
}

oci_close($conn); // 데이터베이스 연결 해제
?>

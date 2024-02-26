<?php
$user = 'S13_502';
$pw = 'pw1234';
$servername = '203.249.87.57/orcl';

$conn = oci_connect($user, $pw, $servername);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // 선택한 게시물 삭제
    $stmt = oci_parse($conn, "DELETE FROM NOTICEBOARD WHERE NOTICEBOARD_ID = :post_id");
    oci_bind_by_name($stmt, ":post_id", $post_id);
    $execute = oci_execute($stmt);

    if ($execute) {
        header("Location: notice_list.php");
    } else {
        $e = oci_error($stmt);
        echo "Error: " . htmlentities($e['message'], ENT_QUOTES);
    }

    oci_free_statement($stmt);
}

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>리뷰 상세 보기</title>
  <link rel="stylesheet" type="text/css" href="review_list.css">
</head>
<body>
  <h1>리뷰 상세 정보</h1>
  <button onclick="window.location.href='review_list.php'">리뷰 목록</button>
  <div class="review-container">
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

    if (isset($_GET['id'])) {
        $review_id = $_GET['id'];

        $sql = "SELECT * FROM REVIEW_TIME WHERE REVIEW_TIME_ID = :review_id";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':review_id', $review_id);
        oci_execute($stmt);

        if ($row = oci_fetch_assoc($stmt)) {
            echo '<div class="review">';
            echo '<p class="review-info">아이디: ' . $row["REVIEW_TIME_LOGID"] . ' - 제목: ' . $row["REVIEW_TIME_TITLE"] . ' - 평점: ' . $row["REVIEW_TIME_SCORE"] . '</p>';
            echo '<p class="review-content">' . $row["REVIEW_TIME_TEXT"] . '</p>';
            echo '<div class="review-links">';
            echo '<a href="edit_review.php?id=' . $row["REVIEW_TIME_ID"] . '" class="edit-link">수정하기</a>';
            echo '<a href="delete_review.php?id=' . $row["REVIEW_TIME_ID"] . '" class="delete-link">삭제하기</a>';
            echo '<style>';
            echo '.review-links { margin-top: 10px; }';
            echo '.edit-link { margin-right: 10px; }';
            echo '</style>';
            echo '</div>';
            echo '</div>';
        } else {
            echo "해당 리뷰를 찾을 수 없습니다.";
        }

        oci_free_statement($stmt);
        oci_close($conn);
    }
    ?>
  </div>
</body>
</html>

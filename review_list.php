<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>리뷰 목록</title>
  <link rel="stylesheet" type="text/css" href="common.css"/>
  <link rel="stylesheet" href="dark.css">
  <link rel="stylesheet" href="review_list.css">
</head>
<body>
  <h1>리뷰 목록</h1>
  <button onclick="window.location.href='index.php'">게시판으로 이동</button>
  <div class="review-container">
    <?php
    $user = 'S13_502';
    $pw = 'pw1234';
    $servername = '203.249.87.57/orcl';

    $conn = oci_connect($user, $pw, $servername);

    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // 리뷰 데이터 가져오기
    $sql = "SELECT * FROM REVIEW_TIME";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);

    while ($row = oci_fetch_assoc($stmt)) {
        echo '<div class="review">';
        echo '<a href="review_detail.php?id=' . $row["REVIEW_TIME_ID"] . '">';
        echo '<p class="review-info">ID: ' . $row["REVIEW_TIME_LOGID"] . ' - 제목: ' . $row["REVIEW_TIME_TITLE"] . ' - 평점: ' . $row["REVIEW_TIME_SCORE"] . '</p>';
        echo '<p class="review-content">' . $row["REVIEW_TIME_TEXT"] . '</p>';
        echo '</a>';
        echo '</div>';
    }

    oci_close($conn);
    ?>
  </div>
</body>
</html>

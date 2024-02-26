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

    $sql = "SELECT * FROM review_time WHERE review_time_id = :review_id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":review_id", $review_id);
    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);

    if ($row) {
        $post = $row;
    } else {
        echo "해당하는 게시물이 없습니다.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_id = $_POST['review_id'];
    $title = $_POST['review_title'];
    $text = $_POST['review_text'];
    $score = $_POST['review_score'];

    // 게시물 업데이트
    $sql = "UPDATE review_time SET review_time_title=:title, review_time_text=:text, review_time_score=:score WHERE review_time_id=:review_id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":title", $title);
    oci_bind_by_name($stmt, ":text", $text);
    oci_bind_by_name($stmt, ":score", $score);
    oci_bind_by_name($stmt, ":review_id", $review_id);

    $execute = oci_execute($stmt);

    if ($execute) {
        header("Location: review_list.php");
        exit();
    } else {
        $e = oci_error($stmt);
        echo "Error: " . htmlentities($e['message'], ENT_QUOTES);
    }

    oci_free_statement($stmt);
}

oci_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>리뷰 수정</title>
  <link rel="stylesheet" type="text/css" href="common.css"/>
  <link rel="stylesheet" href="dark.css">
  <link rel="stylesheet" type="text/css" href="review.css">
  <link rel="stylesheet" type="text/css" href="edit.css">
</head>
<body>
  <h1>리뷰 수정</h1>
  <button onclick="window.location.href='review_list.php'">리뷰 목록</button>
  <div class="edit-review-form">
        <div class="container">
            <h2>리뷰 수정</h2>
            <form method="post" action="">
                <input type="hidden" name="review_id" value="<?php echo $post['REVIEW_TIME_ID']; ?>">
                <label for="review_title">제목:</label><br>
                <input type="text" id="review_title" name="review_title" value="<?php echo $post['REVIEW_TIME_TITLE']; ?>"><br>

                <label for="review_text">리뷰 내용:</label><br>
                <textarea id="review_text" name="review_text"><?php echo $post['REVIEW_TIME_TEXT']; ?></textarea><br>

                <label for="review_score">평점:</label><br>
                <input type="number" id="review_score" name="review_score" value="<?php echo $post['REVIEW_TIME_SCORE']; ?>"><br>

                <input type="submit" value="수정">
            </form>
        </div>
    </div>
</body>
</html>

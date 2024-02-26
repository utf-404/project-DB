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

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // 선택한 게시물 불러오기
    $sql = "SELECT * FROM NoticeBoard WHERE NoticeBoard_id = :post_id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":post_id", $post_id);
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
    $post_id = $_POST['post-id'];
    $title = $_POST['post-title'];
    $content = $_POST['post-content'];
    $category = $_POST['volunteer-field'];
    $date = $_POST['volunteer-date'];
    $local = $_POST['location-field'];
    $agree = isset($_POST['agreeCheck']) ? $_POST['agreeCheck'] : 'n';

    // 게시물 업데이트
    $sql = "UPDATE NoticeBoard 
        SET NoticeBoard_title = :bv_title, 
            NoticeBoard_text = :bv_content, 
            NoticeBoard_category = :bv_category, 
            NoticeBoard_date = :bv_date,
            NoticeBoard_local = :bv_local, 
            NoticeBoard_agree = :bv_agree 
        WHERE NoticeBoard_id = :bv_post_id";

    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":bv_title", $title);
    oci_bind_by_name($stmt, ":bv_content", $content);
    oci_bind_by_name($stmt, ":bv_category", $category);
    oci_bind_by_name($stmt, ":bv_date", $date); 
    oci_bind_by_name($stmt, ":bv_local", $local);
    oci_bind_by_name($stmt, ":bv_agree", $agree);
    oci_bind_by_name($stmt, ":bv_post_id", $post_id);


$execute = oci_execute($stmt);

if ($execute) {
    header("Location: notice_list.php");
} else {
    $e = oci_error($stmt);
    echo "Error: " . $e['message'];
}

oci_free_statement($stmt);
oci_close($conn);




    $execute = oci_execute($stmt);

    if ($execute) {
        header("Location: notice_list.php");
    } else {
        $e = oci_error($stmt); // 추가된 부분
        echo "Error: " . $e['message']; // 변경된 출력 부분
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
    <title>게시물 수정</title>
    <link rel="stylesheet" type="text/css" href="edit.css"> 
</head>
<body>

<div class="container">
    <h2>게시물 수정</h2>
    <form method="post" action="">
        <input type="hidden" name="post-id" value="<?php echo $post['NOTICEBOARD_ID']; ?>">
        <label for="post-title">제목:</label><br>
        <input type="text" id="post-title" name="post-title" value="<?php echo $post['NOTICEBOARD_TITLE']; ?>"><br>
        
        <label for="volunteer-field">Category:</label><br>
        <input type="text" id="volunteer-field" name="volunteer-field" value="<?php echo $post['NOTICEBOARD_CATEGORY']; ?>"><br>
        
        <label for="volunteer-date">Date:</label><br>
        <input type="text" id="volunteer-date" name="volunteer-date" value="<?php echo $post['NOTICEBOARD_DATE']; ?>"><br>
        
        <label for="location-field">Local:</label><br>
        <input type="text" id="location-field" name="location-field" value="<?php echo $post['NOTICEBOARD_LOCAL']; ?>"><br>
        
        <label for="post-content">Content:</label><br>
        <textarea id="post-content" name="post-content"><?php echo $post['NOTICEBOARD_TEXT']; ?></textarea><br>
        
        <label for="agreeCheck">Agree:</label><br>
        <input type="checkbox" id="agreeCheck" name="agreeCheck" value="y" <?php echo ($post['NOTICEBOARD_AGREE'] === 'y') ? 'checked' : ''; ?>><br>
        
        <input type="submit" value="수정">
    </form>
</div>

</body>
</html>
<?php
putenv("NLS_LANG=AMERICAN_AMERICA.AL32UTF8");

session_start();

$user = 'S13_502';
$pw = 'pw1234';
$servername = '203.249.87.57/orcl';

$conn = oci_connect($user, $pw, $servername);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$selectedPost = null;

// 게시물 ID가 설정되었는지 확인하고 해당 ID의 게시물 가져오기
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM NOTICEBOARD WHERE NOTICEBOARD_ID = :id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":id", $id);
    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);

    if ($row) {
        $selectedPost = $row;
    } else {
        echo "해당 ID의 게시물을 찾을 수 없습니다.";
    }
}

$sql = "SELECT * FROM NOTICEBOARD";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);

$posts = [];

while ($row = oci_fetch_assoc($stmt)) {
    $posts[] = $row;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>봉사 모집</title>
  <link rel="stylesheet" type="text/css" href="notice_list.css">
  <link rel="stylesheet" type="text/css" href="common.css"/>
</head>
<body>
  <header>
    <h1>게시물 목록</h1>
    <button onclick="window.location.href='review.html'">리뷰</button>
    <button onclick="window.location.href='index.php'">게시물 작성</button>
  </header>

  <section class="post-details">
    <?php if ($selectedPost !== null): ?>
      <div class="post" style="display: flex; flex-direction: column; align-items: center; min-width: 500px;">
        <h2 style="padding: 8px 15px; border-radius: 10px; color: #fff; background-color: #221d50;"><?php echo $selectedPost['NOTICEBOARD_TITLE']; ?></h2>
        <!-- 수정하기 및 삭제하기 링크 -->
        <div class="post-options style="display: flex;">
          <a href="edit_post.php?id=<?php echo $selectedPost['NOTICEBOARD_ID']; ?>">수정하기</a>
          <a href="delete_post.php?id=<?php echo $selectedPost['NOTICEBOARD_ID']; ?>">삭제하기</a>
        </div>
        <!-- 수정하기 및 삭제하기 링크 -->
        <div class="post-details">
          <p><strong>ID:</strong> <?php echo $selectedPost['NOTICEBOARD_ID']; ?></p>
          <p><strong>Category:</strong> <?php echo $selectedPost['NOTICEBOARD_CATEGORY']; ?></p>
          <p><strong>Date:</strong> <?php echo $selectedPost['NOTICEBOARD_DATE']; ?></p>
          <p><strong>Local:</strong> <?php echo $selectedPost['NOTICEBOARD_LOCAL']; ?></p>
          <p><strong>Agree:</strong> <?php echo $selectedPost['NOTICEBOARD_AGREE']; ?></p>
        </div>
        <div class="post-content">
          <?php echo $selectedPost['NOTICEBOARD_TEXT']; ?>
        </div>
      </div>
    <?php endif; ?>
  </section>

  
  <section class="board">
    <h2>게시물 목록</h2>
    <ul id="post-list">
      <?php foreach ($posts as $post): ?>
        <li>
          <a href="notice_list.php?id=<?php echo $post['NOTICEBOARD_ID']; ?>">
            <?php echo $post['NOTICEBOARD_TITLE']; ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>
</body>
</html>
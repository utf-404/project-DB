<?php
putenv("NLS_LANG=AMERICAN_AMERICA.AL32UTF8");

session_start();

if (!isset($_SESSION['volunteer_loggedin']) || $_SESSION['volunteer_loggedin'] !== true) {
    header("Location: login_form_give.php");
    exit;
}

$user = 'S13_502';
$pw = 'pw1234';
$servername = '203.249.87.57/orcl';

$conn = oci_connect($user, $pw, $servername);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$sql = "SELECT volunteer_name, volunteer_email FROM volunteer_time WHERE volunteer_id = :id";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ":id", $_SESSION['volunteer_id']);
oci_execute($stmt);

$row = oci_fetch_assoc($stmt);
$username = $row['VOLUNTEER_NAME'];
$email = $row['VOLUNTEER_EMAIL'];

$userInfo = json_encode(['username' => $username, 'email' => $email]);

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

if (isset($_POST['delete_account'])) {
    $sql_delete = "DELETE FROM volunteer_time WHERE volunteer_id = :id";
    $stmt_delete = oci_parse($conn, $sql_delete);
    oci_bind_by_name($stmt_delete, ":id", $_SESSION['volunteer_id']);

    if (oci_execute($stmt_delete)) {
        session_destroy();
        header("Location: index.php");
        exit;
    } else {
        echo "탈퇴에 실패했습니다.";
    }
}

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>기부자 마이페이지</title>
  <link rel="stylesheet" type="text/css" href="mypage.css">
</head>
<body>
<header>
    <h1>기부자 MYPAGE</h1>
    <a href="index.php?logout=true"><button>로그아웃</button></a> 
    <button onclick="window.location.href='index.php'">게시판으로 이동</button>
  </header>
  
  <main>
    <section class="profile">
      <h2>프로필</h2>
      <p id="username">사용자 이름: <?php echo $username; ?></p>
      <p id="email">이메일: <?php echo $email; ?></p>
    </section>

    <section class="activity">
      <h2>활동 내역</h2>
      <!-- 사용자의 활동 내역을 표시할 부분 -->
    </section>

    <section class="account-actions">
      <form method="post">
        <input type="submit" name="delete_account" value="계정 탈퇴" onclick="return confirm('정말로 계정을 삭제하시겠습니까? 이 작업은 되돌릴 수 없습니다.')">
      </form>
    </section>
    
  </main>

  <footer>
    <p>&copy; 2023 HONGIKVoluneer. All rights reserved.</p>
  </footer>

  <script>
    const userInfo = <?php echo $userInfo; ?>;
    document.getElementById('username').innerText = `사용자 이름: ${userInfo.username}`;
    document.getElementById('email').innerText = `이메일: ${userInfo.email}`;
  </script>
</body>
</html>

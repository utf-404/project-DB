<?php

putenv("NLS_LANG=AMERICAN_AMERICA.AL32UTF8");

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // 로그인이 되어있지 않은 경우 로그인 페이지로 리디렉션
    header("Location: login_form_get.php");
    exit;
}

// 여기서부터는 로그인된 사용자의 정보를 표시하는 코드
$user = 'S13_502';
$pw = 'pw1234';
$servername = '203.249.87.57/orcl';

$conn = oci_connect($user, $pw, $servername);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// 사용자 정보 가져오기
$sql = "SELECT served_name, served_email FROM served_time WHERE served_id = :id";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ":id", $_SESSION['id']);
oci_execute($stmt);

$row = oci_fetch_assoc($stmt);
$username = $row['SERVED_NAME'];
$email = $row['SERVED_EMAIL'];

// 사용자 정보를 JSON 형식으로 반환
$userInfo = json_encode(['username' => $username, 'email' => $email]);

// 로그아웃 처리
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// 탈퇴 처리
if (isset($_POST['delete_account'])) {
    $sql_delete = "DELETE FROM served_time WHERE idserved_id = :id";
    $stmt_delete = oci_parse($conn, $sql_delete);
    oci_bind_by_name($stmt_delete, ":id", $_SESSION['id']);

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
  <title>수혜자 마이페이지</title>
  <link rel="stylesheet" type="text/css" href="mypage.css">
</head>
<body>
  <header>
    <h1>수혜자 MYPAGE</h1>
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

  <!-- 사용자 정보를 JS로 가져와서 프로필에 반영하는 스크립트 -->
  <script>
    const userInfo = <?php echo $userInfo; ?>;
    document.getElementById('username').innerText = `사용자 이름: ${userInfo.username}`;
    document.getElementById('email').innerText = `이메일: ${userInfo.email}`;
  </script>
</body>
</html>

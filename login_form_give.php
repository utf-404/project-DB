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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $password = isset($_POST['pswd1']) ? $_POST['pswd1'] : '';

    $sql = "SELECT volunteer_pw FROM volunteer_time WHERE volunteer_id = :id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":id", $id);
    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);

    if ($row) {
        $stored_password = $row['VOLUNTEER_PW'];

        // 비밀번호 검증 - 비밀번호를 암호화하지 않았으므로 일치 여부를 직접 비교
        if ($password === $stored_password) {
            // 로그인 성공 시의 처리
            session_start();
            $_SESSION['volunteer_loggedin'] = true;
            $_SESSION['volunteer_id'] = $id; // 사용자 ID 또는 필요한 정보

            // 로그인 성공 후 페이지로 이동
            header("Location: mypage_give.php");
            exit();
        }
    }

    // 로그인 실패 시 로그인 페이지로 리디렉션 및 오류 메시지 출력
    $_SESSION['login_error'] = true;
    header("Location: login_form_give.html");
    exit();
}

oci_close($conn);
?>

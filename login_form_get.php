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
    $id = isset($_POST['served_id']) ? $_POST['served_id'] : '';
    $password = isset($_POST['served_pw']) ? $_POST['served_pw'] : '';

    // 입력받은 아이디를 기준으로 데이터베이스에서 비밀번호 조회
    $sql = "SELECT served_id, served_pw FROM served_time WHERE served_id = :id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":id", $id);
    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);

    if ($row) {
        $stored_password = $row['SERVED_PW'];

        // 입력한 비밀번호와 DB에서 가져온 비밀번호 비교
        if ($password === $stored_password) {
            // 로그인 성공 시의 처리
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id; // 사용자 ID 또는 필요한 정보

            // 로그인 성공 후 페이지로 이동
            header("Location: mypage_get.php");
            exit();
        }
    }

    // 로그인 실패 시 로그인 페이지로 리디렉션 및 오류 메시지 출력
    $_SESSION['login_error'] = true;
    header("Location: login_form_get.html");
    exit();
}

oci_close($conn);
?>

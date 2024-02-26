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
    $username = isset($_POST['served_name']) ? $_POST['served_name'] : '';
    $email = isset($_POST['served_email']) ? $_POST['served_email'] : '';
    $phonenum = isset($_POST['served_phonenum']) ? $_POST['served_phonenum'] : '';
    $disabledCheck = isset($_POST['served_dissabledCheck']) ? $_POST['served_dissabledCheck'] : 'n';
    $disabled = isset($_POST['served_disabled']) ? $_POST['served_disabled'] : '';
    $ageCheck = isset($_POST['served_ageCheck']) ? $_POST['served_ageCheck'] : 'n';
    $age = isset($_POST['served_age']) ? $_POST['served_age'] : null;

    if ($age !== null) {
        // 입력된 값이 null이 아니고 날짜 형식과 일치하지 않으면 처리
        if (!strtotime($age)) {
            // 유효하지 않은 형식일 경우, 에러 메시지 표시 또는 기본 값 설정
            $age = null; // 또는 기본 날짜로 설정
        }
    }

    $check_existing_id = oci_parse($conn, "SELECT served_id FROM served_time WHERE served_id = :id");
    oci_bind_by_name($check_existing_id, ":id", $id);
    oci_execute($check_existing_id);

    $row = oci_fetch_assoc($check_existing_id);
    if ($row) {
        echo '<div style="background-color: lightgreen; padding: 10px;">이미 사용 중인 ID입니다. 다른 ID를 선택해주세요.</div>';
    } else {
        $stmt = oci_parse($conn, "INSERT INTO served_time (served_id, served_pw, served_name, served_email, served_phonenum, served_dissabledCheck, served_disabled, served_ageCheck, served_age) VALUES (:id, :password, :username, :email, :phonenum, :disabledCheck, :disabled, :ageCheck, TO_DATE(:age, 'YYYY-MM-DD'))");


        oci_bind_by_name($stmt, ":id", $id);
        oci_bind_by_name($stmt, ":password", $password);
        oci_bind_by_name($stmt, ":username", $username);
        oci_bind_by_name($stmt, ":email", $email);
        oci_bind_by_name($stmt, ":phonenum", $phonenum);
        oci_bind_by_name($stmt, ":disabledCheck", $disabledCheck);
        oci_bind_by_name($stmt, ":disabled", $disabled);
        oci_bind_by_name($stmt, ":ageCheck", $ageCheck);
        oci_bind_by_name($stmt, ":age", $age);

        $execute = oci_execute($stmt);
        if ($execute) {
            echo '<div style="background-color: lightgreen; padding: 10px;">새 레코드가 성공적으로 생성되었습니다</div>';
            header("Location: index.php");
            exit();
        } else {
            $e = oci_error($stmt);
            echo '<div style="background-color: indianred; padding: 10px;">오류: ' . htmlentities($e['message'], ENT_QUOTES) . '</div>';
        }
    }

    oci_free_statement($check_existing_id);
    oci_free_statement($stmt);
}

oci_close($conn);
?>

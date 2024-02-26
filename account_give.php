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
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phonenum = isset($_POST['phonenum']) ? $_POST['phonenum'] : '';
    $education = isset($_POST['educationCheck']) ? $_POST['educationCheck'] : 'n';

    $check_existing_id = oci_parse($conn, "SELECT VOLUNTEER_ID FROM VOLUNTEER_TIME WHERE VOLUNTEER_ID = :id");
    oci_bind_by_name($check_existing_id, ":id", $id);
    oci_execute($check_existing_id);

    $row = oci_fetch_assoc($check_existing_id);
    if ($row) {
        echo '<div style="background-color: lightgreen; padding: 10px;">이미 사용 중인 ID입니다. 다른 ID를 선택해주세요.</div>';
    } else {
        $stmt = oci_parse($conn, "INSERT INTO VOLUNTEER_TIME (VOLUNTEER_ID, VOLUNTEER_PW, VOLUNTEER_NAME, VOLUNTEER_EMAIL, VOLUNTEER_PNUM, VOLUNTEER_EDUCATION) VALUES (:id, :password, :username, :email, :phonenum, :education)");

        oci_bind_by_name($stmt, ":id", $id);
        oci_bind_by_name($stmt, ":password", $password);
        oci_bind_by_name($stmt, ":username", $username);
        oci_bind_by_name($stmt, ":email", $email);
        oci_bind_by_name($stmt, ":phonenum", $phonenum);
        oci_bind_by_name($stmt, ":education", $education);

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

<?php
include "config.php";
session_start();

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}
$send_id = $_GET['send_id']; //송신자 이메일
$rv_id = $_POST['rv_id']; //수신자 이메일
$subject = $_POST['subject']; // 제목
$content = $_POST['content']; // 내용
$regist_day = date("Y-m-d H:i"); // 쪽지 보낸 시간

// 수신이메일이 존재하는지
$sql = "SELECT hm_email FROM hmatch WHERE hm_email = '$rv_id' UNION SELECT u_email FROM user WHERE u_email = '$rv_id' UNION SELECT n_email FROM nuser WHERE n_email = '$rv_id' UNION SELECT k_email FROM kuser WHERE k_email = '$rv_id'";
$res = $connect->query($sql);
$row = $res->fetch();

if ($row) {
    // message테이블에 저장
    $sql = "INSERT INTO msgrv(send_id, rv_id, subject, content, regist_day, rv_check) ";
    $sql .= "VALUES('$send_id','$rv_id','$subject','$content','$regist_day', 'n')";
    $connect->query($sql);

    $sql2 = "INSERT INTO msgsend(send_id, rv_id, subject, content, regist_day, rv_check) ";
    $sql2 .= "VALUES('$send_id','$rv_id','$subject','$content','$regist_day', 'n')";
    $connect->query($sql2);

    $updsql = "SET @COUNT = 0;";
    $updsql .= "UPDATE msgrv SET num = @COUNT:=@COUNT+1;";
    $connect->query($updsql);

    $updsql2 = "SET @COUNT = 0;";
    $updsql2 .= "UPDATE msgsend SET num = @COUNT:=@COUNT+1;";
    $connect->query($updsql2);

    echo "<script>alert('전송완료'); opener.location.reload('/hongber/php/match.php'); self.close();</script>";
} else {
    echo "<script>alert('수신 아이디가 잘못되었습니다.'); opener.location.reload('/hongber/php/match.php'); self.close();</script>";
    exit;
}

$connect = null;
?>
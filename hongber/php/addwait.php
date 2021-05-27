<?php
include "config.php";
session_start();

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token']) && !isset($_SESSION["mislog"])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}

if (!isset($_SESSION['uislog'])) {
} else {
    $name = $_SESSION['uname'];
    $email = $_SESSION['uemail'];
}
if (!isset($_SESSION['naver_access_token'])) {
} else {
    $name = $_SESSION['nname'];
    $email = $_SESSION['nemail'];
}
if (!isset($_SESSION['kakao_access_token'])) {
} else {
    $name = $_SESSION['kname'];
    $email = $_SESSION['kemail'];
}

$adv_e = $_POST['adv_e'];
$adv_n = $_POST['adv_n'];
date_default_timezone_set('Asia/Seoul');
$wait_day = date("Y-m-d H:i");

if ($adv_e != null && $adv_n != null) {
    $sql = "SELECT * FROM addwait WHERE adv_email = '$adv_e' AND adv_name = '$adv_n' AND wait_email = '$email' AND wait_name = '$name'";
    $res = $connect->query($sql);
    $row = $res->fetch();
    if ($row) {
        echo "<script>alert('이미 줍기 신청한 광고입니다.'); location.replace('/hongber/php/pickup.php')</script>";
    } else {
        $sql2 = "INSERT INTO addwait(adv_email, adv_name, wait_email, wait_name, wait_status, wait_day) ";
        $sql2 .= "VALUES('$adv_e','$adv_n','$email','$name','wait', '$wait_day')";
        $res2 = $connect->query($sql2);

        $updsql = "SET @COUNT = 0;";
        $updsql .= "UPDATE addwait SET num = @COUNT:=@COUNT+1;";
        $connect->query($updsql);

        echo "<script>alert('광고 줍기가 신청되었습니다. 이후 광고주에 수락에 따라 광고를 진행하실 수 있습니다.'); location.replace('../index.php');</script>";
    }
} else {
    echo "<script>alert('광고 줍기에 실패하였습니다. 다시시도 해주세요.'); location.replace('/hongber/php/pickup.php')</script>";
}

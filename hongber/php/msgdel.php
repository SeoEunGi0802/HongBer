<?php
include "config.php";
session_start();

$mode = $_GET['mode'];
$num = $_POST['del'];

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token']) && !isset($_SESSION["mislog"])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}

if (!isset($_SESSION['hislog'])) {
} else {
    $email = $_SESSION['hemail'];
}

if (!isset($_SESSION['uislog'])) {
} else {
    $email = $_SESSION['uemail'];
}

if (!isset($_SESSION['naver_access_token'])) {
} else {
    $email = $_SESSION['nemail'];
}

if (!isset($_SESSION['kakao_access_token'])) {
} else {
    $email = $_SESSION['kemail'];
}

if ($mode == "send") {
    for ($i = 0; $i < sizeof($num); $i++) {
        $sql = "DELETE FROM msgsend WHERE num = $num[$i]";
        $connect->query($sql);
    }
    $updsql = "SET @COUNT = 0;";
    $updsql .= "UPDATE msgsend SET num = @COUNT:=@COUNT+1;";
    $connect->query($updsql);

    echo "<script>alert('삭제완료'); history.back()</script>";
} else {
    for ($i = 0; $i < sizeof($num); $i++) {
        $sql = "DELETE FROM msgrv WHERE num = $num[$i]";
        $connect->query($sql);
    }
    $updsql = "SET @COUNT = 0;";
    $updsql .= "UPDATE msgrv SET num = @COUNT:=@COUNT+1;";
    $connect->query($updsql);

    echo "<script>alert('삭제완료'); history.back()</script>";
}

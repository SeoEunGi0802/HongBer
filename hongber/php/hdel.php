<?php
include "config.php";
session_start();

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}
if (!isset($_SESSION['hislog'])) {
} else {
    $id = $_SESSION['hid'];
    $name = $_SESSION['hname'];
}

$sql = "DELETE FROM hmatch WHERE hm_id = '$id' AND hm_name = '$name'";
if ($connect->query($sql)) {
    echo "<script>alert('삭제되었습니다.'); opener.location.reload('/hongber/php/match.php'); self.close();</script>";
} else {
    echo "<script>alert('실패하셨습니다.'); opener.location.reload('/hongber/php/match.php'); self.close();</script>";
}
?>
<?php
include "config.php";
session_start();

$u_id = $_POST["id"];
$u_pwd = $_POST["pwd"];

$sp_t = "/[][`~!#$%^&*|\\\'\";:\/?^=^+_(){}<>]/";

if (preg_match($sp_t, $_POST["id"]) || preg_match($sp_t, $_POST["pwd"])) {
    echo "<script>alert('허용되지 않은 문자가 포함되어 있습니다.'); location.href='/hongber/index.php'</script>";
} else {
    $usql = "SELECT * FROM user WHERE u_id = '$u_id' AND u_pwd = '$u_pwd'";
    $ures = $connect->query($usql);
    $urow = $ures->fetch();

    $msql = "SELECT * FROM hbmaster WHERE mid = '$u_id' AND mpwd = '$u_pwd'";
    $mres = $connect->query($msql);
    $mrow = $mres->fetch();

    if ($urow != null  || $mrow != null) {
        if ($urow != null) {
            $_SESSION['uislog'] = true;
            $_SESSION['uname'] = $urow['u_name'];
            $_SESSION['uid'] = $urow['u_id'];
            $_SESSION['upwd'] = $urow['u_pwd'];
            $_SESSION['uemail'] = $urow['u_email'];
            $uname = $_SESSION['uname'];

            echo "<script>alert('홍버 {$uname}님 어서오세요.'); location.href='/hongber/index.php'</script>";
        }
        if ($mrow != null) {
            $_SESSION['mislog'] = true;
            $_SESSION['mname'] = $mrow['mname'];
            $_SESSION['mid'] = $mrow['mid'];
            $mname = $_SESSION['mname'];

            echo "<script>alert('관리자 {$mname}님 어서오세요.'); location.href='/hongber/index.php'</script>";
        }
    }

    if ($urow == null) {
        echo "<script>alert('등록되지 않은 사용자 이거나 아이디 혹은 비밀번호가 틀렸습니다. 다시 시도하여 주십시오.'); history.back(-1);</script>";
    }
}
$connect = null;

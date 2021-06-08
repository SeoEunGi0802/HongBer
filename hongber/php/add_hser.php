<?php
include "config.php";

$h_id = $_POST["id"];
$h_pwd = $_POST["pwd"];
$h_name = $_POST["name"];
$h_phone = $_POST["phone"];
$h_email = $_POST["email"];
$h_msg = $_POST["msg"];

$sp_t = "/[][`~!#$%^&*|\\\'\";:\/?^=^+_(){}<>]/";

if (preg_match($sp_t, $_POST["id"]) || preg_match($sp_t, $_POST["pwd"]) || preg_match($sp_t, $_POST["name"]) || preg_match($sp_t, $_POST["phone"]) || preg_match($sp_t, $_POST["email"]) || preg_match($sp_t, $_POST["msg"])) {
    echo "<script>alert('허용되지 않은 문자가 포함되어 있습니다.'); location.href='/hongber/index.php'</script>";
} else {
    $sql = "SELECT h_email FROM hser where h_email = '$h_email' AND h_name = '$h_name' AND h_phone = '$h_phone'";
    $res = $connect->query($sql);
    $row = $res->fetch();

    $sql2 = "SELECT u_email FROM user where u_email = '$h_email' AND u_name = '$h_name' AND u_phone = '$h_phone'";
    $res2 = $connect->query($sql2);
    $row2 = $res2->fetch();

    $sql3 = "SELECT k_email FROM kuser where k_email = '$h_email'";
    $res3 = $connect->query($sql3);
    $row3 = $res3->fetch();

    $sql4 = "SELECT n_email FROM nuser where n_email = '$h_email' OR n_phone = '$h_phone'";
    $res4 = $connect->query($sql4);
    $row4 = $res4->fetch();

    if (!empty($row) || !empty($row2) || !empty($row3) || !empty($row4)) {
        echo "<script>alert('회원가입에 실패하였습니다. 다시 시도해주세요.'); location.href='/hongber/php/ber_reg2.php'</script>";
    } else {
        $sql = "INSERT INTO hser (h_id, h_pwd, h_name, h_phone, h_email, h_msg)";
        $sql = $sql . "values('$h_id','$h_pwd','$h_name','$h_phone', '$h_email', '$h_msg')";
        $res = $connect->query($sql);
        echo "<script>alert('{$h_name}님 가입 되셨습니다.'); location.href='../index.php'</script>";
    }
}
$connect = null;

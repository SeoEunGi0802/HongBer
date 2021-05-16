<?php
include "config.php";

$u_id = $_POST["id"];
$u_pwd = $_POST["pwd"];
$u_name = $_POST["name"];
$u_phone = $_POST["phone"];
$u_email = $_POST["email"];
$u_msg = $_POST["msg"];

$sql = "SELECT u_email FROM user where u_email = '$u_email' OR u_phone = '$u_phone'";
$res = $connect->query($sql);
$row = $res->fetch();

$sql2 = "SELECT h_email FROM hser where h_email = '$u_email' OR h_phone = '$u_phone'";
$res2 = $connect->query($sql2);
$row2 = $res2->fetch();

$sql3 = "SELECT k_email FROM kuser where k_email = '$u_email'";
$res3 = $connect->query($sql3);
$row3 = $res3->fetch();

$sql4 = "SELECT n_email FROM nuser where n_email = '$u_email' OR n_phone = '$u_phone'";
$res4 = $connect->query($sql4);
$row4 = $res4->fetch();

if (!empty($row) || !empty($row2) || !empty($row3) || !empty($row4)) {
    echo "<script>alert('회원가입에 실패하였습니다. 다시 시도해주세요.'); location.href='/hongber/php/ber_reg.php'</script>";
} else {
    $sql = "insert into user (u_id, u_pwd, u_name, u_phone, u_email, u_msg)";
    $sql = $sql . "values('$u_id','$u_pwd','$u_name','$u_phone', '$u_email', '$u_msg')";
    $res = $connect->query($sql);
    echo "<script>alert('{$u_name}님 가입 되셨습니다.'); location.href='../index.php'</script>";
}

$connect = null;
?>
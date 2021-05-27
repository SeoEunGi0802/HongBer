<?php
include "config.php";
session_start();

$status = $_GET['st'];
$num = $_POST['del'];
if ($num == null) {
    echo "<script>alert('먼저 선택을 해주세요'); location.href='/hongber/php/addbox.php'</script>";
}

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token']) && !isset($_SESSION["mislog"])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}

if ($status == "ac") {
    for ($i = 0; $i < sizeof($num); $i++) {
        $sql = "UPDATE addwait SET wait_status = 'accept' WHERE num = $num[$i]";
        $connect->query($sql);

        $sql2 = "SELECT * FROM addwait WHERE num = $num[$i]";
        $res2 = $connect->query($sql2);
        $row2 = $res2->fetch();
        $adv_e = $row2['adv_email'];
        $adv_n = $row2['adv_name'];
        $email = $row2['wait_email'];
        $name = $row2['wait_name'];

        $sql3 = "SELECT spread_sd, spread_ed, introduce_prod, spread_tool, spread_oc FROM spread WHERE spread_id = '$adv_e' AND spread_name = '$adv_n'";
        $res3 = $connect->query($sql3);
        $row3 = $res3->fetch();
        $sp_sd = $row3[0];
        $sp_ed = $row3[1];
        $sp_pd = $row3[2];
        $sp_tl = $row3[3];
        $sp_oc = $row3[4];

        $sql4 = "INSERT INTO mying(mying_sd, mying_ed, mying_email, mying_name, mying_prod, mying_tool, mying_oc) ";
        $sql4 .= "VALUES ('$sp_sd', '$sp_ed', '$email', '$name', '$sp_pd', '$sp_tl', '$sp_oc')";
        $connect->query($sql4);

        $updsql = "SET @COUNT = 0;";
        $updsql .= "UPDATE mying SET num = @COUNT:=@COUNT+1;";
        $connect->query($updsql);
    }

    $updsql = "SET @COUNT = 0;";
    $updsql .= "UPDATE addwait SET num = @COUNT:=@COUNT+1;";
    $connect->query($updsql);

    echo "<script>alert('수락완료'); history.back()</script>";
} else {
    for ($i = 0; $i < sizeof($num); $i++) {
        $sql = "UPDATE addwait SET wait_status = 'deny' WHERE num = $num[$i]";
        $connect->query($sql);
    }

    $updsql = "SET @COUNT = 0;";
    $updsql .= "UPDATE addwait SET num = @COUNT:=@COUNT+1;";
    $connect->query($updsql);

    echo "<script>alert('거절완료'); history.back()</script>";
}

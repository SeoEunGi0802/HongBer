<?php
include "config.php";
include "config2.php";
session_start();

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}
$hm_name = $_POST["name"];
$hm_r = $_POST["resolution"];
$hm_sd = $_POST["start_d"];
$hm_ed = $_POST["end_d"];
$category = $_POST["category"];
date_default_timezone_set('Asia/Seoul');
$hm_day = date("Y-m-d H:i");

if (!isset($_SESSION['hislog'])) {
} else {
    $hid = $_SESSION['hid'];
    $hemail = $_SESSION['hemail'];
    $hsql = "SELECT h_pimg FROM hser WHERE h_email = '$hemail'";
    $hres = $connect->query($hsql);
    $hrow = $hres->fetch();
    $profile_img = $hrow['h_pimg'];
}

$sql = "SELECT * FROM hmatch WHERE hm_id = '$hid'";
$res = $connect->query($sql);
$row = $res->fetch();

if (empty($row)) {

    $sql = "INSERT INTO hmatch (hm_id, hm_email, hm_sd, hm_ed, hm_name, hm_r, hm_pimg, hm_day, category)";
    $sql = $sql . "VALUES('$hid', '$hemail', '$hm_sd', '$hm_ed', '$hm_name', '$hm_r', '$profile_img', '$hm_day', '$category')";
    $res = $connect->query($sql);

    if ($res) {
        $usql = "SET @COUNT = 0;";
        $usql = $usql . "UPDATE hmatch SET hm_num = @COUNT:=@COUNT+1;";
        $connect->query($usql);
    } else {
        echo "<script>alert('광고 매칭 등록에 실패하였습니다. 다시 시도해주세요.'); location.href='/hongber/php/match.php'</script>";
    }

    if (is_uploaded_file($_FILES['file']['tmp_name']) && getimagesize($_FILES['file']['tmp_name']) != false) {
        $size = getimagesize($_FILES['file']['tmp_name']);
        $type = $size['mime'];
        $imgfp = fopen($_FILES['file']['tmp_name'], 'rb');
        $size = $size[3];
        $name = $_FILES['file']['name'];
        $maxsize = 99999999;

        if ($_FILES['file']['size'] < $maxsize) {
            $stmt = $dbcon->prepare("UPDATE hmatch SET hm_upimg = ? WHERE hm_email = '$hemail'");
            $stmt->bindParam(1, $imgfp, PDO::PARAM_LOB);
            $stmt->execute();

            $sql2 = "SELECT * FROM hmatch WHERE hm_email = '$hemail'";
            $res2 = $connect->query($sql2);
            $row2 = $res2->fetch();
            $ti = 'data:image/png;base64,' . base64_encode($row2['hm_upimg']);
            $stmt = $dbcon->prepare("UPDATE hmatch SET hm_upimg = ? WHERE hm_email = '$hemail'");
            $stmt->bindParam(1, $ti, PDO::PARAM_LOB);
            $stmt->execute();

            echo "<script>alert('광고가 등록 되었습니다.'); location.href='/hongber/php/match.php'</script>";
        } else {
            echo "<script>alert('사진의 크기가 너무 큽니다.'); location.href='/hongber/php/match.php'</script>";
        }
    } else {
        $sql = "DELETE FROM hmatch WHERE hm_email = '$hemail'";
        $connect->query($sql);
        echo "<script>alert('사진을 등록해주세요.'); history.back();</script>";
    }
} else {
    echo "<script>alert('광고 등록은 계정당 1개입니다.'); location.href='/hongber/php/match.php'</script>";
}

$connect = null;

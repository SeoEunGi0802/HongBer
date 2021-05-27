<?php
include "config.php";
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);


if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token']) && !isset($_SESSION["mislog"])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}

$name = $_POST['name'];
$email = $_POST['email'];
$star = $_POST['star'];

if (!isset($_SESSION['hislog'])) {
} else {
    $hname = $_SESSION['hname'];
    $hemail = $_SESSION['hemail'];
    if ($email == $hemail) {
        echo "<script>alert('자신에게 별점을 줄수는 없습니다.'); history.back(-1)</script>";
    } else {
        $sql = "SELECT * FROM rating WHERE rating_email = '$hemail' AND berating_email = '$email'";
        $res = $connect->query($sql);
        $row = $res->fetch();
        if (empty($row)) {
            $sql = "INSERT INTO rating (rating_email, berating_email, star_score)";
            $sql .= "values('$hemail', '$email', '$star')";
            $connect->query($sql);
            echo "<script>alert('{$email}님께 별점{$star}을 주었습니다.'); history.back(-1)</script>";
        } else {
            echo "<script>alert('이미 별점을 준 상대 입니다.'); history.back(-1)</script>";
        }
    }
}

if (!isset($_SESSION['uislog'])) {
} else {
    $uname =  $_SESSION['uname'];
    $uemail = $_SESSION['uemail'];
    $sql = "SELECT * FROM rating WHERE rating_email = '$uemail' AND berating_email = '$email'";
    $res = $connect->query($sql);
    $row = $res->fetch();
    if (empty($row)) {
        $sql = "INSERT INTO rating (rating_email, berating_email, star_score)";
        $sql .= "values('$uemail', '$email', '$star')";
        $connect->query($sql);
        echo "<script>alert('{$email}님께 별점{$star}을 주었습니다.'); history.back(-1)</script>";
    } else {
        echo "<script>alert('이미 별점을 준 상대 입니다.'); history.back(-1)</script>";
    }
}

if (!isset($_SESSION['naver_access_token'])) {
} else {
    $nname = $_SESSION['nname'];
    $nemail = $_SESSION['nemail'];
    $sql = "SELECT * FROM rating WHERE rating_email = '$nemail' AND berating_email = '$email'";
    $res = $connect->query($sql);
    $row = $res->fetch();
    if (empty($row)) {
        $sql = "INSERT INTO rating (rating_email, berating_email, star_score)";
        $sql .= "values('$nemail', '$email', '$star')";
        $connect->query($sql);
        echo "<script>alert('{$email}님께 별점{$star}을 주었습니다.'); history.back(-1)</script>";
    } else {
        echo "<script>alert('이미 별점을 준 상대 입니다.'); history.back(-1)</script>";
    }
}

if (!isset($_SESSION['kakao_access_token'])) {
} else {
    $kname = $_SESSION['kname'];
    $kemail = $_SESSION['kemail'];
    $sql = "SELECT * FROM rating WHERE rating_email = '$kemail' AND berating_email = '$email'";
    $res = $connect->query($sql);
    $row = $res->fetch();
    if (empty($row)) {
        $sql = "INSERT INTO rating (rating_email, berating_email, star_score)";
        $sql .= "values('$kemail', '$email', '$star')";
        $connect->query($sql);
        echo "<script>alert('{$email}님께 별점{$star}을 주었습니다.'); history.back(-1)</script>";
    } else {
        echo "<script>alert('이미 별점을 준 상대 입니다.'); history.back(-1)</script>";
    }
}

$sql = "SET @COUNT = 0;";
$sql .= "UPDATE rating SET num = @COUNT:=@COUNT+1;";
$connect->query($sql);

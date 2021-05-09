<?php
include "config.php";
include "config2.php";
session_start();
//error_reporting(0);

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}
if (!isset($_SESSION['hislog'])) {
} else {
    $sp_name = $_SESSION['hname'];
    $sp_email = $_SESSION['hemail'];
    $sd = $_POST['sd'];
    $ed = $_POST['ed'];
    $add = $_POST['add'];
    $prod = $_POST['prod'];
    $checklist = $_POST['checklist'];
    $recper = $_POST['recper'];
}
$sql = "SELECT * FROM spread WHERE spread_id = '$sp_email'";
$res = $connect->query($sql);
$row = $res->fetch();

if (empty($row)) {
    $sql2 = "INSERT INTO spread (spread_id, spread_name, spread_sd, spread_ed, introduce_add, introduce_prod, checklist, bespread_num)";
    $sql2 = $sql2 . "VALUES('$sp_email', '$sp_name', '$sd', '$ed', '$add', '$prod', '$checklist', '$recper')";
    $connect->query($sql2);

    $updsql = "SET @COUNT = 0;";
    $updsql .= "UPDATE spread SET num = @COUNT:=@COUNT+1;";
    $connect->query($updsql);

    if (is_uploaded_file($_FILES['file']['tmp_name']) && getimagesize($_FILES['file']['tmp_name']) != false) {
        $size = getimagesize($_FILES['file']['tmp_name']);
        $type = $size['mime'];
        $imgfp = fopen($_FILES['file']['tmp_name'], 'rb');
        $size = $size[3];
        $name = $_FILES['file']['name'];
        $maxsize = 99999999;

        if ($_FILES['file']['size'] < $maxsize) {
            $stmt = $dbcon->prepare("UPDATE spread SET introduce_add_img = ? WHERE spread_id = '$sp_email'");
            $stmt->bindParam(1, $imgfp, PDO::PARAM_LOB);
            $stmt->execute();

            $sql3 = "SELECT * FROM spread WHERE spread_id = '$sp_email'";
            $res3 = $connect->query($sql3);
            $row3 = $res3->fetch();
            $ti = 'data:image/png;base64,' . base64_encode($row3['introduce_add_img']);
            $stmt2 = $dbcon->prepare("UPDATE spread SET introduce_add_img = ? WHERE spread_id = '$sp_email'");
            $stmt2->bindParam(1, $ti, PDO::PARAM_LOB);
            $stmt2->execute();
        } else {
            echo "<script>alert('사진의 크기가 너무 큽니다.'); location.href='/hongber/index.php'</script>";
        }
    } else {
        $sql = "DELETE FROM spread WHERE spread_id = '$sp_email'";
        $connect->query($sql);
        echo "<script>alert('사진을 등록해주세요.'); history.back();</script>";
    }

    if (is_uploaded_file($_FILES['file2']['tmp_name']) && getimagesize($_FILES['file2']['tmp_name']) != false) {
        $size = getimagesize($_FILES['file2']['tmp_name']);
        $type = $size['mime'];
        $imgfp = fopen($_FILES['file2']['tmp_name'], 'rb');
        $size = $size[3];
        $name = $_FILES['file2']['name'];
        $maxsize = 99999999;

        if ($_FILES['file2']['size'] < $maxsize) {
            $stmt = $dbcon->prepare("UPDATE spread SET introduce_prod_img = ? WHERE spread_id = '$sp_email'");
            $stmt->bindParam(1, $imgfp, PDO::PARAM_LOB);
            $stmt->execute();

            $sql3 = "SELECT * FROM spread WHERE spread_id = '$sp_email'";
            $res3 = $connect->query($sql3);
            $row3 = $res3->fetch();
            $ti = 'data:image/png;base64,' . base64_encode($row3['introduce_prod_img']);
            $stmt2 = $dbcon->prepare("UPDATE spread SET introduce_prod_img = ? WHERE spread_id = '$sp_email'");
            $stmt2->bindParam(1, $ti, PDO::PARAM_LOB);
            $stmt2->execute();
        } else {
            // echo "<script>alert('사진의 크기가 너무 큽니다.'); location.href='/hongber/index.php'</script>";
        }
    } else {
        $sql = "DELETE FROM spread WHERE spread_id = '$sp_email'";
        $connect->query($sql);
        //echo "<script>alert('사진을 등록해주세요.'); history.back();</script>";
    }

    $regist_day = date("Y-m-d H:i");

    $usql = "SELECT COUNT(*) as cnt FROM user";
    $nsql = "SELECT COUNT(*) as cnt FROM nuser";
    $ksql = "SELECT COUNT(*) as cnt FROM kuser";

    $ures = $connect->query($usql);
    $nres = $connect->query($nsql);
    $kres = $connect->query($ksql);

    $urow = $ures->fetch();
    $nrow = $nres->fetch();
    $krow = $kres->fetch();

    $unkrow =  $urow['cnt'] + $nrow['cnt'] + $krow['cnt'];
    $rowall =  (int)$unkrow;

    if ($rowall > $recper) {
        $rowall = $recper;
    }

    echo "<script>alert('광고가 뿌려졌습니다.'); location.href='/hongber/index.php'</script>";
} else {
    //echo "<script>alert('광고 뿌리기는 계정당 1번이며 이전 광고의 기간이 만료되면 가능합니다.'); location.href='/hongber/index.php'</script>";
}

<?php
include "config.php";
include "config2.php";
session_start();

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token']) && !isset($_SESSION["mislog"])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}

$sp_t = "/[][`~!#$%^&*|\\\'\";:\/?^=^+_(){}<>]/";

if (preg_match($sp_t, $_POST["resolution"])) {
    echo "<script>alert('허용되지 않은 문자가 포함되어 있습니다.'); location.href='/hongber/index.php'</script>";
} else {
    if (!isset($_SESSION['hislog'])) {
    } else {
        $hm_id = $_SESSION['hid'];
        $hm_name = $_SESSION['hname'];
        $hm_email = $_SESSION['hemail'];
        $hm_r = $_POST['resolution'];
        $hm_sd = $_POST['start_d'];
        $hm_ed = $_POST['end_d'];
        $category = $_POST['category'];
        date_default_timezone_set('Asia/Seoul');
        $hm_day = date("Y-m-d H:i");
    }

    if (is_uploaded_file($_FILES['file']['tmp_name']) && getimagesize($_FILES['file']['tmp_name']) != false) {
        $size = getimagesize($_FILES['file']['tmp_name']);
        $type = $size['mime'];
        $imgfp = fopen($_FILES['file']['tmp_name'], 'rb');
        $size = $size[3];
        $name = $_FILES['file']['name'];
        $maxsize = 99999999;

        if ($_FILES['file']['size'] < $maxsize) {
            $stmt = $dbcon->prepare("UPDATE hmatch SET hm_upimg = ? WHERE hm_email = '$hm_email'");
            $stmt->bindParam(1, $imgfp, PDO::PARAM_LOB);
            $stmt->execute();

            $sql2 = "SELECT * FROM hmatch WHERE hm_email = '$hm_email'";
            $res2 = $connect->query($sql2);
            $row2 = $res2->fetch();
            $ti = 'data:image/png;base64,' . base64_encode($row2['hm_upimg']);
            $stmt = $dbcon->prepare("UPDATE hmatch SET hm_upimg = ? WHERE hm_email = '$hm_email'");
            $stmt->bindParam(1, $ti, PDO::PARAM_LOB);
            $stmt->execute();

            $sql3 = "UPDATE hmatch SET hm_r = '$hm_r', hm_sd = '$hm_sd', hm_ed = '$hm_ed', hm_day = '$hm_day', category = '$category' WHERE hm_email = '$hm_email'";
            $res3 = $connect->query($sql3);

            echo "<script>alert('변경사항이 적용되었습니다.'); location.href='/hongber/php/match.php'</script>";
        } else {
            echo "<script>alert('사진의 크기가 너무 큽니다.'); location.href='/hongber/php/match.php'</script>";
        }
    } else {
        $sql3 = "UPDATE hmatch SET hm_r = '$hm_r', hm_sd = '$hm_sd', hm_ed = '$hm_ed', hm_day = '$hm_day', category = '$category' WHERE hm_email = '$hm_email'";
        $res3 = $connect->query($sql3);
        echo "<script>alert('변경사항이 적용되었습니다.'); location.href='/hongber/php/match.php'</script>";
    }
}

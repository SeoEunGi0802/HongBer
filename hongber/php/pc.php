<?php
include "config.php";
include "config2.php";
session_start();

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}
// 내 소개를 변경하는 부분
$cp_msg = $_POST['cpmsg'];
if (!isset($_SESSION['hislog'])) {
} else {
    $c_pwd = $_POST['cpwd'];
    if ($c_pwd != $_SESSION['hpwd']) {
        echo "<script>alert('현재 비밀번호가 일치하지 않습니다.'); history.back(-1);</script>";
    } else {
        $id = $_SESSION['hid'];
        $email = $_SESSION['hemail'];
        $hsql = "SELECT * FROM hser WHERE h_id = '$id'";
        $hres = $connect->query($hsql);
        $hrow = $hres->fetch();
        if ($hrow != null) {
            $sql = "UPDATE hser SET h_msg = '$cp_msg' WHERE h_id = '$id'";
            $connect->query($sql);
        }

        // 사진의 정보들을 받아와 LONGBLOB형식으로 저장하고 다시 base64인코딩하여 재저정한다.
        // base64로 인코딩후 재저장하는 이유는 db에서 어떤 사진인지 인코딩전에는 알수없기 때문이다.
        if (is_uploaded_file($_FILES['file']['tmp_name']) && getimagesize($_FILES['file']['tmp_name']) != false) {
            $size = getimagesize($_FILES['file']['tmp_name']);
            $type = $size['mime'];
            $imgfp = fopen($_FILES['file']['tmp_name'], 'rb');
            $size = $size[3];
            $name = $_FILES['file']['name'];
            $maxsize = 99999999;

            if ($_FILES['file']['size'] < $maxsize) {
                $sql = "SELECT * FROM hser WHERE h_email = '$email'";
                $res = $connect->query($sql);
                $row = $res->fetch();
                if (!empty($row['h_pimg'])) { // 기존 프로필 사진을 변경해주는 구문
                    $stmt = $dbcon->prepare("UPDATE hser SET h_pimg = ? WHERE h_email = '$email'");
                    $stmt->bindParam(1, $imgfp, PDO::PARAM_LOB);
                    $stmt->execute();

                    $sql2 = "SELECT * FROM hser WHERE h_email = '$email'";
                    $res2 = $connect->query($sql2);
                    $row2 = $res2->fetch();
                    $ti = 'data:image/png;base64,' . base64_encode($row2['h_pimg']);
                    $stmt = $dbcon->prepare("UPDATE hser SET h_pimg = ? WHERE h_email = '$email'");
                    $stmt->bindParam(1, $ti, PDO::PARAM_LOB);
                    $stmt->execute();

                    // 매치페이지 프로필이미지 같이 변경하는 구문
                    $sql3 = "SELECT * FROM hser WHERE h_email = '$email'";
                    $res3 = $connect->query($sql3);
                    $row3 = $res3->fetch();
                    $ti3 = $row3['h_pimg'];
                    $stmt = $dbcon->prepare("UPDATE hmatch SET hm_pimg = ? WHERE hm_email = '$email'");
                    $stmt->bindParam(1, $ti3, PDO::PARAM_LOB);
                    $stmt->execute();

                    echo "<script>alert('변경사항이 적용되었습니다.'); location.href='/hongber/php/mypage.php'</script>";
                } else { // 기존에 프로필 사진이 없었다면 or 처음 등록하는 거라면 테이블에 NULL값을 변경해주는 구문
                    $stmt = $dbcon->prepare("UPDATE hser SET h_pimg = ? WHERE h_email = '$email'");
                    $stmt->bindParam(1, $imgfp, PDO::PARAM_LOB);
                    $stmt->execute();

                    $sql4 = "SELECT * FROM hser WHERE h_email = '$email'";
                    $res4 = $connect->query($sql4);
                    $row4 = $res4->fetch();
                    $ti3 = 'data:image/png;base64,' . base64_encode($row4['h_pimg']);
                    $stmt = $dbcon->prepare("UPDATE hser SET h_pimg = ? WHERE h_email = '$email'");
                    $stmt->bindParam(1, $ti3, PDO::PARAM_LOB);
                    $stmt->execute();

                    // 매치페이지 프로필이미지 같이 변경하는 구문
                    $sql5 = "SELECT * FROM hser WHERE h_email = '$email'";
                    $res5 = $connect->query($sql5);
                    $row5 = $res5->fetch();
                    $ti5 = $row5['h_pimg'];
                    $stmt = $dbcon->prepare("UPDATE hmatch SET hm_pimg = ? WHERE hm_email = '$email'");
                    $stmt->bindParam(1, $ti5, PDO::PARAM_LOB);
                    $stmt->execute();

                    echo "<script>alert('변경사항이 적용되었습니다.'); location.href='/hongber/php/mypage.php'</script>";
                }
            } else {
                echo "<script>alert('사진의 크기가 너무 큽니다.'); location.href='/hongber/php/pchange.php'</script>";
            }
        } else {
            echo "<script>alert('변경사항이 적용되었습니다.'); location.href='/hongber/php/mypage.php'</script>";
        }
    }
}

if (!isset($_SESSION['uislog'])) {
} else {
    $c_pwd = $_POST['cpwd'];
    if ($c_pwd != $_SESSION['upwd']) {
        echo "<script>alert('현재 비밀번호가 일치하지 않습니다.'); history.back(-1);</script>";
    } else {
        $id = $_SESSION['uid'];
        $email = $_SESSION['uemail'];
        $usql = "SELECT * FROM user WHERE u_id = '$id'";
        $ures = $connect->query($usql);
        $urow = $ures->fetch();
        if ($urow != null) {
            $sql = "UPDATE user SET u_msg = '$cp_msg' WHERE u_id = '$id'";
            $connect->query($sql);
        }

        // 사진의 정보들을 받아와 LONGBLOB형식으로 저장하고 다시 base64인코딩하여 재저정한다.
        // base64로 인코딩후 재저장하는 이유는 db에서 어떤 사진인지 인코딩전에는 알수없기 때문이다.
        if (is_uploaded_file($_FILES['file']['tmp_name']) && getimagesize($_FILES['file']['tmp_name']) != false) {
            $size = getimagesize($_FILES['file']['tmp_name']);
            $type = $size['mime'];
            $imgfp = fopen($_FILES['file']['tmp_name'], 'rb');
            $size = $size[3];
            $name = $_FILES['file']['name'];
            $maxsize = 99999999;

            if ($_FILES['file']['size'] < $maxsize) {
                $sql = "SELECT * FROM user WHERE u_email = '$email'";
                $res = $connect->query($sql);
                $row = $res->fetch();
                if (!empty($row['u_pimg'])) {
                    $stmt = $dbcon->prepare("UPDATE user SET u_pimg = ? WHERE u_email = '$email'");
                    $stmt->bindParam(1, $imgfp, PDO::PARAM_LOB);
                    $stmt->execute();

                    $sql2 = "SELECT * FROM user WHERE u_email = '$email'";
                    $res2 = $connect->query($sql2);
                    $row2 = $res2->fetch();
                    $ti = 'data:image/png;base64,' . base64_encode($row2['u_pimg']);
                    $stmt = $dbcon->prepare("UPDATE user SET u_pimg = ? WHERE u_email = '$email'");
                    $stmt->bindParam(1, $ti, PDO::PARAM_LOB);
                    $stmt->execute();
                    echo "<script>alert('변경사항이 적용되었습니다.'); location.href='/hongber/php/mypage.php'</script>";
                } else {
                    $stmt = $dbcon->prepare("UPDATE user SET u_pimg = ? WHERE u_email = '$email'");
                    $stmt->bindParam(1, $imgfp, PDO::PARAM_LOB);
                    $stmt->execute();

                    $sql3 = "SELECT * FROM user WHERE u_email = '$email'";
                    $res3 = $connect->query($sql3);
                    $row3 = $res3->fetch();
                    $ti2 = 'data:image/png;base64,' . base64_encode($row3['u_pimg']);
                    $stmt = $dbcon->prepare("UPDATE user SET u_pimg = ? WHERE u_email = '$email'");
                    $stmt->bindParam(1, $ti2, PDO::PARAM_LOB);
                    $stmt->execute();
                }
                echo "<script>alert('변경사항이 적용되었습니다.'); location.href='/hongber/php/mypage.php'</script>";
            } else {
                echo "<script>alert('사진의 크기가 너무 큽니다.'); location.href='/hongber/php/pchange.php'</script>";
            }
        } else {
            echo "<script>alert('변경사항이 적용되었습니다.'); location.href='/hongber/php/mypage.php'</script>";
        }
    }
}

if (!isset($_SESSION['naver_access_token'])) {
} else {
    $id = $_SESSION['naver_access_token'];
    $email = $_SESSION['nemail'];
    $nsql = "SELECT * FROM nuser WHERE token = '$id'";
    $nres = $connect->query($nsql);
    $nrow = $nres->fetch();
    if ($nrow != null) {
        $sql = "UPDATE nuser SET n_msg = '$cp_msg' WHERE token = '$id'";
        $connect->query($sql);
    }

    // 사진의 정보들을 받아와 LONGBLOB형식으로 저장하고 다시 base64인코딩하여 재저정한다.
    // base64로 인코딩후 재저장하는 이유는 db에서 어떤 사진인지 인코딩전에는 알수없기 때문이다.
    if (is_uploaded_file($_FILES['file']['tmp_name']) && getimagesize($_FILES['file']['tmp_name']) != false) {
        $size = getimagesize($_FILES['file']['tmp_name']);
        $type = $size['mime'];
        $imgfp = fopen($_FILES['file']['tmp_name'], 'rb');
        $size = $size[3];
        $name = $_FILES['file']['name'];
        $maxsize = 99999999;

        if ($_FILES['file']['size'] < $maxsize) {
            $sql = "SELECT * FROM nuser WHERE n_email = '$email'";
            $res = $connect->query($sql);
            $row = $res->fetch();
            if (!empty($row['n_pimg'])) {
                $stmt = $dbcon->prepare("UPDATE nuser SET n_pimg = ? WHERE n_email = '$email'");
                $stmt->bindParam(1, $imgfp, PDO::PARAM_LOB);
                $stmt->execute();

                $sql2 = "SELECT * FROM nuser WHERE n_email = '$email'";
                $res2 = $connect->query($sql2);
                $row2 = $res2->fetch();
                $ti = 'data:image/png;base64,' . base64_encode($row2['n_pimg']);
                $stmt = $dbcon->prepare("UPDATE nuser SET n_pimg = ? WHERE n_email = '$email'");
                $stmt->bindParam(1, $ti, PDO::PARAM_LOB);
                $stmt->execute();
                echo "<script>alert('변경사항이 적용되었습니다.'); location.href='/hongber/php/mypage.php'</script>";
            } else {
                $stmt = $dbcon->prepare("UPDATE nuser SET n_pimg = ? WHERE n_email = '$email'");
                $stmt->bindParam(1, $imgfp, PDO::PARAM_LOB);
                $stmt->execute();

                $sql3 = "SELECT * FROM nuser WHERE n_email = '$email'";
                $res3 = $connect->query($sql3);
                $row3 = $res3->fetch();
                $ti2 = 'data:image/png;base64,' . base64_encode($row3['n_pimg']);
                $stmt = $dbcon->prepare("UPDATE nuser SET n_pimg = ? WHERE n_email = '$email'");
                $stmt->bindParam(1, $ti2, PDO::PARAM_LOB);
                $stmt->execute();
            }
            echo "<script>alert('변경사항이 적용되었습니다.'); location.href='/hongber/php/mypage.php'</script>";
        } else {
            echo "<script>alert('사진의 크기가 너무 큽니다.'); location.href='/hongber/php/pchange.php'</script>";
        }
    } else {
        echo "<script>alert('변경사항이 적용되었습니다.'); location.href='/hongber/php/mypage.php'</script>";
    }
}

if (!isset($_SESSION['kakao_access_token'])) {
} else {
    $id = $_SESSION['kakao_access_token'];
    $email = $_SESSION['kemail'];
    $ksql = "SELECT * FROM kuser WHERE token = '$id'";
    $kres = $connect->query($ksql);
    $krow = $kres->fetch();
    if ($krow != null) {
        $sql = "UPDATE kuser SET k_msg = '$cp_msg' WHERE token = '$id'";
        $connect->query($sql);
    }

    // 사진의 정보들을 받아와 LONGBLOB형식으로 저장하고 다시 base64인코딩하여 재저정한다.
    // base64로 인코딩후 재저장하는 이유는 db에서 어떤 사진인지 인코딩전에는 알수없기 때문이다.
    if (is_uploaded_file($_FILES['file']['tmp_name']) && getimagesize($_FILES['file']['tmp_name']) != false) {
        $size = getimagesize($_FILES['file']['tmp_name']);
        $type = $size['mime'];
        $imgfp = fopen($_FILES['file']['tmp_name'], 'rb');
        $size = $size[3];
        $name = $_FILES['file']['name'];
        $maxsize = 99999999;

        if ($_FILES['file']['size'] < $maxsize) {
            $sql = "SELECT * FROM kuser WHERE k_email = '$email'";
            $res = $connect->query($sql);
            $row = $res->fetch();
            if (!empty($row['k_pimg'])) {
                $stmt = $dbcon->prepare("UPDATE kuser SET k_pimg = ? WHERE k_email = '$email'");
                $stmt->bindParam(1, $imgfp, PDO::PARAM_LOB);
                $stmt->execute();

                $sql2 = "SELECT * FROM kuser WHERE k_email = '$email'";
                $res2 = $connect->query($sql2);
                $row2 = $res2->fetch();
                $ti = 'data:image/png;base64,' . base64_encode($row2['k_pimg']);
                $stmt = $dbcon->prepare("UPDATE kuser SET k_pimg = ? WHERE k_email = '$email'");
                $stmt->bindParam(1, $ti, PDO::PARAM_LOB);
                $stmt->execute();
                echo "<script>alert('변경사항이 적용되었습니다.'); location.href='/hongber/php/mypage.php'</script>";
            } else {
                $stmt = $dbcon->prepare("UPDATE kuser SET k_pimg = ? WHERE k_email = '$email'");
                $stmt->bindParam(1, $imgfp, PDO::PARAM_LOB);
                $stmt->execute();

                $sql3 = "SELECT * FROM kuser WHERE k_email = '$email'";
                $res3 = $connect->query($sql3);
                $row3 = $res3->fetch();
                $ti2 = 'data:image/png;base64,' . base64_encode($row3['image']);
                $stmt = $dbcon->prepare("UPDATE kuser SET k_pimg = ? WHERE k_email = '$email'");
                $stmt->bindParam(1, $ti2, PDO::PARAM_LOB);
                $stmt->execute();
            }
            echo "<script>alert('변경사항이 적용되었습니다.'); location.href='/hongber/php/mypage.php'</script>";
        } else {
            echo "<script>alert('사진의 크기가 너무 큽니다.'); location.href='/hongber/php/pchange.php'</script>";
        }
    } else {
        echo "<script>alert('변경사항이 적용되었습니다.'); location.href='/hongber/php/mypage.php'</script>";
    }
}


$connect = null;
$dbcon = null;
?>
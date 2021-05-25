<?php
include "config.php";
session_start();

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}

$search = $_GET['search'];

if ($search == "") {
    $search = '""';
} else {
    $sql = "SELECT u_name as name, u_email as email, u_msg as msg, u_pimg as pimg FROM user WHERE u_name = '$search' or u_email = '$search' UNION SELECT n_name, n_email, n_msg, n_pimg FROM nuser WHERE n_name = '$search' or n_email = '$search' UNION SELECT k_name, k_email, k_msg, k_pimg FROM kuser WHERE k_name = '$search' or k_email = '$search' UNION SELECT h_name, h_email, h_msg, h_pimg FROM hser WHERE h_name = '$search' or h_email = '$search'";
    $res = $connect->query($sql);
}

$rsql = "SELECT u_name as name, u_email as email, u_msg as msg, u_pimg as pimg FROM user WHERE u_name = '$search' or u_email = '$search' UNION SELECT n_name, n_email, n_msg, n_pimg FROM nuser WHERE n_name = '$search' or n_email = '$search' UNION SELECT k_name, k_email, k_msg, k_pimg FROM kuser WHERE k_name = '$search' or k_email = '$search' UNION SELECT h_name, h_email, h_msg, h_pimg FROM hser WHERE h_name = '$search' or h_email = '$search'";
$rres = $connect->query($rsql);
$rrow = $rres->fetch();
$chc = $rrow == false ? "none" : "isis";
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원 찾기</title>
    <link rel="stylesheet" href="/hongber/css/reset.css">
    <link rel="stylesheet" href="/hongber/css/search.css">
    <link rel="icon" href="/hongber/favicon.ico" type="image/x-icon">
    <script src="/hongber/js/jquery.js"></script>
</head>

<body>
    <?php
    include "../header.php";
    ?>
    <div id="wrap">
        <nav class="nav2">
            <p>검색어 <?= $search ?>에 대한 결과 입니다.</p>
        </nav>
        <?php
        if (isset($res)) {
            while ($row = $res->fetch()) {
                $name = $row['name'];
                $email = $row['email'];
                $msg = $row['msg'];
                $pimg = $row['pimg'];
                if (empty($pimg)) {
                    $pimg = "/hongber/css/image/bpimg.png";
                }

                $usql = "SELECT * FROM user WHERE u_name = '$name' AND u_email = '$email'";
                $ures = $connect->query($usql);
                $urow = $ures->fetch();

                $nsql = "SELECT * FROM nuser WHERE n_name = '$name' AND n_email = '$email'";
                $nres = $connect->query($nsql);
                $nrow = $nres->fetch();

                $ksql = "SELECT * FROM kuser WHERE k_name = '$name' AND k_email = '$email'";
                $kres = $connect->query($ksql);
                $krow = $kres->fetch();

                $hsql = "SELECT * FROM hser WHERE h_name = '$name' AND h_email = '$email'";
                $hres = $connect->query($hsql);
                $hrow = $hres->fetch();

                if (!empty($urow)) {
                    $who = "HongBer";
                } else if (!empty($nrow)) {
                    $who = "HongBer by Naver";
                } else if (!empty($krow)) {
                    $who = "HongBer by Kakao";
                } else {
                    $who = "Advertiser";
                }
        ?>
                <section>
                    <div class="profile_wrap">
                        <div class="img_wrap">
                            <img src="<?= $pimg ?>" alt="프로필 사진">
                        </div>
                        <div class="info_wrap">
                            <input type="text" name="name" class="input_name" disabled value="<?= $name ?>">
                            <input type="email" name="email" class="input_email" disabled value="<?= $email ?>">
                            <input type="text" name="who" class="input_who" disabled value="<?= $who ?>">
                            <button class="knock" onclick="knock(this.value)" value="<?= $email ?>">노크하기</button>
                            <textarea name="textarea" id="textarea" disabled><?= $msg ?></textarea>
                        </div>
                    </div>
                </section>
        <?php }
        } else if ($search == '""') {
            echo "<p class='none_here'>똑똑똑...?</p>";
        }
        if ($chc == "none") {
            echo "<p class='none_here'>똑똑똑...?</p>";
        } ?>
    </div>
    <script>
        function knock(email) {
            const width = '1250';
            const height = '1000';

            const left = Math.ceil((window.screen.width - width) / 2);
            const top = Math.ceil((window.screen.height - height) / 2);
            window.open('/hongber/php/knock.php?name=<?= $name ?>&email=' + email + '&msg=<?= $msg ?>', 'knock', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ', scrollbars=no');
        }
    </script>
    <?php
    include "home.php";
    ?>
</body>

</html>
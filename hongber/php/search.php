<?php
include "config.php";
session_start();
//error_reporting(0);

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
    <script src="/hongber/js/jquery.js"></script>
</head>

<body>
    <div id="wrap">
        <?php
        include "../header.php";
        ?>
        <!-- 검색창 -->
        <div class="search_wrap">
            <form action="/hongber/php/search.php" method="GET">
                <input type="text" name="search" id="search" class="searchbox" placeholder="회원검색(이름 or 이메일)" autocomplete="off">
                <div class="search_icon">
                    <input type="submit" value="검색" class="search_btn">
                </div>
            </form>
        </div>
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
                    $pimg = "/css/image/bpimg.png";
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
            const height = '900';

            const left = Math.ceil((window.screen.width - width) / 2);
            const top = Math.ceil((window.screen.height - height) / 2);
            const who = $('.input_who').val();
            window.open('/hongber/php/knock.php?name=<?= $name ?>&email=' + email + '&msg=<?= $msg ?>', 'knock', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ',' + 'toolbars=no', 'scrollbars=no');
        }
    </script>
</body>

</html>
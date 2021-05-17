<?php
include "config.php";
session_start();

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}

$num = $_GET['nvsp'];

$sql = "SELECT * FROM mying WHERE num = '$num'";
$res = $connect->query($sql);
$row = $res->fetch();

$sql = "SELECT * FROM spread WHERE introduce_prod = '$row[7]' AND spread_tool = '$row[8]' AND spread_oc = '$row[9]'";
$res = $connect->query($sql);
$row = $res->fetch();

$adve = $row[1];
$advn = $row[2];
$adsd = $row[3];
$aded = $row[4];
$introadd = $row[5];
$introaddimg = $row[6];
$introprod = $row[7];
$introprodimg = $row[8];
$bespnum = $row[9];
$sptool = $row[10];

$sql2 = "SELECT h_pimg FROM hser WHERE h_email = '$adve'";
$res2 = $connect->query($sql2);
$row2 = $res2->fetch();
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-------------------------- CSS ----------------------------->
    <link rel="stylesheet" href="/hongber/css/reset.css">
    <link rel="stylesheet" href="/hongber/css/addmore.css">
    <link rel="stylesheet" href="/hongber/css/swiper.css">
    <!--------------------------- JS ------------------------------>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <title>More</title>
</head>

<body>
    <div class="swiper-container mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="morethumb"><img src='<?= $row2['h_pimg'] ?>'></div>
                <div class="info_wrap">
                    <p><?= $advn ?></p>
                    <p><?= $adve ?></p>
                    <p><?= $adsd . '~' . $aded ?></p>
                    <p>모집인원 : <?= $bespnum ?>명</p>
                </div>
            </div>
            <div class="swiper-slide">
                <p class="i_intro">광고주 소개</p>
                <p class="intro_t"><?= $introadd ?></p>
            </div>
            <div class="swiper-slide">
                <p class="i_intro">광고주 소개 사진</p><img src='<?= $introaddimg ?>'>
            </div>
            <div class="swiper-slide">
                <p class="i_intro">제품 소개</p>
                <p class="intro_t"><?= $introprod ?></p>
            </div>
            <div class="swiper-slide">
                <p class="i_intro">제품 소개 사진</p>
                <img src='<?= $introprodimg ?>'>
            </div>
            <div class="swiper-slide">
                <p class="i_intro">홍보 방식</p>
                <p class="intro_t"><?= $sptool ?></p>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <script>
        var swiper = new Swiper(".mySwiper", {
            direction: "vertical",
            mousewheel: true,
            keyboard: {
                enabled: true,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            }
        });
    </script>
</body>

</html>
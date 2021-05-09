<!-----------------------session start------------------------->
<?php
include "config.php";
session_start();
error_reporting(0);
/*------------------------login/out---------------------------*/
if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
  echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}
if (!isset($_SESSION['hislog'])) {
} else {
  $hid = $_SESSION['hid'];
  $hemail = $_SESSION['hemail'];
  $hsql = "SELECT h_pimg FROM hser WHERE h_email = '$hemail'";
  $hres = $connect->query($hsql);
  $hrow = $hres->fetch();
  $profile_img = $hrow['h_pimg'];
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-------------------------- CSS ----------------------------->
    <link rel="stylesheet" href="/hongber/css/reset.css">
    <link rel="stylesheet" href="/hongber/css/pickup.css">
    <link
      rel="stylesheet"
      href="https://unpkg.com/swiper/swiper-bundle.min.css"
    />
<!--------------------------- JS ------------------------------>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <title>PickUp</title>
</head>

<body>
<!---------------------------nav------------------------------->
<?php
    include "../header.php";
    ?>
<!----------------------flex container-------------------------->
  <div id="wrap">
    <div class="pick_wrap">
        <div class="hm_thumb"><img src="" alt=""></div>
        <div class="info">
        <p class="name_section">원대호</p>
        <p class="Email_section">wdh8366@naver.com</p>
        <p class="day">2021-05-09</p>
        </div>
<!------------------------- Swiper ---------------------------->
    <div class="swiper-container mySwiper">
      <div class="swiper-wrapper">
            <div class="swiper-slide"><p class="h_intro">광고주 소개</p></div>
            <div class="swiper-slide">Slide 2</div>
            <div class="swiper-slide">Slide 3</div>
            <div class="swiper-slide">Slide 4</div>
            <div class="swiper-slide">Slide 5</div>
            <div class="swiper-slide">Slide 6</div>
            <div class="swiper-slide">Slide 7</div>
            <div class="swiper-slide">Slide 8</div>
            <div class="swiper-slide">Slide 9</div>
        </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
    </div>
        <p class="i_intro">제품 소개</p>
        <button class="accept" onclick="">수락</button>
        <button class="deny" onclick="">거절</button> 
</body>
<script>
        var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 30,
    keyboard: {
      enabled: true,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
    </script>
<?php
$connect = null;
?>

</html>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hongber</title>
  <link rel="stylesheet" href="/hongber/css/reset.css">
  <link rel="stylesheet" href="/hongber/css/index.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
  <link rel="icon" href="/hongber/favicon.ico" type="image/x-icon">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
  <script type="text/javascript" src="/hongber/js/index.js"></script>
</head>

<body>
  <div id="wrap">
    <?php
    include "header.php";
    ?>
    <!-- 배너 -->
    <div class="banner_area">
      <div class="banner_left"></div>
      <div class="banner_right"></div>
    </div>
    <!-- 컨텐츠 영역 -->
    <div class="slide_area swiper">
      <div class="swiper-wrapper">
        <div class="swiper-slide">slide1</div>
        <div class="swiper-slide">slide2</div>
        <div class="swiper-slide">slide3</div>
        <div class="swiper-slide">slide4</div>
        <div class="swiper-slide">slide5</div>
      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>

      <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
      <script>
        var swiper = new Swiper(".swiper", {
          spaceBetween: 30,
          centeredSlides: true,
          autoplay: {
            delay: 2500,
            disableOnInteraction: false,
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
    </div>
    <div class="promote">
      <div class="sns">
        <div>SNS</div>
      </div>
      <div class="song">
        <div>Song</div>
      </div>
      <!-- <div class="poster">
        <div>Poster</div>
      </div> -->
      <div class="person">
        <div>Person</div>
      </div>
    </div>
    <footer>
      <p>ⓒcopyright reserved</p>
    </footer>
  </div>
</body>

</html>
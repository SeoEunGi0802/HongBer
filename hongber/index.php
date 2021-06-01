<?php
include "./php/config.php";
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
  <link rel="stylesheet" href="/hongber/css/swiper.css">
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
      <div class="banner_right">
        <div class="title">
          <p>HONGBER</p>
          <span>Your new advertisement</span>
          <span>PARTNER</span>
        </div>
      </div>
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
    <?php
    $sql = "SELECT category FROM hmatch GROUP BY category ORDER BY COUNT(category) DESC LIMIT 4";
    $res = $connect->query($sql);
    $row = $res->fetchAll();
    if ($row[0][0] != null) {
      $category1 = $row[0][0];
    } else {
      $category1 = "";
    }
    if ($row[1][0] != null) {
      $category2 = $row[1][0];
    } else {
      $category2 = "";
    }
    if ($row[2][0] != null) {
      $category3 = $row[2][0];
    } else {
      $category3 = "";
    }
    if ($row[3][0] != null) {
      $category4 = $row[3][0];
    } else {
      $category4 = "";
    }
    ?>
    <div class="promote">
      <div class="category1" onclick="location.replace('/hongber/php/match.php?c=<?= $category1 ?>')">
        <div><?= $category1 ?></div>
      </div>
      <div class="category2" onclick="location.replace('/hongber/php/match.php?c=<?= $category2 ?>')">
        <div><?= $category2 ?></div>
      </div>
      <div class="category3" onclick="location.replace('/hongber/php/match.php?c=<?= $category3 ?>')">
        <div><?= $category3 ?></div>
      </div>
      <div class="category4" onclick="location.replace('/hongber/php/match.php?c=<?= $category4 ?>')">
        <div><?= $category4 ?></div>
      </div>
    </div>
    <footer>
      <p>ⓒcopyright reserved</p>
    </footer>
  </div>
</body>

</html>
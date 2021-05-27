<!-----------------------session start------------------------->
<?php
include "config.php";
session_start();
/*------------------------login/out---------------------------*/
if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token']) && !isset($_SESSION["mislog"])) {
  echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
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
  <link rel="stylesheet" href="/hongber/css/swiper.css">
  <link rel="icon" href="/hongber/favicon.ico" type="image/x-icon">
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
    <div class="swiper-container1 mySwiper1">
      <div class="swiper-wrapper">

        <?php
        $sql = "SELECT * FROM spread";
        $res = $connect->query($sql);
        while ($row = $res->fetch()) {
          $sql2 = "SELECT h_pimg FROM hser WHERE h_email = '$row[1]'";
          $res2 = $connect->query($sql2);
          $row2 = $res2->fetch();
          if (empty($row2['h_pimg'])) {
            $row2['h_pimg'] = "/hongber/css/image/bpimg.png";
          }
        ?>
          <div class="swiper-slide">
            <div class="pick_wrap">
              <div class="hm_thumb"><img src="<?= $row2['h_pimg'] ?>" alt=""></div>
              <div class="info">
                <p class="name_section"><?= $row['spread_name'] ?></p>
                <p class="Email_section"><?= $row['spread_id'] ?></p>
                <p class="day"><?= $row['spread_sd'] . "~" . $row['spread_ed'] ?></p>
                <p class="per">모집인원 : <?= $row['bespread_num'] ?>명</p>
              </div>
              <!------------------------- Swiper ---------------------------->
              <div class="swiper-container mySwiper">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <p class="i_intro">광고주 소개</p>
                    <p class="intro_t"><?= $row['introduce_add'] ?></p>
                  </div>
                  <div class="swiper-slide">
                    <img src=<?= $row['introduce_add_img'] ?>>
                  </div>
                  <div class="swiper-slide">
                    <p class="i_intro">제품 소개</p>
                    <p class="intro_t"><?= $row['introduce_prod'] ?></p>
                  </div>
                  <div class="swiper-slide">
                    <img src=<?= $row['introduce_prod_img'] ?>>
                  </div>
                  <div class="swiper-slide">
                    <p class="i_intro">홍보 방식</p>
                    <p class="intro_t"><?= $row['spread_tool'] ?></p>
                  </div>
                </div>
                <div class="swiper-button-next next"></div>
                <div class="swiper-button-prev prev"></div>
                <div class="swiper-pagination pag"></div>
              </div>
              <form action="/hongber/php/addwait.php" method="POST" id="pick_form">
                <input type="hidden" name="adv_e" value="<?= $row['spread_id'] ?>">
                <input type="hidden" name="adv_n" value="<?= $row['spread_name'] ?>">
                <?php if (isset($_SESSION["hislog"])) {
                } else { ?><button class="accept" type="submit">줍기</button><?php } ?>
              </form>
            </div>
          </div>
        <?php } ?>

      </div>
      <div class="swiper-button-next next1"></div>
      <div class="swiper-button-prev prev1"></div>
    </div>
  </div>
  <script>
    var swiper = new Swiper(".mySwiper", {
      slidesPerView: 1,
      spaceBetween: 30,
      keyboard: {
        enabled: true,
      },
      pagination: {
        el: ".pag",
        clickable: true,
      },
      navigation: {
        nextEl: ".next",
        prevEl: ".prev",
      },
    });
  </script>
  <script>
    var swiper = new Swiper(".mySwiper1", {
      slidesPerView: 1,
      spaceBetween: 30,

      pagination: {
        el: ".pag1",
        clickable: true
      },
      navigation: {
        nextEl: ".next1",
        prevEl: ".prev1",
      },
    });
  </script>
  <?php
  include "home.php";
  ?>
</body>

<?php
$connect = null;
?>

</html>
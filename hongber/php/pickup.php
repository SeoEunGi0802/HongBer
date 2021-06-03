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
  <script src="/hongber/js/jquery.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
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
        $i = 1;
        $sql = "SELECT * FROM spread WHERE bespread_num != '0'";
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
              <div class="hm_thumb" onclick="knock('<?= $row['spread_name'] ?>', '<?= $row['spread_id'] ?>')"><img src="<?= $row2['h_pimg'] ?>" alt=""></div>
              <div class="info">
                <p class="name_section"><?= $row['spread_name'] ?></p>
                <p class="Email_section"><?= $row['spread_id'] ?></p>
                <p class="day"><?= $row['spread_sd'] . "~" . $row['spread_ed'] ?></p>
                <p class="per">모집인원 : <?= $row['bespread_num'] ?>명</p>
              </div>
              <!------------------------- Swiper ---------------------------->
              <div class="add_warp">
                <div>
                  <div class="add_intro">
                    <p class="i_intro">광고주 소개</p>
                    <p class="intro_t"><?= $row['introduce_add'] ?></p>
                  </div>
                  <div class="add_img">
                    <a href="<?= $row['introduce_add_img'] ?>" data-lightbox="<?= $i ?>"><img src=<?= $row['introduce_add_img'] ?>></a>
                  </div>
                  <div class="prod_intro">
                    <p class="i_intro">제품 소개</p>
                    <p class="intro_t"><?= $row['introduce_prod'] ?></p>
                  </div>
                  <div class="prod_img">
                    <a href="<?= $row['introduce_prod_img'] ?>" data-lightbox="<?= $i ?>"><img src=<?= $row['introduce_prod_img'] ?>></a>
                  </div>
                  <div class="add_tool">
                    <p class="i_intro">홍보 방식</p>
                    <p class="intro_t"><?= $row['spread_tool'] ?></p>
                  </div>
                </div>
              </div>
              <form action="/hongber/php/addwait.php" method="POST" id="pick_form">
                <input type="hidden" name="adv_e" value="<?= $row['spread_id'] ?>">
                <input type="hidden" name="adv_n" value="<?= $row['spread_name'] ?>">
                <?php if (isset($_SESSION["hislog"])) {
                } else { ?><button class="accept" type="submit">줍기</button><?php } ?>
              </form>
            </div>
          </div>
        <?php
          $i += 1;
        }
        ?>
      </div>
      <div class="swiper-button-next next1"></div>
      <div class="swiper-button-prev prev1"></div>
    </div>
  </div>
  <script>
    var swiper = new Swiper(".mySwiper1", {
      slidesPerView: 1,
      spaceBetween: 30,
      navigation: {
        nextEl: ".next1",
        prevEl: ".prev1",
      },
      keyboard: {
        enabled: true,
      },
    });
  </script>
  <script>
    function knock(name, email) {
      const width = '1250';
      const height = '1000';

      const left = Math.ceil((window.screen.width - width) / 2);
      const top = Math.ceil((window.screen.height - height) / 2);
      window.open('/hongber/php/knock.php?name=' + name + '&email=' + email, 'knock', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ', scrollbars=no');
    }
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js"></script>
  <?php
  include "home.php";
  ?>
</body>

<?php
$connect = null;
?>

</html>
<?php
include "config.php";
session_start();

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token']) && !isset($_SESSION["mislog"])) {
  echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}

if (!isset($_SESSION['hislog'])) {
} else {
  $hid = $_SESSION['hid'];
  $hemail = $_SESSION['hemail'];
  $email = $_SESSION['hemail'];
  $hsql = "SELECT h_pimg FROM hser WHERE h_email = '$hemail'";
  $hres = $connect->query($hsql);
  $hrow = $hres->fetch();
  $profile_img = $hrow['h_pimg'];
}
if (!isset($_SESSION['uislog'])) {
} else {
  $email = $_SESSION['uemail'];
}
if (!isset($_SESSION['kakao_access_token'])) {
} else {
  $email = $_SESSION['kemail'];
}
if (!isset($_SESSION['naver_access_token'])) {
} else {
  $email = $_SESSION['nemail'];
}
$chksql2 = "SELECT * FROM msgrv WHERE rv_id = '$email' AND rv_check = 'n'";
$chkres2 = $connect->query($chksql2);
$chkrow2 = $chkres2->fetch();
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/hongber/css/reset.css">
  <link rel="stylesheet" href="/hongber/css/match.css">
  <link rel="icon" href="/hongber/favicon.ico" type="image/x-icon">
  <script type="text/javascript" src="/hongber/js/jquery.js"></script>
  <script type="text/javascript" src="/hongber/js/match.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
  <title>match</title>
</head>

<body>
  <div class="loading"></div>
  <?php
  include "../header.php";
  ?>
  <div id="wrap">
    <div class="match_wrap" id="ret">
      <?php
      if (!empty($_SESSION["uislog"]) || !empty($_SESSION['naver_access_token']) || !empty($_SESSION['kakao_access_token'])) {
      } else { ?>
        <div class="btn_box">
          <a href='/hongber/php/hser_info.php'><button class='reg_btn'>등록</button></a>
          <a href='/hongber/php/hm_modify.php'><button class='drop_btn'>수정</button></a>
          <a href='' onclick='hdinfo()'><button class='drop_btn1'>삭제</button></a>
        </div>
      <?php
      }
      ?>
      <div class="search_Box">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <input type="hidden" name="regday" value="R">
          <button type="submit" class="new_btn">최신순</button>
        </form>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <input type="hidden" name="regday" value="O">
          <button type="submit" value="old" class="old_btn">오래된 순</button>
        </form>
        <input id="smav" type="text" onkeyup="sma()" placeholder="search" class="search_area">
      </div>
      <div class="hot_content">
        <p class="hot_p">Today Hot</p>
        <?php
        include "./most_view.php";
        ?>
      </div>
      <div class="category_box">
        <a href="?c=SNS" class="categorySNS">
          <div>SNS</div>
        </a>
        <a href="?c=YouTube" class="categoryYouTube">
          <div>YouTube</div>
        </a>
        <a href="?c=WEB" class="categoryWEB">
          <div>WEB</div>
        </a>
        <a href="?c=APP" class="categoryAPP">
          <div>APP</div>
        </a>
        <a href="?c=entertainment" class="entertainment">
          <div>entertainment</div>
        </a>
        <a href="?c=music" class="music">
          <div>music</div>
        </a>
        <a href="?c=video" class="video">
          <div>video</div>
        </a>
        <a href="./match.php" class="categoryALL">
          <div>전체</div>
        </a>
      </div>
      <?php
      include "./card.php";
      ?>
    </div>
  </div>
  <button class="send_li <?= $chkrow2 == null ? "" : "flash" ?>" onclick="viewmsg()">
    <div class="message_icon"></div>
  </button>
  <script>
    function hdinfo() {
      const width = '800';
      const height = '350';

      const left = Math.ceil((window.screen.width - width) / 2);
      const top = Math.ceil((window.screen.height - height) / 2);

      window.open('/hongber/php/hview.php', '삭제하기', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ',' + 'toolbars=no', 'scrollbars=no');
    }
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
  <script>
    function message(sednemail) {
      const width = '1250';
      const height = '650';

      const left = Math.ceil((window.screen.width - width) / 2);
      const top = Math.ceil((window.screen.height - height) / 2);

      window.open('/hongber/php/message.php?rev_email=' + sednemail, '쪽지', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ', scrollbars=no');
    }
  </script>
  <script>
    function viewmsg() {
      const width = '1250';
      const height = '670';

      const left = Math.ceil((window.screen.width - width) / 2);
      const top = Math.ceil((window.screen.height - height) / 2);

      window.open('/hongber/php/msgbox.php?mode=<?= isset($_SESSION['hislog']) ? "send" : "rv" ?>', '', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ', scrollbars=no');
    }
  </script>
  <script>
    function sma() {
      let smav = document.getElementById("smav").value.toLowerCase();
      let honor_card = document.getElementsByClassName("honor_card");
      let hot_card = document.getElementsByClassName("hot_card");

      for (let i = 0; i < honor_card.length; i++) {
        let hm_name = honor_card[i].getElementsByClassName("hm_name");
        let hm_email = honor_card[i].getElementsByClassName("hm_email");
        let hm_comment = honor_card[i].getElementsByClassName("hm_comment");
        let hm_sd_ed = honor_card[i].getElementsByClassName("hm_sd_ed");

        if (hm_name[0].innerHTML.toLowerCase().indexOf(smav) != -1 || hm_email[0].innerHTML.toLowerCase().indexOf(smav) != -1 || hm_comment[0].innerHTML.toLowerCase().indexOf(smav) != -1 || hm_sd_ed[0].innerHTML.toLowerCase().indexOf(smav) != -1) {
          honor_card[i].style.display = "flex"
        } else {
          honor_card[i].style.display = "none"
        }
      }

      for (let j = 0; j < hot_card.length; j++) {
        let hot_name = hot_card[j].getElementsByClassName("hot_name");
        let hot_email = hot_card[j].getElementsByClassName("hot_email");
        let hot_comment = hot_card[j].getElementsByClassName("hot_comment");
        let hot_sd_ed = hot_card[j].getElementsByClassName("hot_sd_ed");
        if (hot_name[0].innerHTML.toLowerCase().indexOf(smav) != -1 || hot_email[0].innerHTML.toLowerCase().indexOf(smav) != -1 || hot_comment[0].innerHTML.toLowerCase().indexOf(smav) != -1 || hot_sd_ed[0].innerHTML.toLowerCase().indexOf(smav) != -1) {
          hot_card[j].style.display = "flex"
        } else {
          hot_card[j].style.display = "none"
        }
      }
    }
  </script>
  <script>
    function more(email) {
      const width = '700';
      const height = '900';

      const left = Math.ceil((window.screen.width - width) / 2);
      const top = Math.ceil((window.screen.height - height) / 2);

      window.open('/hongber/php/more_info.php?email=' + email, '', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ', scrollbars=no');
    }
  </script>
  <script>
    $(window).on('load', function() {
      $('.loading').fadeOut(500);
    });
  </script>
</body>
<?php
$connect = null;
?>

</html>
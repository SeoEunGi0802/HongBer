<?php
include "config.php";
session_start();

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
  <link rel="stylesheet" href="/hongber/css/reset.css">
  <link rel="stylesheet" href="/hongber/css/match.css">
  <link rel="icon" href="/hongber/favicon.ico" type="image/x-icon">
  <script type="text/javascript" src="/hongber/js/jquery.js"></script>
  <script type="text/javascript" src="/hongber/js/match.js"></script>
  <title>match</title>
</head>

<body>
  <?php
  include "../header.php";
  ?>
  <div id="wrap">
    <div class="match_wrap" id="ret">
      <?php
      if (!empty($_SESSION["uislog"]) || !empty($_SESSION['naver_access_token']) || !empty($_SESSION['kakao_access_token'])) {
      } else { ?>
        <a href='/hongber/php/hser_info.php'><button class='reg_btn'>등록</button></a>
        <a href='/hongber/php/hm_modify.php'><button class='reg_md_btn'>수정</button></a>
        <a href='' onclick='hdinfo()'><button class='reg_rm_btn'>삭제</button></a>
      <?php
      }
      ?>
      <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
      <input type="hidden" name="regday" value="R">
      <button type="submit">최신순</button>
      </form>
      <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
      <input type="hidden" name="regday" value="O">
      <button type="submit" value="old">오래된 순</button>
      </form>
      <input id="smav" type="text" onkeyup="sma()">
      <?php
        include "./card.php";
      ?>
    </div>
  </div>
  <!-- 쪽지 목록 보기 구현 시키기 광고주는 rv 유저는 send-->
  <button class="send_li" onclick="viewmsg()"><img src="/hongber/css/image/archive.png"></button>
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

      for (let i = 0; i < honor_card.length; i++) {
        let hm_name = honor_card[i].getElementsByClassName("hm_name");
        let hm_email = honor_card[i].getElementsByClassName("hm_email");
        let hm_sd_ed = honor_card[i].getElementsByClassName("hm_sd_ed");
        if (hm_name[0].innerHTML.toLowerCase().indexOf(smav) != -1 || hm_email[0].innerHTML.toLowerCase().indexOf(smav) != -1 || hm_sd_ed[0].innerHTML.toLowerCase().indexOf(smav) != -1) {
          honor_card[i].style.display = "flex"
        } else {
          honor_card[i].style.display = "none"
        }
      }
    }
  </script>
</body>
<?php
$connect = null;
?>

</html>
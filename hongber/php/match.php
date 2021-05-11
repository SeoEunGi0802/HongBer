<?php
include "config.php";
session_start();
error_reporting(0);

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
  <script type="text/javascript" src="/hongber/js/match.js"></script>
  <title>match</title>
  <script>
    function hdinfo() {
      const width = '800';
      const height = '350';

      const left = Math.ceil((window.screen.width - width) / 2);
      const top = Math.ceil((window.screen.height - height) / 2);

      window.open('/hongber/php/hview.php', '삭제하기', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ',' + 'toolbars=no', 'scrollbars=no');
    }
  </script>
  <title>match</title>
</head>

<body>
  <div id="wrap">
    <?php
    include "../header.php";
    ?>
    <div class="match_wrap">
      <?php
      if (!empty($_SESSION["uislog"]) || !empty($_SESSION['naver_access_token']) || !empty($_SESSION['kakao_access_token'])) {
      } else {
        echo "<a href='/hongber/php/hser_info.php'><button class='reg_btn'>등록</button></a>";
        echo "<a href='/hongber/php/hm_modify.php'><button class='reg_md_btn'>수정</button></a>";
        echo "<a href='' onclick='hdinfo()'><button class='reg_rm_btn'>삭제</button></a>";
      }
      ?>
      <?php
      $sql = "SELECT * FROM hmatch";
      $result = $connect->query($sql);
      while ($row = $result->fetch()) {
        if (empty($row['hm_pimg'])) {
          $row['hm_pimg'] = "/hongber/css/image/bpimg.png";
        }
        echo "<div class='honor_card'>";
        echo "<div class='hm_thumb'><img src='" . $row['hm_pimg'] . "' class='mtping'></div>";
        echo "<div class='hm_info'>" . $row['hm_name'] . "<p>" . $row['hm_email'] . "</p>" . "</div>";
        echo "<div class='hm_img'><img src=" . $row['hm_upimg'] . "></div>";
        echo "<textarea class='hm_comment' readonly>" . $row['hm_r'] . "</textarea>";
        echo "<div class='hm_date'>" . "<p>" . $row['hm_sd'] . " ~ " . $row['hm_ed'] . "</p>" . "</div>";
        echo "<button class='send' id='send' value='" . $row['hm_email'] . "' onclick=" . '"message(this.value)">' . '<img src="/hongber/css/image/matching.png"></button>';
        echo "</div>";
      }
      ?>
    </div>
  </div>
  <!-- 쪽지 목록 보기 구현 시키기 광고주는 /php/msgbox.php?mode=rv 유저는 /php/msgbox.php?mode=send-->
  <button class="send_li" onclick="viewmsg()"><img src="/hongber/css/image/archive.png"></button>
  <script>
    function message(sednemail) {
      const width = '1250';
      const height = '650';

      const left = Math.ceil((window.screen.width - width) / 2);
      const top = Math.ceil((window.screen.height - height) / 2);

      window.open('/hongber/php/message.php?rev_email=' + sednemail, '쪽지', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ',' + 'toolbars=no', 'scrollbars=no');
    }
  </script>
  <script>
    function viewmsg() {
      const width = '1250';
      const height = '670';

      const left = Math.ceil((window.screen.width - width) / 2);
      const top = Math.ceil((window.screen.height - height) / 2);

      window.open('/hongber/php/msgbox.php?mode=<?= isset($_SESSION['hislog']) ? "send" : "rv" ?>', '쪽지', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ',' + 'toolbars=no', 'scrollbars=no');
    }
  </script>
</body>
<?php
$connect = null;
?>

</html>
<?php
include "config.php";
session_start();

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
  echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}

if (!isset($_SESSION['hislog'])) {
} else {
  $hid = $_SESSION['hid'];
  $hname = $_SESSION['hname'];
  $hemail = $_SESSION['hemail'];
  $hsql = "SELECT * FROM hser WHERE h_id = '$hid'";
  $hres = $connect->query($hsql);
  $hrow = $hres->fetch();
  $profile_img = $hrow['h_pimg'];
  $hpmsg = $hrow['h_msg'];
  if (empty($hpmsg)) {
    $hpmsg = "";
  }
}

if (!isset($_SESSION['uislog'])) {
} else {
  $uid = $_SESSION['uid'];
  $uname =  $_SESSION['uname'];
  $uemail = $_SESSION['uemail'];
  $usql = "SELECT * FROM user WHERE u_id = '$uid'";
  $ures = $connect->query($usql);
  $urow = $ures->fetch();
  $profile_img = $urow['u_pimg'];
  $upmsg = $urow['u_msg'];
  if (empty($upmsg)) {
    $upmsg = "";
  }
}

if (!isset($_SESSION['naver_access_token'])) {
} else {
  $ntoken = $_SESSION['naver_access_token'];
  $nname = $_SESSION['nname'];
  $nemail = $_SESSION['nemail'];
  $nsql = "SELECT * FROM nuser WHERE token = '$ntoken'";
  $nres = $connect->query($nsql);
  $nrow = $nres->fetch();
  $profile_img = $nrow['n_pimg'];
  $npmsg = $nrow['n_msg'];
  if (empty($npmsg)) {
    $npmsg = "";
  }
}

if (!isset($_SESSION['kakao_access_token'])) {
} else {
  $ktoken = $_SESSION['kakao_access_token'];
  $kname = $_SESSION['kname'];
  $kemail = $_SESSION['kemail'];
  $ksql = "SELECT * FROM kuser WHERE token = '$ktoken'";
  $kres = $connect->query($ksql);
  $krow = $kres->fetch();
  $profile_img = $krow['k_pimg'];
  $kpmsg = $krow['k_msg'];
  if (empty($kpmsg)) {
    $kpmsg = "";
  }
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Profile</title>
  <link rel="stylesheet" href="/hongber/css/reset.css">
  <link rel="stylesheet" href="/hongber/css/pchange.css">
  <link rel="icon" href="/hongber/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
  <script src="/hongber/js/jquery.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js"></script>
  <script src="/hongber/js/thumbnail.js"></script>
</head>

<body>
  <!-- 상단 바 -->
  <?php
  include "../header.php";
  ?>
  <section>
    <div class="wrap_bgimg">
      <div class="content_wrap">
        <div class="profile">
          <div class="profile_img">
            <a href="<?php if ($profile_img != null) {
                        echo $profile_img;
                      } else {
                        echo "/hongber/css/image/bpimg.png";
                      } ?>" id="ccpimg" data-title="프로필 사진" data-lightbox="example-set">
              <img src="<?php if ($profile_img != null) {
                          echo $profile_img;
                        } else {
                          echo "/hongber/css/image/bpimg.png";
                        } ?>" id="cpimg" alt="프로필사진">
            </a>
            <form enctype="multipart/form-data" action="/hongber/php/pc.php" method="POST">
              <div class="file_btn">
                <span>파일 선택</span>
              </div>
              <input type="file" name="file" id="imgInp" class="edit" accept="image/gif, image/jpeg, image/png">
          </div>
        </div>
        <div class="profile_info">
          <?php
          if (!isset($_SESSION["hislog"]) && !isset($_SESSION["uislog"])) {
          } else {
          ?>
            현재 비밀번호
            <input type="password" id="cpwd" name="cpwd">
          <?php
          }
          ?>

          자기소개 수정하기
          <textarea name="cpmsg" id="cpmsg" placeholder="내 소개(최대 200자)" maxlength="200"></textarea>
        </div>
        <div class="change_btn_wrap">
          <input type="submit" value="변경" class="change_btn">
          </form>
          <input type="button" value="취소" class="cancel_btn" onclick="window.location.replace('/hongber/php/mypage.php')">
        </div>
      </div>
    </div>
  </section>
  <div class="secession">
    <form action="/hongber/php/secession.php" method="POST" name="secession_form">
      <input type="hidden" id="cpwd2" name="pwd">
      <div class="secession_btn">
        <span>회원 탈퇴</span>
      </div>
      <input type="button" onclick="del_chkf()" value="회원탈퇴">
    </form>
  </div>
  <script>
    $('#cpwd').keyup(function() {
      const pwdt = $('#cpwd').val();
      $('#cpwd2').val(pwdt);
    });
  </script>
  <script>
    function del_chkf() {
      const del_chk = confirm("탈퇴하시겠습니까?");
      if (del_chk == false) {
        location.reload();
      } else if (del_chk == true) {
        let secession_form = document.secession_form;
        let pwd = secession_form.pwd.value;
        secession_form.submit();
      }
    }
  </script>
  <?php
  if (!isset($_SESSION['hislog'])) {
  } else {
    echo "<script>$('#cpmsg').text('" . $hpmsg . "');</script>";
  }
  if (!isset($_SESSION['uislog'])) {
  } else {
    echo "<script>$('#cpmsg').text('" . $upmsg . "');</script>";
  }
  if (!isset($_SESSION['naver_access_token'])) {
  } else {
    echo "<script>$('#cpmsg').text('" . $npmsg . "');</script>";
  }
  if (!isset($_SESSION['kakao_access_token'])) {
  } else {
    echo "<script>$('#cpmsg').text('" . $kpmsg . "');</script>";
  }
  ?>
</body>

</html>
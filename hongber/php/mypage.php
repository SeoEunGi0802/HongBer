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
  $name = $_SESSION['hname'];
  $email = $_SESSION['hemail'];
  $hsql = "SELECT * FROM hser WHERE h_id = '$hid'";
  $hres = $connect->query($hsql);
  $hrow = $hres->fetch();
  $profile_img = $hrow['h_pimg'];
  $hpmsg = $hrow['h_msg'];
}

if (!isset($_SESSION['uislog'])) {
} else {
  $uid = $_SESSION['uid'];
  $uname =  $_SESSION['uname'];
  $uemail = $_SESSION['uemail'];
  $name =  $_SESSION['uname'];
  $email = $_SESSION['uemail'];
  $usql = "SELECT * FROM user WHERE u_id = '$uid'";
  $ures = $connect->query($usql);
  $urow = $ures->fetch();
  $profile_img = $urow['u_pimg'];
  $upmsg = $urow['u_msg'];
}

if (!isset($_SESSION['naver_access_token'])) {
} else {
  $ntoken = $_SESSION['naver_access_token'];
  $nname = $_SESSION['nname'];
  $nemail = $_SESSION['nemail'];
  $name =  $_SESSION['nname'];
  $email = $_SESSION['nemail'];
  $nsql = "SELECT * FROM nuser WHERE token = '$ntoken'";
  $nres = $connect->query($nsql);
  $nrow = $nres->fetch();
  $profile_img = $nrow['n_pimg'];
  $npmsg = $nrow['n_msg'];
}

if (!isset($_SESSION['kakao_access_token'])) {
} else {
  $ktoken = $_SESSION['kakao_access_token'];
  $kname = $_SESSION['kname'];
  $kemail = $_SESSION['kemail'];
  $name =  $_SESSION['kname'];
  $email = $_SESSION['kemail'];
  $ksql = "SELECT * FROM kuser WHERE token = '$ktoken'";
  $kres = $connect->query($ksql);
  $krow = $kres->fetch();
  $profile_img = $krow['k_pimg'];
  $kpmsg = $krow['k_msg'];
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MY PAGE</title>
  <link rel="stylesheet" href="/hongber/css/reset.css">
  <link rel="stylesheet" href="/hongber/css/mypage.css">
  <link rel="icon" href="/hongber/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">

</head>

<body>
  <?php
  include "../header.php";
  ?>
  <section>
    <div class="profile">
      <div class="profile_img">
        <a href="<?php if ($profile_img != null) {
                    echo $profile_img;
                  } else {
                    echo "/hongber/css/image/bpimg.png";
                  } ?>" data-title="프로필 사진" data-lightbox="example-set">
          <img src="<?php if ($profile_img != null) {
                      echo $profile_img;
                    } else {
                      echo "/hongber/css/image/bpimg.png";
                    } ?>" alt="프로필사진">
        </a>
        <a href="/hongber/php/pchange.php">
          <div class="wheel_icon"></div>
        </a>
      </div>
    </div>
    <div class="profile_info">
      이름
      <input type="text" value="<?php
                                if (!empty($hname)) {
                                  echo "$hname";
                                } elseif (!empty($uname)) {
                                  echo "$uname";
                                } elseif (!empty($nname)) {
                                  echo "$nname";
                                } elseif (!empty($kname)) {
                                  echo "$kname";
                                }
                                ?>" disabled>
      이메일
      <input type="text" value="<?php
                                if (!empty($hemail)) {
                                  echo "$hemail";
                                } elseif (!empty($uemail)) {
                                  echo "$uemail";
                                } elseif (!empty($nemail)) {
                                  echo "$nemail";
                                } elseif (!empty($kemail)) {
                                  echo "$kemail";
                                }
                                ?>" disabled>
      자기소개
      <textarea type="text" id="mymsg" disabled><?php
                                                if (!empty($hpmsg)) {
                                                  echo "$hpmsg";
                                                } elseif (!empty($upmsg)) {
                                                  echo "$upmsg";
                                                } elseif (!empty($npmsg)) {
                                                  echo "$npmsg";
                                                } elseif (!empty($kpmsg)) {
                                                  echo "$kpmsg";
                                                } else {
                                                  echo "아직 자신의 대한 소개글이없어요! 마이페이지를 수정하여 채워보세요!";
                                                }
                                                ?>
                                                </textarea>
    </div>
    <div class="history">
      <div class="history_btn_wrap">
        <input type="button" name="doing" id="doing" value="진행 중" onclick="ingFunction()">
        <input type="button" name="finished" id="finished" value="진행 완료" onclick="finFunction()">
      </div>
      <div class="ing" id="ing_id">
        <p class="status">진행 중</p>
        <table>
          <tr>
            <td>number</td>
            <td colspan="2">홍보 기간</td>
            <td>홍보 아이템</td>
            <td>홍보 수단</td>
            <td>오픈 채팅</td>
            <td>더보기</td>
          </tr>
          <?php
          $num = 1;
          if (isset($_SESSION['hislog'])) {
            $sql = "SELECT * FROM mying WHERE mying_adv_email = '$email' AND mying_adv_name = '$name'";
            $result = $connect->query($sql);
            while ($row = $result->fetch()) {
              echo '<tr>';
              echo '<td>' . $num . '</td>';
              echo '<td>' . $row['mying_sd'] . '</td>';
              echo '<td>' . $row['mying_ed'] . '</td>';
              echo '<td>' . $row['mying_prod'] . '</td>';
              echo '<td>' . $row['mying_tool'] . '</td>';
              echo '<td>' . '<a href="' . $row['mying_oc'] . '" target="_blank"><img src="/hongber/css/image/openc.png"></a>' . '</td>';
              echo '<td>' . '<a onclick="more()">◀</a>' . '</td>';
              echo '</tr>';
              $num = $num + 1;
            }
          } else {
            $sql = "SELECT * FROM mying WHERE mying_email = '$email' AND mying_name = '$name'";
            $result = $connect->query($sql);
            while ($row = $result->fetch()) {
              echo '<tr>';
              echo '<td>' . $num . '</td>';
              echo '<td>' . $row['mying_sd'] . '</td>';
              echo '<td>' . $row['mying_ed'] . '</td>';
              echo '<td>' . $row['mying_prod'] . '</td>';
              echo '<td>' . $row['mying_tool'] . '</td>';
              echo '<td>' . '<a href="' . $row['mying_oc'] . '" target="_blank"><img src="/hongber/css/image/openc.png"></a>' . '</td>';
              echo '<td>' . '<a onclick="more(this.value)" value="' . $email . '">◀</a>' . '</td>';
              echo '</tr>';
              $num = $num + 1;
            }
          }
          ?>
        </table>
      </div>
      <div class="finish" id="finish_id">
        <p class="status">진행 완료</p>
        <table>
          <tr>
            <td>number</td>
            <td colspan="2">홍보 기간</td>
            <td>홍보 수단</td>
          </tr>
          <?php
          $sql = "SELECT * FROM myed";
          $result = $connect->query($sql);
          while ($row = $result->fetch()) {
            echo '<tr>';
            echo '<td>' . $row['num'] . '</td>';
            echo '<td>' . $row['myed_sd'] . '</td>';
            echo '<td>' . $row['myed_ed'] . '</td>';
            echo '<td>' . $row['myed_means'] . '</td>';
            echo '</tr>';
          }
          ?>
        </table>
      </div>
    </div>
  </section>
  <button class="wait_add" onclick="viewstaus()"><img src="/hongber/css/image/addstatus.png"></button>
  <button class="send_li" onclick="viewmsg()"><img src="/hongber/css/image/archive.png"></button>
  <script src="/hongber/js/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js"></script>
  <script src="/hongber/js/career.js"></script>
  <script>
    function viewstaus() {
      const width = '1050';
      const height = '630';

      const left = Math.ceil((window.screen.width - width) / 2);
      const top = Math.ceil((window.screen.height - height) / 2);

      window.open('/hongber/php/addbox.php?mode=<?= isset($_SESSION['hislog']) ? "A" : "H" ?>', '', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ', scrollbars=no');
    }
  </script>
  <script>
    function viewmsg() {
      const width = '1250';
      const height = '670';

      const left = Math.ceil((window.screen.width - width) / 2);
      const top = Math.ceil((window.screen.height - height) / 2);

      window.open('/hongber/php/msgbox.php?mode=<?= isset($_SESSION['hislog']) ? "send" : "rv" ?>', '', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ',scrollbars=no');
    }
  </script>
  <script>
    function more(vspemail) {
      const width = '1350';
      const height = '1000';

      const left = Math.ceil((window.screen.width - width) / 2);
      const top = Math.ceil((window.screen.height - height) / 2);

      window.open('/hongber/php/vsp.php?email=' + vspemail, '', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ', scrollbars=no');
    }
  </script>
</body>

</html>
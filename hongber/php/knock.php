<?php
include "config.php";
session_start();

$name = $_GET['name'];
$email = $_GET['email'];
$msg = $_GET['msg'];

$usql = "SELECT * FROM user WHERE u_name = '$name' AND u_email = '$email'";
$ures = $connect->query($usql);
$urow = $ures->fetch();

$nsql = "SELECT * FROM nuser WHERE n_name = '$name' AND n_email = '$email'";
$nres = $connect->query($nsql);
$nrow = $nres->fetch();

$ksql = "SELECT * FROM kuser WHERE k_name = '$name' AND k_email = '$email'";
$kres = $connect->query($ksql);
$krow = $kres->fetch();

$hsql = "SELECT * FROM hser WHERE h_name = '$name' AND h_email = '$email'";
$hres = $connect->query($hsql);
$hrow = $hres->fetch();

if (!empty($urow)) {
  $profile_img = $urow['u_pimg'];
} else if (!empty($nrow)) {
  $profile_img = $nrow['n_pimg'];
} else if (!empty($krow)) {
  $profile_img = $krow['k_pimg'];
} else {
  $profile_img = $hrow['h_pimg'];
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>knock knock</title>
  <link rel="stylesheet" href="/hongber/css/reset.css">
  <link rel="stylesheet" href="/hongber/css/mypage.css">
  <link rel="icon" href="/hongber/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">

</head>

<body>
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
      </div>
      <form action="star_rating.php" method="POST">
        <?php
        if ($email == $_SESSION['hemail'] || $email == $_SESSION['uemail'] || $email == $_SESSION['hemail'] || $email == $_SESSION['hemail']) {
        } else {
          include "star.php";
        ?>
          <input type="hidden" value="<?= $name ?>" name="name">
          <input type="hidden" value="<?= $email ?>" name="email">
          <br><input type="submit" value="별점주기">
        <?php
        }
        ?>
      </form>
    </div>
    <div class="profile_info">
      이름
      <input type="text" value="<?= $name ?>" disabled>
      이메일
      <input type="text" value="<?= $email ?>" disabled>
      자기소개
      <textarea type="text" id="mymsg" disabled><?= $msg ?></textarea>
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
              echo '<td>' . '<a onclick="more()">◀</a>' . '</td>';
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
  <script src="/hongber/js/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js"></script>
  <script src="/hongber/js/career.js"></script>
</body>

</html>
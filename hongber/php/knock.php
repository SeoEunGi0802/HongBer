<?php
include "config.php";
session_start();
//error_reporting(0);
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
        <?php if (!empty($hrow)) { ?>
          <input type="button" name="spread" id="spread" value="뿌린 광고" onclick="spreadFunction()">
        <?php } else { ?>
          <input type="button" name="picked" id="picked" value="주운 광고" onclick="pickFunction()">
        <?php } ?>
        <input type="button" name="doing" id="doing" value="진행 중" onclick="ingFunction()">
        <input type="button" name="finished" id="finished" value="진행 완료" onclick="finFunction()">
      </div>
      <?php if (!empty($hrow)) { ?>
        <div class="spread" id="spread_id">
          <p class="status">뿌린 광고</p>
          <table>
            <tr>
              <td>number</td>
              <td colspan="2">홍보 기간</td>
              <td>홍보 수단</td>
            </tr>
            <?php
            $sql = "SELECT * FROM spread"; //where id = '$id';
            $result = $connect->query($sql);
            while ($row = $result->fetch()) {
              echo '<tr>';
              echo '<td>' . $row['num'] . '</td>';
              echo '<td>' . $row['spread_sd'] . '</td>';
              echo '<td>' . $row['spread_ed'] . '</td>';
              echo '<td>' . $row['spread_means'] . '</td>';
              echo '</tr>';
            }
            ?>
          </table>
        <?php } else { ?>
          <div class="pick" id="picked_id">
            <p class="status">주운 광고</p>
            <table>
              <tr>
                <td>number</td>
                <td colspan="2">홍보 기간</td>
                <td>홍보 수단</td>
              </tr>
            <?php
            $sql = "SELECT * FROM mypick"; //where id = '$id';
            $result = $connect->query($sql);
            while ($row = $result->fetch()) {
              echo '<tr>';
              echo '<td>' . $row['num'] . '</td>';
              echo '<td>' . $row['mypick_sd'] . '</td>';
              echo '<td>' . $row['mypick_ed'] . '</td>';
              echo '<td>' . $row['mypick_means'] . '</td>';
              echo '</tr>';
            }
          } ?>
            </table>
          </div>
          <div class="ing" id="ing_id">
            <p class="status">진행 중</p>
            <table>
              <tr>
                <td>number</td>
                <td colspan="2">홍보 기간</td>
                <td>홍보 수단</td>
              </tr>
              <?php
              $sql = "SELECT * FROM mying";
              $result = $connect->query($sql);
              while ($row = $result->fetch()) {
                echo '<tr>';
                echo '<td>' . $row['num'] . '</td>';
                echo '<td>' . $row['mying_sd'] . '</td>';
                echo '<td>' . $row['mying_ed'] . '</td>';
                echo '<td>' . $row['mying_means'] . '</td>';
                echo '</tr>';
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
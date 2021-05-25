<?php
include "config.php";
session_start();

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}
$day = date("Y-m-d");
$name = $_SESSION['hname'];
$id = $_SESSION['hid'];
$email = $_SESSION['hemail'];
$sql = "SELECT * FROM hmatch WHERE hm_email = '$email'";
$res = $connect->query($sql);
$row = $res->fetch();

if (empty($row)) {
    echo "<script>alert('먼저 광고를 등록해주세요.'); location.href='/hongber/php/match.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/hongber/css/reset.css">
    <link rel="stylesheet" href="/hongber/css/modify.css">
    <link rel="icon" href="/hongber/favicon.ico" type="image/x-icon">
    <script type="text/javascript" src="/hongber/js/jquery.js"></script>
    <script>
        function tnn() {
            document.getElementById('tn').value = document.getElementById('tr').value.length;
        }
    </script>
    <title>광고 수정</title>
</head>

<body>
    <!-- 상단 바 -->
  <?php
  include "../header.php";
  ?>
    <form enctype="multipart/form-data" action="/hongber/php/uphmdb.php" method="POST">
        <div class="form_wrap">
            <p>이름</p>
            <input type="text" id="inpname" name="name" placeholder="ex)홍길동(이름)" required readonly><br>
            <p>홍보할 제품 사진 업로드</p>
            <div class="filebox">
                <img src="" id="preimg"><br>
                <label for="file">업로드</label>
                <input type="file" id="file" name="file" accept="image/gif, image/jpeg, image/png">
            </div><br>
            <p>상세설명 및 요구사항</p>
            <div class="res">
                <textarea type="text" name="resolution" id="tr" onkeyup="tnn()" onkeydwon="tnn()" onkeypress="tnn()" maxlength="300" required></textarea>
            </div><br>
            <input type="number" id="tn" value="0" readonly><br>
            <p>Category</p>
                <select  class="category" name="" id="">
                    <option value="">categoryA</option>
                    <option value="">categoryB</option>
                    <option value="">categoryC</option>
                    <option value="">categoryD</option>
                    <option value="">categoryE</option>
                    <option value="">categoryF</option>
                    <option value="">categoryG</option>
                    <option value="">categoryH</option>
                </select>
            <p>등록기간</p>
            <input type="date" name="start_d" id="s_d"><input type="date" name="end_d" id="e_d" required><br>
            <div>
                <input type="submit" value="수정" id="submit">
            </div>
        </div>
    </form>
    <?php
    if (!isset($_SESSION['hislog'])) {
    } else {
        $sql = "SELECT * FROM hmatch WHERE hm_id = '$id' AND hm_name = '$name' AND hm_email = '$email'";
        $res = $connect->query($sql);
        $row = $res->fetch();
        $str = $row['hm_r'];
        $str = str_replace("\r\n", " ", "$str");

        echo "<script>document.getElementById('inpname').value = '" . $_SESSION['hname'] . "'</script>";
        echo "<script>document.getElementById('preimg').src = '" . $row['hm_upimg'] . "'</script>";
        echo "<script>document.getElementById('tr').value = '" . $str . "'</script>";
        echo "<script>document.getElementById('s_d').value = '" . $day . "'</script>";
        echo "<script>document.getElementById('e_d').value = '" . $row['hm_ed'] . "'</script>";
    }
    ?>
    <script>
        $('#e_d').blur(function() {
            if ($('#s_d').val() > $('#e_d').val()) {
                alert("등록 기간을 제대로 설정해주세요.");
                document.getElementById('e_d').value = '<?= $row['hm_ed'] ?>';
            }
        });
    </script>
    <script>
        $('#s_d').blur(function() {
            if ($('#e_d').val() < $('#s_d').val()) {
                alert("등록 기간을 제대로 설정해주세요.");
                document.getElementById('s_d').value = '<?= $row['hm_sd'] ?>';
            }
        });
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                let file = input.files;
                if (!/(.*?)\.(jpg|jpeg|png|gif|png)$/i.test(file[0].name)) {
                    alert('jpg, jpeg, gif, png 파일만 선택해 주세요.');
                } else {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preimg').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        }
        $('#file').change(function() {
            readURL(this);
        });
    </script>

</body>

</html>
<?php
include "config.php";
session_start();

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token']) && !isset($_SESSION["mislog"])) {
  echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/hongber/css/reset.css">
  <link rel="stylesheet" href="/hongber/css/user_info.css">
  <link rel="icon" href="/hongber/favicon.ico" type="image/x-icon">
  <script type="text/javascript" src="/hongber/js/jquery.js"></script>
  <script type="text/javascript" src="/hongber/js/user_info.js"></script>
  <script>
    function tnn() {
      document.getElementById('tn').value = document.getElementById('tr').value.length;
    }
  </script>
  <title>광고 등록</title>
</head>

<body>
  <!-- 상단 바 -->
  <?php
  include "../header.php";
  ?>
  <div class="form_wrap">
    <form enctype="multipart/form-data" action="/hongber/php/himdb.php" method="POST">
      <p>이름</p>
      <input type="text" id="inpname" name="name" placeholder="ex)홍길동(이름)" required readonly><br>
      <p>홍보할 제품 사진 업로드</p>
      <img src="" id="preimg"><br>
      <div class="filebox">
        <label for="file">업로드</label>
        <input type="file" id="file" name="file" accept="image/gif, image/jpeg, image/png">
      </div><br>
      <p>상세설명 및 요구사항</p>
      <div class="res">
        <textarea name="resolution" placeholder="ex(각오한마디) 최대 300자" id="tr" onkeyup="tnn()" onkeydwon="tnn()" onkeypress="tnn()" maxlength="300" required></textarea>
      </div>
      <input type="number" id="tn" value="0" readonly><br>
      <p>Category</p>
      <select class="category" name="category" id="category">
        <option value="SNS">SNS</option>
        <option value="YouTube">YouTube</option>
        <option value="WEB">WEB</option>
        <option value="APP">APP</option>
        <option value="entertainment">entertainment</option>
        <option value="music">music</option>
        <option value="video">video</option>
      </select>
      <p>등록기간</p>
      <input type="date" name="start_d" id="s_d"><input type="date" name="end_d" id="e_d" required><br>
      <div>
        <input type="submit" value="등록" id="submit">
      </div>
  </div>
  </form>
  <?php
  if (!isset($_SESSION['hislog'])) {
  } else {
    echo "<script>document.getElementById('inpname').value = '" . $_SESSION['hname'] . "'</script>";
  }
  if (!isset($_SESSION['naver_access_token'])) {
  } else {
    echo "<script>document.getElementById('inpname').value = '" . $_SESSION['nname'] . "'</script>";
  }
  if (!isset($_SESSION['kakao_access_token'])) {
  } else {
    echo "<script>document.getElementById('inpname').value = '" . $_SESSION['kname'] . "'</script>";
  }
  ?>
  <script>
    document.getElementById('s_d').value = new Date().toISOString().substring(0, 10);
    document.getElementById('s_d').min = new Date().toISOString().substring(0, 10);
    document.getElementById('e_d').min = new Date().toISOString().substring(0, 10);
  </script>
  <script>
    $('#e_d').blur(function() {
      if ($('#s_d').val() > $('#e_d').val()) {
        alert("등록 기간을 제대로 설정해주세요.");
        document.getElementById('e_d').value = "";
      }
    });
  </script>
  <script>
    $('#file').ready(function() {
      if (!$('#file').val()) {
        $('#preimg').attr('id', 'noneimg');
      }
    });
  </script>
  <script>
    $('#file').change(function() {
      if ($('#file').val()) {
        $('#noneimg').attr('id', 'preimg');
      }
    });
  </script>

  <script>
    $('#s_d').blur(function() {
      if ($('#e_d').val() < $('#s_d').val()) {
        if ($('#e_d').val() != "") {
          alert("등록 기간을 제대로 설정해주세요.");
          document.getElementById('s_d').value = new Date().toISOString().substring(0, 10);
        }
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
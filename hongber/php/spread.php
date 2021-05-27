<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/hongber/css/reset.css">
  <link rel="stylesheet" href="/hongber/css/spread.css">
  <link rel="icon" href="/hongber/favicon.ico" type="image/x-icon">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
  <script>
    function details() {
      document.getElementById("front");
      front.style.display = "none";
    }

    function rdetails() {
      document.getElementById("front");
      front.style.display = "";
    }

    function setThumbnail(event) {
      var reader = new FileReader();
      reader.onload = function(event) {
        var img = document.createElement("img");
        img.setAttribute("src", event.target.result);
        document.querySelector("div#image_container").appendChild(img);
      };
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>
  <title>Spread</title>
</head>

<body>
  <!-- 상단 바 -->
  <?php
  include "../header.php";
  ?>
  <div class="spread_comment">
    <p>Spreading Ads</p>
    <h3>함께하실 홍버분들 모십니다!</h3>
  </div>
  <div class="form_container">
    <div class="form_wrap">
      <form action="spindb.php" enctype="multipart/form-data" method="POST">
        <div class="spread_date">
          <p>모집기간</p>
          <input type="date" name="sd" id="sd" required> ~ <input type="date" name="ed" id="ed" required>
        </div>
        <p class="select_p">모집인원</p>
        <select name="recper">
          <option value="10">10명</option>
          <option value="20">20명</option>
          <option value="30">30명</option>
          <option value="40">40명</option>
          <option value="50">50명</option>
          <option value="60">60명</option>
          <option value="70">70명</option>
          <option value="80">80명</option>
          <option value="90">90명</option>
          <option value="100">100명</option>
        </select><br><br>
        <div class="tool_wrap">
          <p class="tool_p">요구 수단</p>
          <input type="radio" name="tool" value="SNS" checked required>SNS
          <input type="radio" name="tool" value="YouTube">YouTube
          <input type="radio" name="tool" value="Web">Web
          <input type="radio" name="tool" value="App">App
          <input type="radio" name="tool" value="기타" class="another" id="another">기타
          <br>
          <input type="text" name="etc" class="etc" placeholder="기타 선택시에 작성해주세요.">
        </div>
        <div class="kakao_ad">
          <p>오픈채팅 주소</p>
          <input type="text" name="openc" id="openc" placeholder="https://open.kakao.com..." required>
        </div>
        <div class="upload_wrap">
          <p>광고주 소개</p>
          <div class="filebox">
            <img src="" id="addintro" onerror="noneimg()">
            <label for="file">업로드</label>
            <input type="file" id="file" name="file" accept="image/gif, image/jpeg, image/png">
          </div><br>
          <input type="text" name="add" placeholder="광고주 본인을 소개해주세요!" required class="intro">
        </div>
        <div class="upload_wrap2">
          <p>홍보할 제품 소개</p>
          <div class="filebox">
            <img src="" id="productintro" onerror="noneimg()">
            <label for="file2">업로드</label>
            <input type="file" id="file2" name="file2" accept="image/gif, image/jpeg, image/png">
          </div><br>
          <div class="introduce_prod">
            <input type="text" name="prod" required placeholder="홍보계획에 대한 정보를 적어주세요!" class="intro">
          </div>
        </div>
        <input type="submit" value="뿌리기" id="sbtn" class="sbtn">
      </form>
    </div>
  </div>
  <script>
    $('#openc').blur(function() {
      const openc_url = $('#openc').val();
      const findString = "<?= 'https://open.kakao.com/' ?>";
      if (openc_url.indexOf(findString) == -1) {
        alert("정확한 카카오 오픈채팅 링크를 입력해주세요.");
        document.getElementById('openc').value = "";
      }
    });
  </script>
  <script>
    document.getElementById('sd').value = new Date().toISOString().substring(0, 10);
    document.getElementById('sd').min = new Date().toISOString().substring(0, 10);
    document.getElementById('ed').min = new Date().toISOString().substring(0, 10);
  </script>
  <script>
    $('#ed').blur(function() {
      if ($('#sd').val() > $('#ed').val()) {
        alert("뿌릴 기간을 제대로 설정해주세요.");
        document.getElementById('ed').value = "";
      }
    });
  </script>
  <script>
    $('#sd').blur(function() {
      if ($('#ed').val() < $('#sd').val()) {
        if ($('#ed').val() != "") {
          alert("뿌릴 기간을 제대로 설정해주세요.");
          document.getElementById('sd').value = new Date().toISOString().substring(0, 10);
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
            $('#addintro').attr('src', e.target.result);
          }
          reader.readAsDataURL(file[0]);
        }
      }
    }
    $('#file').change(function() {
      readURL(this);
    });
  </script>
  <script>
    function readURL2(input) {
      if (input.files && input.files[0]) {
        let file2 = input.files;
        if (!/(.*?)\.(jpg|jpeg|png|gif|png)$/i.test(file2[0].name)) {
          alert('jpg, jpeg, gif, png 파일만 선택해 주세요.');
        } else {
          let reader2 = new FileReader();
          reader2.onload = function(e2) {
            $('#productintro').attr('src', e2.target.result);
          }
          reader2.readAsDataURL(file2[0]);
        }
      }
    }
    $('#file2').change(function() {
      readURL2(this);
    });
  </script>
  <script>
    function noneimg() {
      $("#addintro").attr("src", "/hongber/css/image/logo.png");
      $("#productintro").attr("src", "/hongber/css/image/logo.png");
    }
  </script>
  <script>
    $(document).ready(function() {
      $("input:radio[name=tool]").click(function() {
        if ($("input[id=another]:checked").val() == "기타") {
          $(".etc").attr("disabled", false);
        } else if ($("input[id=another]:checked").val() != "기타") {
          $(".etc").attr("disabled", true);
        }
      });
    });
  </script>
  <?php
  include "home.php";
  ?>
</body>

</html>
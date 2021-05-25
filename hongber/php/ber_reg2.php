<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="ko">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>회원가입</title>
   <link rel="stylesheet" href="/hongber/css/reset.css">
   <link rel="stylesheet" href="/hongber/css/ber_reg2.css">
   <link rel="icon" href="/hongber/favicon.ico" type="image/x-icon">
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
      function inputPhoneNumber(obj) {
         var number = obj.value.replace(/[^0-9]/g, "");
         var phone = "";

         if (number.length < 4) {
            return number;
         } else if (number.length < 7) {
            phone += number.substr(0, 3);
            phone += "-";
            phone += number.substr(3);
         } else if (number.length < 11) {
            phone += number.substr(0, 3);
            phone += "-";
            phone += number.substr(3, 3);
            phone += "-";
            phone += number.substr(6);
         } else {
            phone += number.substr(0, 3);
            phone += "-";
            phone += number.substr(3, 4);
            phone += "-";
            phone += number.substr(7);
         }
         obj.value = phone;
      }
   </script>
</head>

<body>
   <div class="info_wrap">
      <form action="/hongber/php/add_hser.php" method="POST">
         <input type="id" name="id" placeholder="아이디" required autocomplete="off"><br>
         <input type="password" name="pwd" id="pwd" placeholder="비밀번호" required><br>
         <input type="password" name="rpwd" id="rpwd" placeholder="비밀번호 확인" required><br>
         <input type="name" name="name" placeholder="이름" required autocomplete="off"><br>
         <input type="tel" name="phone" placeholder="your phone number" required onKeyup="inputPhoneNumber(this)" maxlength="13" autocomplete="off"><br>
         <input type="email" name="email" placeholder="E-mail" required autocomplete="off"><br>
         <textarea cols="50" rows="20" placeholder="홍보하고 싶은 제품과 광고주 본인을 자신있게 어필해주세요!(최대 200자)" name="msg" maxlength="200"></textarea><br>
         <input type="submit" value="가입" class="submit"><br>
      </form>
   </div>
   <!-- 비밀번호 일치 확인 스크립트 -->
   <script>
      $('#rpwd').focusout(function() {
         if ($('#pwd').val() != $('#rpwd').val()) {
            alert("비밀번호가 일치하지 않습니다.");
            document.getElementById('rpwd').value = "";
            $('#pwd').focus();
         } else {}
      });
   </script>
   <?php
   include "home.php";
   ?>
</body>

</html>
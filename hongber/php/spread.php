<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/hongber/css/reset.css">
  <link rel="stylesheet" href="/hongber/css/spread.css">
  <script>
      function details(){
          document.getElementById("front");
          front.remove();
      }
      function setThumbnail(event) { var reader = new FileReader(); reader.onload = function(event) { var img = document.createElement("img"); img.setAttribute("src", event.target.result); document.querySelector("div#image_container").appendChild(img); }; reader.readAsDataURL(event.target.files[0]);
}
  </script>
    <title>Spread</title>
</head>
<body>
    <div id="front"class="details" onclick="details()"><img src="/hongber/css/image/mask.jpg"></div>
    <!-- 상단 바 -->
    <?php
    include "../header.php";
    ?>
    <h1>홍보 프로젝트 기획안</h1>
    <h3>함께하실 홍버분들 모십니다!</h3>
    <div class="form_container">
    <form action="">
    <div class="filebox">
      <div id="image_container"></div>
        <label for="file">업로드</label>
        <input type="file" id="file" accept="flie/*" onchange="setThumbnail(event);">
      </div><br>
        광고주 소개: <input type="text"><br>
        <div class="filebox">
      <div id="image_container"></div>
        <label for="file">업로드</label>
        <input type="file" id="file" accept="flie/*" onchange="setThumbnail(event);">
      </div><br>
        홍보할 제품 소개: <input type="text"><br>
        모집인원: 
        <select name="모집인원">
        <option value="">10명</option>
        <option value="">20명</option>
        <option value="">30명</option>
        <option value="">40명</option>
        <option value="">50명</option>
        <option value="">60명</option>
        <option value="">70명</option>
        <option value="">80명</option>
        <option value="">90명</option>
        <option value="">100명</option>
        </select><br>
        <textarea name="" id="" cols="30" rows="10"></textarea><br>
        <input type="submit" value="뿌리기">
    </form>
    </div>
</body>
</html>
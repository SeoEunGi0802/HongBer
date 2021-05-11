<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hongber</title>
  <link rel="stylesheet" href="/hongber/css/reset.css">
  <link rel="stylesheet" href="/hongber/css/index.css">
  <link rel="icon" href="/hongber/favicon.ico" type="image/x-icon">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
  <script type="text/javascript" src="/hongber/js/index.js"></script>
  <script type="text/javascript" src="/hongber/js/materialize.min.js"></script>
  <script type="text/javascript" src="/hongber/js/slideshow.js"></script>
</head>

<body>
  <div id="wrap">
    <?php
    include "header.php";
    ?>
    <!-- 검색창 -->
    <div class="search_wrap">
      <form action="/hongber/php/search.php" method="GET">
      <input type="text" name="search" id="search" class="searchbox" placeholder="회원검색(이름 or 이메일)" autocomplete="off">
      <div class="search_icon">
        <input type="submit" value="검색" class="search_btn">
      </div>
      </form>
    </div>
    <!-- 슬라이드 쇼 -->
    <div class="banner">
      <ul class="slides">
        <!-- 슬라이드 쇼 이미지 크기 높이 500px -->
        <li>
          <img src="/hongber/css/image/banner1.png" alt="" class="img1">
        </li>
        <li>
          <img src="/hongber/css/image/banner2.png" alt="" class="img2">
        </li>
        <li>
          <img src="/hongber/css/image/banner3.png" alt="" class="img3">
        </li>
      </ul>
    </div>
    <!-- 컨텐츠 영역 -->
    <div class="content_area">
      <h1>홍BER WEB 서비스 효과적으로 활용하기!</h1>
      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
      <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
      <p>恰恰与流行观念相反，Lorem Ipsum并不是简简单单的随机文本。它追溯于一篇公元前45年的经典拉丁著作，从而使它有着两千多年的岁数。弗吉尼亚州Hampden-Sydney大学拉丁系教授Richard McClintock曾在Lorem Ipsum段落中注意到一个涵义十分隐晦的拉丁词语，“consectetur”，通过这个单词详细查阅跟其有关的经典文学著作原文，McClintock教授发掘了这个不容置疑的出处。Lorem Ipsum始于西塞罗(Cicero)在公元前45年作的“de Finibus Bonorum et Malorum”（善恶之尽）里1.10.32 和1.10.33章节。这本书是一本关于道德理论的论述，曾在文艺复兴时期非常流行。Lorem Ipsum的第一行”Lorem ipsum dolor sit amet..”节选于1.10.32章节。</p>
    </div>
    <footer>
      <p>ⓒcopyright reserved</p>
    </footer>
  </div>
</body>

</html>
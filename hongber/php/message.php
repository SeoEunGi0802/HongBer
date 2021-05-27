<?php
include "config.php";
session_start();

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token']) && !isset($_SESSION["mislog"])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}

if (!isset($_SESSION['hislog'])) {
} else {
    $email = $_SESSION['hemail'];
}

if (!isset($_SESSION['uislog'])) {
} else {
    $email = $_SESSION['uemail'];
}

if (!isset($_SESSION['naver_access_token'])) {
} else {
    $email = $_SESSION['nemail'];
}

if (!isset($_SESSION['kakao_access_token'])) {
} else {
    $email = $_SESSION['kemail'];
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>쪽지</title>
    <link rel="stylesheet" href="/hongber/css/message.css">
</head>

<body>
    <section>
        <div id="main_content">
            <div id="message">
                <h3 id="write_title">쪽지 보내기</h3>
                <ul class="top_buttons">
                    <li><a href="/hongber/php/msgbox.php?mode=rv">받은 쪽지함</a></li>
                    <li><a href="/hongber/php/msgbox.php?mode=send">보낸 쪽지함</a></li>
                </ul>
                <form action="/hongber/php/msgin.php?send_id=<?= $email ?>" method="POST" name="message_form">
                    <div id="write_msg">
                        <ul>
                            <li>
                                <span class="col1">보내는 사람 : </span>
                                <span class="col2"><?= $email ?></span>
                            </li>
                            <li>
                                <span class="col1">받는 사람 : </span>
                                <span class="col2"><input type="text" value="<?= $_GET['rev_email'] ?>" name="rv_id" readonly></span>
                            </li>
                            <li>
                                <span class="col1">제목 : </span>
                                <span class="col2"><input type="text" name="subject"></span>
                            </li>
                            <li id="textarea">
                                <span class="col1">내용 : </span>
                                <span class="col2"><textarea name="content"></textarea></span>
                            </li>
                        </ul>
                        <input type="submit" value="보내기">
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>
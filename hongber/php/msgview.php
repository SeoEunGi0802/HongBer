<?php
include "config.php";
session_start();
//error_reporting(0);

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
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
    <link rel="stylesheet" href="/css/msgview.css">
</head>

<body>
    <section>
        <div id="main_content">
            <div id="msgview">
                <h3 id="write_title"><?php
                                        $mode = $_GET['mode'];
                                        if ($mode == "send") echo "보낸 쪽지";
                                        else echo "받은 쪽지";
                                        ?></h3>
                <ul class="top_buttons">
                    <li><a href="#" onclick="history.back()">목록 보기</a></li>
                    <li><a href="/php/msgbox.php?mode=rv">받은 쪽지함</a></li>
                    <li><a href="/php/msgbox.php?mode=send">보낸 쪽지함</a></li>
                </ul>
                <div id="write_msg">
                    <ul>
                        <?php
                        if ($mode == "send") {
                        ?>
                            <li>
                                <span class="col1">보낸 사람 : </span>
                                <span class="col2"><?= $email ?></span>
                            </li>
                            <li>
                                <span class="col1">받는 사람 : </span>
                                <span class="col2"><?= $_GET['rv_email'] ?></span>
                            </li>
                        <?php } else { ?>
                            <li>
                                <span class="col1">보낸 사람 : </span>
                                <span class="col2"><?= $_GET['send_email'] ?></span>
                            </li>
                            <li>
                                <span class="col1">받는 사람 : </span>
                                <span class="col2"><?= $email ?></span>
                            </li>
                        <?php } ?>
                        <li>
                            <span class="col1"><?= ($mode == "send") ? "보낸날" : "받은날" ?> </span>
                            <span class="col2"><?= $_GET['regday']; ?></span>
                        </li>
                        <li>
                            <span class="col1">제목 : </span>
                            <span class="col2"><?= $_GET['subject'] ?></span>
                        </li>
                        <li id="textarea">
                            <span class="col1">내용 : </span>
                            <span class="col2"><textarea name="content" readonly><?php if ($mode == "send") {
                                                                                        $id = $_GET['rv_email'];
                                                                                        $subj = $_GET['subject'];
                                                                                        $sql = "SELECT * FROM msgsend WHERE rv_id = '$id' AND subject = '$subj'";
                                                                                    } else {
                                                                                        $id = $_GET['send_email'];
                                                                                        $subj = $_GET['subject'];
                                                                                        $sql = "SELECT * FROM msgrv WHERE send_id =  '$id' AND subject = '$subj'";

                                                                                        $cssql = "UPDATE msgsend SET rv_check = 'v' WHERE send_id = '$id' AND subject = '$subj'";
                                                                                        $csres = $connect->query($cssql);
                                                                                        $csres->fetch();

                                                                                        $crsql = "UPDATE msgrv SET rv_check = 'v' WHERE send_id = '$id' AND subject = '$subj'";
                                                                                        $crres = $connect->query($crsql);
                                                                                        $crres->fetch();
                                                                                    }
                                                                                    $res = $connect->query($sql);
                                                                                    $row = $res->fetch();
                                                                                    echo $row['content']; ?></textarea></span>
                        </li>
                        <?php
                        if ($mode == "send") {
                        ?>
                        <?php } else { ?>
                            <input type="button" value="답장하기" onclick="location.href='/hongber/php/message.php?rev_email=<?= $id ?>'">
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</body>
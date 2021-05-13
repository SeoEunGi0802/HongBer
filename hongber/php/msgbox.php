<?php
include "config3.php";
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
    <title>쪽지함</title>
    <link rel="stylesheet" href="/hongber/css/msgbox.css">
</head>

<body>
    <section>
        <div id="main_content">
            <div id="msgbox">
                <h3>
                    <?php
                    $mode = $_GET['mode'];
                    if ($mode == "send") echo "보낸 쪽지함 > 목록보기";
                    else echo "받은 쪽지함 > 목록보기";
                    ?>
                </h3>

                <!-- 쪽지 리스트가 보여지는 영역(게시판 모양) -->
                <div>
                    <ul id="message">
                        <!-- 리스트의 제목줄 -->
                        <li>
                            <span class="col0"><input type="checkbox" value="selall" onclick="selall(this)"></span>
                            <span class="col1">번호</span>
                            <span class="col2">제목</span>
                            <span class="col3"><?= ($mode == "send") ? "받은이" : "보낸이" ?></span>
                            <span class="col4"><?= ($mode == "send") ? "보낸날" : "받은날" ?></span>
                            <span class="col5">확인</span>
                        </li>
                        <?php
                        if ($mode == "send") {
                            $sql = "SELECT * FROM msgsend WHERE send_id='$email' ORDER BY num DESC";
                        } else {
                            $sql = "SELECT * FROM msgrv WHERE rv_id='$email' ORDER BY num DESC";
                        }

                        $res = mysqli_query($conn, $sql);
                        //전체 쪽지 수
                        $rownum = mysqli_num_rows($res);

                        // 리스트의 하단에 페이지네이션을 표시해서 선택할 수 있도록
                        if (isset($_GET['page'])) $page = $_GET['page'];
                        else  $page = 1;

                        // 전체 페이지 수 계산  1~10 : 1page, 11~20: 2page, 21~30: 3page ....
                        if ($rownum % 10 == 0) $total_page = floor($rownum / 10);
                        else $total_page = floor($rownum / 10) + 1;

                        if ($total_page == 0) $total_page = 1;

                        // 현재페이지에서 시작할 쪽지글의 row 번호 (num값 아님)
                        $start = ($page - 1) * 10; // 1page row=0부터, 2page row=10부터

                        $num = 1;
                        for ($i = $start; $i < $start + 10 && $i < $rownum; $i++) {
                            mysqli_data_seek($res, $i);
                            $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
                            $no = $row['num'];
                            $subject = $row['subject'];
                            $msg_id = ($mode == "send") ? $row['rv_id'] : $row['send_id'];
                            $regist_day = $row['regist_day'];
                            $rv_check = $row['rv_check'];
                        ?>
                            <li>
                                <form action='/hongber/php/msgdel.php?mode=<?= $mode == 'send' ? 'send' : 'rv' ?>' method="POST">
                                    <span><input type="checkbox" name="del[]" value="<?= $no ?>"></span>
                                    <span class="col1"><?= $num ?></span>
                                    <span class="col2"><a href="/hongber/php/msgview.php?mode=<?= $mode ?><?php if ($mode == "send") {
                                                                                                                echo "&rv_email=";
                                                                                                            } else {
                                                                                                                echo "&send_email=";
                                                                                                            } ?><?= $msg_id = ($mode == "send") ? $row['rv_id'] : $row['send_id'] ?>&subject=<?= $subject ?>&regday=<?= $regist_day ?>&rvc=<?= $rv_check ?>"><?= $subject ?></a></span>
                                    <span class="col3"><?= $msg_id ?></span>
                                    <span class="col4"><?= $regist_day ?></span>
                                    <span class="col5"><?= $row['rv_check'] == "n" ? "읽지 않음" : "읽음" ?></span>
                            </li>
                        <?php
                            $num = $num + 1;
                        }
                        mysqli_close($conn);
                        ?>
                    </ul>
                    <!-- 메시지 출력 END -->
                    <!-- 페이지 네이션(페이지 번호 표시) -->
                    <ul id="page_num">
                        <?php
                        if ($page != 1) {
                            $newPage = $page - 1;
                            echo "<li><a href='/hongber/php/msgbox.php?mode=$mode&page=$newPage'>◀이전 </a></li>";
                        } else {
                            echo "<li>◀이전 </li>";
                        }

                        // 페이지 수만큼 페이지 번호 출력
                        for ($i = 1; $i <= $total_page; $i++) {
                            if ($i == $page) echo "<li><strong> $i </strong></li>";
                            else echo "<li><a href='/hongber/php/msgbox.php?mode=$mode&page=$i'> $i</a>></li>";
                        }

                        if ($page != $total_page) {
                            $newPage = $page + 1;
                            echo "<li><a href='/hongber/php/msgbox.php?mode=$mode&page=$newPage'> 다음▶</a></li>";
                        } else {
                            echo "<li> 다음▶</li>";
                        }
                        $connect = null;
                        ?>
                    </ul>

                    <!-- 쪽지함 이동 버튼들 -->
                    <ul class="buttons">
                        <li><button>삭제</button></li>
                        </form>
                        <li><button onclick="location.href='/hongber/php/msgbox.php?mode=rv'">받은 쪽지함</button></li>
                        <li><button onclick="location.href='/hongber/php/msgbox.php?mode=send'">보낸 쪽지함</button></li>
                    </ul>
                </div>

            </div>
        </div>
    </section>
    <div id="source" onclick="source()">Source By https://lcw126.tistory.com/m/214</div>
    <script>
        function selall(selectAll) {
            const chb = document.getElementsByName('del[]');

            chb.forEach((checkbox) => {
                checkbox.checked = selectAll.checked;
            })
        }
    </script>
    <script>
    function source() {
        window.opener.location.href="https://lcw126.tistory.com/m/214";
        window.close();
    }
    </script>
</body>

</html>
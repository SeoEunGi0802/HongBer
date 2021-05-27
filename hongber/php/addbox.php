<?php
include "config3.php";
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
    <title>광고 현황</title>
    <link rel="stylesheet" href="/hongber/css/addbox.css">
</head>

<body>
    <section>
        <div id="main_content">
            <div id="addbox">
                <h3>
                    <?php
                    $mode = $_GET['mode'];
                    if ($mode == "A") echo "광고를 주운 홍버";
                    else echo "대기중인 주운 광고"
                    ?>
                </h3>

                <!-- 주운 광고 리스트가 보여지는 영역(게시판 모양) -->
                <div>
                    <ul id="list">
                        <!-- 리스트의 제목줄 -->
                        <li>
                            <?php
                            if ($mode == "A") {
                            ?>
                                <span class="col0"><input type="checkbox" value="selall" onclick="selall(this)"></span>
                            <?php } ?>
                            <span class="col1">번호</span>
                            <span class="col2">이름</span>
                            <span class="col3">이메일</span>
                            <span class="col4">주운날</span>
                            <span class="col5">상태</span>
                        </li>
                        <?php
                        if ($mode == "A") {
                            $sql = "SELECT * FROM addwait WHERE adv_email = '$email' ORDER BY num DESC";
                        } else {
                            $sql = "SELECT * FROM addwait WHERE wait_email = '$email' ORDER BY num DESC";
                        }

                        $res = mysqli_query($conn, $sql);
                        //전체 주운 광고 수
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
                            $wait_name = $row['wait_name'];
                            $wait_email = $row['wait_email'];
                            $wait_day = $row['wait_day'];
                            $wait_status = $row['wait_status'];
                        ?>
                            <li>
                                <form action='' method="POST">
                                    <?php if ($mode == "A") { ?>
                                        <?php
                                        if ($wait_status == "accept" || $wait_status == "deny") { ?>
                                            <span><input type="checkbox" disabled></span>
                                        <?php } else {
                                        ?>
                                            <span><input type="checkbox" name="del[]" value="<?= $no ?>"></span>
                                        <?php
                                        }
                                        ?>
                                    <?php } ?>
                                    <span class="col1"><?= $num ?></span>
                                    <span class="col2"><?= $wait_name ?></span>
                                    <span class="col3"><?= $wait_email ?></span>
                                    <span class="col4"><?= $wait_day ?></span>
                                    <span class="col5"><?= $wait_status ?></span>
                            </li>
                        <?php
                            $num = $num + 1;
                        }
                        mysqli_close($conn);
                        ?>
                    </ul>
                    <!-- 주운 광고 출력 END -->
                    <!-- 페이지 네이션(페이지 번호 표시) -->
                    <ul id="page_num">
                        <?php
                        if ($page != 1) {
                            $newPage = $page - 1;
                            echo "<li><a href='/hongber/php/addbox.php?&page=$newPage'>◀이전 </a></li>";
                        } else {
                            echo "<li>◀이전 </li>";
                        }

                        // 페이지 수만큼 페이지 번호 출력
                        for ($i = 1; $i <= $total_page; $i++) {
                            if ($i == $page) echo "<li><strong> $i </strong></li>";
                            else echo "<li><a href='/hongber/php/addbox.php?&page=$i'> $i</a>></li>";
                        }

                        if ($page != $total_page) {
                            $newPage = $page + 1;
                            echo "<li><a href='/hongber/php/addbox.php?&page=$newPage'> 다음▶</a></li>";
                        } else {
                            echo "<li> 다음▶</li>";
                        }
                        $connect = null;
                        ?>
                    </ul>

                    <?php if ($mode == "A") { ?>
                        <ul class="buttons">
                            <!-- <li><button>삭제</button></li> -->
                            <li><button formaction="/hongber/php/addstatus.php?st=ac">수락</button></li>
                            <li><button formaction="/hongber/php/addstatus.php?st=de">거절</button></li>
                            </form>
                        </ul>
                    <?php } ?>
                </div>

            </div>
        </div>
    </section>
    <script>
        function selall(selectAll) {
            const chb = document.getElementsByName('del[]');

            chb.forEach((checkbox) => {
                checkbox.checked = selectAll.checked;
            })
        }
    </script>
</body>

</html>
<?php
include "config.php";
session_start();

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/hongber/css/reset.css">
    <link rel="stylesheet" href="/hongber/css/del.css">
</head>

<body>
    <div class="del_wrap">
        <table>
            <tr>
                <td colspan="3">등록기간</td>
                <td>작성자</td>
                <td>홍보수단</td>
                <td>각오 한마디</td>
            </tr>
            <tr>
                <?php
                $sql = "SELECT * FROM hmatch"; //where id = 'id'";
                $result = $connect->query($sql);
                while ($row = $result->fetch()) {
                    echo "<td>" . $row['hm_sd'] . "</td>";
                    echo "<td class='test'>~</td>";
                    echo "<td>" . $row['hm_ed'] . "</td>";
                    echo "<td>" . $row['hm_name'] . "</td>";
                    echo "<td>" . $row['hm_means'] . "</td>";
                    echo "<td>" . $row['hm_r'] . "</td>";
                    echo '</tr>';
                }
                ?>
            </tr>
        </table>

        <br><br>
        <table>
            <tr>
                <a href="/hongber/php/match.php">[목록보기] &nbsp</a>
                <a href="" onclick="return confirm('삭제하시겠습니까?');">[삭제] &nbsp</a>
            </tr>
        </table>
    </div>
</body>

</html>
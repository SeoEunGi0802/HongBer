<?php
session_start()
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>광고 줍기</title>
    <link rel="stylesheet" href="/hongber/css/reset.css">
    <link rel="stylesheet" href="/hongber/css/pickup.css">
</head>

<body>
    <div id="wrap">
        <?php
        include "../header.php";
        ?>
        <section>
            <div class="table_wrap">
                <div class="ad_list">
                    <p>광고 목록</p>
                    <table>
                        <tr>
                            <td>광고 1</td>
                            <td class="plus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 2</td>
                            <td class="plus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 3</td>
                            <td class="plus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 4</td>
                            <td class="plus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 5</td>
                            <td class="plus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 6</td>
                            <td class="plus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 7</td>
                            <td class="plus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 8</td>
                            <td class="plus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 9</td>
                            <td class="plus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 10</td>
                            <td class="plus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 11</td>
                            <td class="plus_btn" onclick=""></td>
                        </tr>
                    </table>
                </div>
                <div class="arrow"></div>
                <div class="pick_list">
                    <p>주운 광고</p>
                    <table>
                        <tr>
                            <td>광고 1</td>
                            <td class="minus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 2</td>
                            <td class="minus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 3</td>
                            <td class="minus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 4</td>
                            <td class="minus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 5</td>
                            <td class="minus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 6</td>
                            <td class="minus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 7</td>
                            <td class="minus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 8</td>
                            <td class="minus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 9</td>
                            <td class="minus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 10</td>
                            <td class="minus_btn" onclick=""></td>
                        </tr>
                        <tr>
                            <td>광고 11</td>
                            <td class="minus_btn" onclick=""></td>
                        </tr>
                    </table>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
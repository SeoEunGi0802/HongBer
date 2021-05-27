<?php
include "config.php";

$uname = $_POST["name"];
$uemail = $_POST["email"];
$uphone = $_POST["phone"];

$sql = "SELECT * FROM user WHERE u_name = '$uname' AND u_email = '$uemail' AND u_phone = '$uphone'";
$res = $connect->query($sql);
$row = $res->fetch();

$nsql = "SELECT * FROM nuser WHERE n_name = '$uname' AND n_email = '$uemail' AND n_phone = '$uphone'";
$nres = $connect->query($nsql);
$nrow = $nres->fetch();

if ($uphone == null) {
    $uphone = NULL;
    $ksql = "SELECT * FROM kuser WHERE k_name = '$uname' AND k_email = '$uemail' AND k_phone = '$uphone'";
    $kres = $connect->query($ksql);
    $krow = $kres->fetch();
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>아이디 찾기</title>
    <link rel="stylesheet" href="/hongber/css/reset.css">
    <link rel="stylesheet" href="/hongber/css/findid_php.css">
    <script>
        function hclose() {
            opener.document.location.href = "/hongber//php/ulogin.php";
            self.close();
        }
    </script>
</head>

<body>
    <div id="wrap">
        <?php
        if (!empty($row)) {
            echo "<p>{$uname}님의 아이디는 <br> {$row['u_id']}입니다.</p>";
        } else if (!empty($nrow)) {
            echo "<p>네이버 가입 이용자 입니다.</p>";
        } else if (!empty($krow)) {
            echo "<p>카카오 가입 이용자 입니다.</p>";
        } else {
            echo "<p>등록된 사용자가 아닙니다.</p>";
        }
        ?>
        <button onclick="hclose()">닫기</button>
    </div>
</body>

</html>
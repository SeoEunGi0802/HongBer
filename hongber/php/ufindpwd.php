<?php
include "config.php";

$uid = $_POST["id"];
$uname = $_POST["name"];
$uemail = $_POST["email"];
$uphone = $_POST["phone"];

$sql = "SELECT * FROM user WHERE u_id = '$uid' AND u_name = '$uname' AND u_email = '$uemail' AND u_phone = '$uphone'";
$res = $connect->query($sql);
$row = $res->fetch();
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>비밀번호 찾기</title>
    <link rel="stylesheet" href="/hongber/css/reset.css">
    <link rel="stylesheet" href="/hongber/css/findpwd_php.css">
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
            //echo "<script>alert('$uname'님의 아이디는 {$row['u_id']}입니다.); location.href='../index.php'</script>";
            echo "<p>{$uname}님의 비밀번호는 <br> {$row['u_pwd']}입니다.</p>";
        } else {
            echo "<p>등록된 사용자가 아닙니다.</p>";
        }
        ?>
        <button onclick="hclose()">닫기</button>
    </div>
</body>

</html>
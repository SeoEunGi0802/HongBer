<?php
include "config.php";
session_start();

if (isset($_SESSION['hislog'])) {
    $vemail = $_SESSION['hemail'];
} else if (isset($_SESSION['uislog'])) {
    $vemail = $_SESSION['uemail'];
} else if (isset($_SESSION['naver_access_token'])) {
    $vemail = $_SESSION['nemail'];
} else if (isset($_SESSION['kakao_access_token'])) {
    $vemail = $_SESSION['kemail'];
}

$email = $_GET['email'];
$today = date("Y-m-d");

$sql = "SELECT * FROM viewing WHERE viewing_email = '$vemail' AND beviewing_email = '$email'";
$res = $connect->query($sql);
$row = $res->fetch();

if (empty($row) && $email != $vemail) {
    $sql = "INSERT INTO viewing (viewing_email, beviewing_email, date)";
    $sql .= "VALUES('$vemail', '$email', '$today')";
    $res = $connect->query($sql);
} else {
    $sql = "UPDATE viewing SET date = '$today' WHERE viewing_email = '$vemail' AND beviewing_email = '$email'";
    $res = $connect->query($sql);
}

$updsql = "SET @COUNT = 0;";
$updsql .= "UPDATE viewing SET num = @COUNT:=@COUNT+1;";
$connect->query($updsql);

$sql = "SELECT * FROM hmatch WHERE hm_email = '$email'";
$res = $connect->query($sql);
$row = $res->fetch();
if (empty($row['hm_pimg'])) {
    $row['hm_pimg'] = "/hongber/css/image/bpimg.png";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/hongber/css/reset.css">
    <link rel="stylesheet" href="/hongber/css/more_info.css">
    <title>Document</title>
</head>

<body>
    <div id="wrap">
        <div class='honor_card'>
            <button class="plus" value='<?= $row['hm_email'] ?>' onclick=viewmatch(this.value)><img src="/hongber/css/image/plus.png"></button>
            <button class="knock_btn" onclick="knock('<?= $row['hm_name'] ?>', '<?= $row['hm_email'] ?>')" value="<?= $row['hm_email'] ?>">
                <div class='hm_thumb'><img src='<?= $row['hm_pimg'] ?>' class='mtping'></div>
            </button>
            <div class='hm_info'>
                <p class="hm_name">사업명: <?= $row['hm_name'] ?></p>
                <p class="hm_email">E-mail: <?= $row['hm_email'] ?></p>
            </div>
            <div class='hm_img'><img src="<?= $row['hm_upimg'] ?>"></div>
            <div class='hm_img2'><img src="<?= $row['hm_upimg'] ?>"></div>
            <textarea class='hm_comment' readonly><?= $row['hm_r'] ?></textarea>
            <div class='hm_date'>
                <p class="hm_sd_ed"><?= $row['hm_sd'] ?> ~ <?= $row['hm_ed'] ?></p>
            </div>
            <input type="hidden" class="hm_reday" value="<?= $row['hm_day'] ?>">
        </div>
    </div>
</body>

</html>
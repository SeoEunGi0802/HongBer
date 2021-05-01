<?php
include "config.php";
include "config2.php";
session_start();
//error_reporting(0);

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}
if (!isset($_SESSION['hislog'])) {
} else {
    $sp_email = $_SESSION['hemail'];
    $sd = $_POST['sd'];
    $ed = $_POST['ed'];
    $add = $_POST['add'];
    $prod = $_POST['prod'];
    $checklist = $_POST['checklist'];
    $recper = $_POST['recper'];
}

$sql = "INSERT INTO spread (spread_id, spread_sd, spread_ed, introduce_add, introduce_prod, checklist, bespread_num)";
$sql = $sql . "VALUES('$sp_email', '$sd', '$ed', '$add', '$prod', '$checklist', '$recper')";
$res = $connect->query($sql);
$updsql = "SET @COUNT = 0;";
$updsql .= "UPDATE spread SET num = @COUNT:=@COUNT+1;";
$connect->query($updsql);
echo "<script>alert('뿌리기 완료'); location.replace('/hongber/index.php');</script>";


// if (is_uploaded_file($_FILES['file']['tmp_name']) && getimagesize($_FILES['file']['tmp_name']) != false) {
//     $size = getimagesize($_FILES['file']['tmp_name']);
//     $type = $size['mime'];
//     $imgfp = fopen($_FILES['file']['tmp_name'], 'rb');
//     $size = $size[3];
//     $name = $_FILES['file']['name'];
//     $maxsize = 99999999;

//     if ($_FILES['file']['size'] < $maxsize) {
//         $stmt = $dbcon->prepare("UPDATE spread SET hm_upimg = ? WHERE hm_email = '$hm_email'");
//         $stmt->bindParam(1, $imgfp, PDO::PARAM_LOB);
//         $stmt->execute();

//         $sql2 = "SELECT * FROM spread WHERE hm_email = '$hm_email'";
//         $res2 = $connect->query($sql2);
//         $row2 = $res2->fetch();
//         $ti = 'data:image/png;base64,' . base64_encode($row2['hm_upimg']);
//         $stmt = $dbcon->prepare("UPDATE spread SET hm_upimg = ? WHERE hm_email = '$hm_email'");
//         $stmt->bindParam(1, $ti, PDO::PARAM_LOB);
//         $stmt->execute();

//         $sql3 = "UPDATE spread SET hm_r = '$hm_r', hm_sd = '$hm_sd', hm_ed = '$hm_ed'";
//         $res3 = $connect->query($sql3);
//     }
// }

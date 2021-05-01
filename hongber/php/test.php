<?php
include "config.php";

$usql = "SELECT COUNT(*) as cnt FROM user";
$nsql = "SELECT COUNT(*) as cnt FROM nuser";
$ksql = "SELECT COUNT(*) as cnt FROM kuser";
$ures = $connect->query($usql);
$nres = $connect->query($nsql);
$kres = $connect->query($ksql);
$urow = $ures->fetch();
$nrow = $nres->fetch();
$krow = $kres->fetch();
$unkrow =  $urow['cnt'] + $nrow['cnt'] + $krow['cnt'];
$rowall =  (int)$unkrow;

$sqlrand = "SELECT u_email as email FROM user UNION SELECT n_email FROM nuser UNION SELECT k_email FROM kuser order by rand()";
$resrand = $connect->query($sqlrand);
for ($i = 0; $i < $rowall; $i++) {
    $rowrand = $resrand->fetch();
    echo $i . " : " . $rowrand['email'] . "<br>";
}

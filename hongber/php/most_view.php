<?php
include "config.php";

date_default_timezone_set('Asia/Seoul');
$today = date("Y-m-d");

$sql = "SELECT beviewing_email FROM viewing WHERE date = '$today' GROUP BY beviewing_email ORDER BY COUNT(beviewing_email) DESC LIMIT 8";
$res = $connect->query($sql);
while ($row = $res->fetch()) {
    $beviewing_email = $row['beviewing_email'];
    $sql2 = "SELECT * FROM hmatch WHERE hm_email = '$beviewing_email'";
    $res2 = $connect->query($sql2);
    $row2 = $res2->fetch();
    if (empty($row2['hm_pimg'])) {
        $row2['hm_pimg'] = "/hongber/css/image/bpimg.png";
    }
?>
    <div class='hot_card'>
        <button class="hot_plus" value='<?= $row2['hm_email'] ?>' onclick=more(this.value)><img src="/hongber/css/image/plus.png"></button>
        <button class="hot_btn" onclick="knock('<?= $row2['hm_name'] ?>', '<?= $row2['hm_email'] ?>')" value="<?= $row2['hm_email'] ?>">
            <div class='hot_thumb'><img src='<?= $row2['hm_pimg'] ?>' class='mtping'></div>
        </button>
        <div class='hot_info'>
            <p class="hot_name"><?= $row2['hm_name'] ?></p>
            <p class="hot_email"><?= $row2['hm_email'] ?></p>
        </div>
        <div class='hot_img'><img src="<?= $row2['hm_upimg'] ?>"></div>
        <textarea class='hot_comment' readonly><?= $row2['hm_r'] ?></textarea>
        <div class='hot_date'>
            <p class="hot_sd_ed"><?= $row2['hm_sd'] ?> ~ <?= $row2['hm_ed'] ?></p>
        </div>
        <button class='send' id='send' value='<?= $row2['hm_email'] ?>' onclick=message(this.value)><img src="/hongber/css/image/matching.png"></button>
    </div>
<?php
}
?>
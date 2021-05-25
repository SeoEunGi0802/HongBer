<?php
include "config.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);

$today = date("Y-m-d H:i:s");
$timestamp = strtotime($today . " +13 hours -7 minute");
$today = date("Y-m-d", $timestamp);
$i = 1;

$sql = "SELECT beviewing_email FROM viewing WHERE date = '$today' GROUP BY beviewing_email ORDER by COUNT(beviewing_email) desc LIMIT 8";
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
    <!-- <div class="most<?= $i ?>">
        <div class='honor_card'>
            <button class="plus" value='<?= $row2['hm_email'] ?>' onclick=more(this.value)><img src="/hongber/css/image/plus.png"></button>
            <button class="knock_btn" onclick="knock('<?= $row2['hm_name'] ?>', '<?= $row2['hm_email'] ?>')" value="<?= $row2['hm_email'] ?>">
                <div class='hm_thumb'><img src='<?= $row2['hm_pimg'] ?>' class='mtping'></div>
            </button>
            <div class='hm_info'>
                <p class="hm_name"><?= $row2['hm_name'] ?></p>
                <p class="hm_email"><?= $row2['hm_email'] ?></p>
            </div>
            <div class='hm_img'><img src="<?= $row2['hm_upimg'] ?>"></div>
            <textarea class='hm_comment' readonly><?= $row2['hm_r'] ?></textarea>
            <div class='hm_date'>
                <p class="hm_sd_ed"><?= $row2['hm_sd'] ?> ~ <?= $row2['hm_ed'] ?></p>
            </div>
            <button class='send' id='send' value='<?= $row2['hm_email'] ?>' onclick=message(this.value)><img src="/hongber/css/image/matching.png"></button>
            <input type="hidden" class="hm_reday" value="<?= $row2['hm_day'] ?>">
        </div>
    </div> -->
<?php
    $i += 1;
}

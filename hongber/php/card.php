<?php
include "config.php";

if (isset($_POST['regday'])) {
    if ($_POST['regday'] == "R") {
        $sql = "SELECT * FROM hmatch ORDER BY hm_day";
    } else {
        $sql = "SELECT * FROM hmatch ORDER BY hm_day DESC";
    }
} else {
    $sql = "SELECT * FROM hmatch ORDER BY hm_day";
}

$result = $connect->query($sql);
while ($row = $result->fetch()) {
    if (empty($row['hm_pimg'])) {
        $row['hm_pimg'] = "/hongber/css/image/bpimg.png";
    }
?>
    <div class='honor_card'>
        <button class="knock_btn" onclick="knock('<?= $row['hm_name'] ?>', '<?= $row['hm_email'] ?>')" value="<?= $row['hm_email'] ?>">
            <div class='hm_thumb'><img src='<?= $row['hm_pimg'] ?>' class='mtping'></div>
        </button>
        <div class='hm_info'>
            <p class="hm_name"><?= $row['hm_name'] ?></p>
            <p class="hm_email"><?= $row['hm_email'] ?></p>
        </div>
        <div class='hm_img'><img src="<?= $row['hm_upimg'] ?>"></div>
        <textarea class='hm_comment' readonly><?= $row['hm_r'] ?></textarea>
        <div class='hm_date'>
            <p class="hm_sd_ed"><?= $row['hm_sd'] ?> ~ <?= $row['hm_ed'] ?></p>
        </div>
        <button class='send' id='send' value='<?= $row['hm_email'] ?>' onclick=message(this.value)><img src="/hongber/css/image/matching.png"></button>
        <input type="hidden" class="hm_reday" value="<?= $row['hm_day'] ?>">
    </div>
<?php
}
?>
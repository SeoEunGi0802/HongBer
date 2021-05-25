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

if (isset($_GET['c'])) {
    $cate = $_GET['c'];
    switch ($cate) {
        case 'cs':
            $sql = "SELECT * FROM hmatch WHERE category = 'SNS'";
            break;
        case 'cy':
            $sql = "SELECT * FROM hmatch WHERE category = 'YouTube'";
            break;
        case 'cw':
            $sql = "SELECT * FROM hmatch WHERE category = 'WEB'";
            break;
        case 'ca':
            $sql = "SELECT * FROM hmatch WHERE category = 'APP'";
            break;
        case 'cA':
            $sql = "SELECT * FROM hmatch WHERE category = 'categoryA'";
            break;
        case 'cB':
            $sql = "SELECT * FROM hmatch WHERE category = 'categoryB'";
            break;
        case 'cC':
            $sql = "SELECT * FROM hmatch WHERE category = 'categoryC'";
            break;
        default:
            //d
            break;
    }
}

$result = $connect->query($sql);
while ($row = $result->fetch()) {
    if (empty($row['hm_pimg'])) {
        $row['hm_pimg'] = "/hongber/css/image/bpimg.png";
    }
?>
    <div class='honor_card'>
        <button class="plus" value='<?= $row['hm_email'] ?>' onclick=more(this.value)><img src="/hongber/css/image/plus.png"></button>
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
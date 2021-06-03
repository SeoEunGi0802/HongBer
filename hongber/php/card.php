<?php
include "config.php";

if (isset($_POST['regday'])) {
    if ($_POST['regday'] == "R") {
        $sql = "SELECT * FROM hmatch WHERE hm_ed > DATE(NOW()) ORDER BY hm_day DESC";
    } else if ($_POST['regday'] == "O") {
        $sql = "SELECT * FROM hmatch WHERE hm_ed > DATE(NOW()) ORDER BY hm_day ASC";
    }
} else {
    $sql = "SELECT * FROM hmatch WHERE hm_ed >= DATE(NOW()) ORDER BY hm_day";
}

if (isset($_GET['c'])) {
    $cate = $_GET['c'];
    switch ($cate) {
        case 'SNS':
            $sql = "SELECT * FROM hmatch WHERE category = 'SNS' AND hm_ed > DATE(NOW())";
            break;
        case 'YouTube':
            $sql = "SELECT * FROM hmatch WHERE category = 'YouTube' AND hm_ed > DATE(NOW())";
            break;
        case 'WEB':
            $sql = "SELECT * FROM hmatch WHERE category = 'WEB' AND hm_ed > DATE(NOW())";
            break;
        case 'APP':
            $sql = "SELECT * FROM hmatch WHERE category = 'APP' AND hm_ed > DATE(NOW())";
            break;
        case 'entertainment':
            $sql = "SELECT * FROM hmatch WHERE category = 'entertainment' AND hm_ed > DATE(NOW())";
            break;
        case 'music':
            $sql = "SELECT * FROM hmatch WHERE category = 'music' AND hm_ed > DATE(NOW())";
            break;
        case 'video':
            $sql = "SELECT * FROM hmatch WHERE category = 'video' AND hm_ed > DATE(NOW())";
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
    if (!empty($row)) {
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
    } else {
        if (isset($_SESSION['hislog'])) {
        ?>
            <div class='res_none'>
                <p>광고를 등록 해보시는건 어떠세요?</p>
            </div>
        <?php
            break;
        } else {
        ?>
            <div class='res_none'>
                <p>아직 등록된 광고가 없어요.</p>
            </div>
<?php
            break;
        }
    }
}
?>
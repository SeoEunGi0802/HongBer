<?php
include "config.php";
session_start();

if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
}

$pwd = $_POST['pwd'];

if (isset($_SESSION['naver_access_token'])) {
    $nclient_id = "DRFaCS0hy5tsmm8uWjSH";
    $nclient_secret = "5ms9DI0XR5";
    $ntoken = $_SESSION['naver_access_token'];
    $nid = $_SESSION['nid'];
    $nname = $_SESSION['nname'];
    $nemail = $_SESSION['nemail'];

    $n_ch = curl_init();
    $n_is_post = false;
    $n_headers = array(
        'Content-Type: application/json', sprintf('Authorization: Bearer %s', $ntoken)
    );
    curl_setopt($n_ch, CURLOPT_URL, "https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id=$nclient_id&client_secret=$nclient_secret&access_token=$ntoken&service_provider=NAVER");
    curl_setopt($n_ch, CURLOPT_POST, $n_is_post);
    curl_setopt($n_ch, CURLOPT_HTTPHEADER, $n_headers);
    curl_setopt($n_ch, CURLOPT_RETURNTRANSFER, true);
    $n_response = curl_exec($n_ch);
    $n_status_code = curl_getinfo($n_ch, CURLINFO_HTTP_CODE);
    curl_close($n_ch);

    $sql = "DELETE FROM addwait WHERE wait_email = '$nemail' AND wait_name = '$nname'";
    $res = $connect->query($sql);

    $sql = "DELETE FROM mying WHERE mying_email = '$nemail' AND mying_name = '$nname'";
    $res = $connect->query($sql);

    $sql = "DELETE FROM myed WHERE myed_email = '$nemail' AND myed_name = '$nname'";
    $res = $connect->query($sql);

    $sql = "DELETE FROM nuser WHERE n_id = '$nid' AND n_name = '$nname' AND n_email = '$nemail' AND token = '$ntoken'";
    $res = $connect->query($sql);

    session_destroy();
    echo "<script>alert('회원탈퇴 되었습니다. 감사합니다.'); location.href='/hongber/index.php'</script>";
} else if (isset($_SESSION['kakao_access_token'])) {
    $ktoken = $_SESSION['kakao_access_token'];
    $kid = $_SESSION['kid'];
    $kname = $_SESSION['kname'];
    $kemail = $_SESSION['kemail'];

    $k_ch = curl_init();
    $k_is_post = false;
    $k_headers = array(
        'Content-Type: application/x-www-form-urlencoded', sprintf('Authorization: Bearer %s', $ktoken)
    );
    curl_setopt($k_ch, CURLOPT_URL, "https://kapi.kakao.com/v1/user/unlink");
    curl_setopt($k_ch, CURLOPT_POST, $k_is_post);
    curl_setopt($k_ch, CURLOPT_HTTPHEADER, $k_headers);
    curl_setopt($k_ch, CURLOPT_RETURNTRANSFER, true);
    $k_response = curl_exec($k_ch);
    $k_status_code = curl_getinfo($k_ch, CURLINFO_HTTP_CODE);
    curl_close($k_ch);

    $sql = "DELETE FROM addwait WHERE wait_email = '$kemail' AND wait_name = '$kname'";
    $res = $connect->query($sql);

    $sql = "DELETE FROM mying WHERE mying_email = '$kemail' AND mying_name = '$kname'";
    $res = $connect->query($sql);

    $sql = "DELETE FROM myed WHERE myed_email = '$kemail' AND myed_name = '$kname'";
    $res = $connect->query($sql);

    $sql = "DELETE FROM kuser WHERE k_id = '$kid' AND k_name = '$kname' AND k_email = '$kemail' AND token = '$ktoken'";
    $res = $connect->query($sql);

    session_destroy();
    echo "<script>alert('회원탈퇴 되었습니다. 감사합니다.'); location.href='/hongber/index.php'</script>";
} else if (isset($_SESSION['hislog'])) {
    if ($pwd != $_SESSION['hpwd'] || $pwd == null) {
        echo "<script>alert('현재 비밀번호가 일치하지 않습니다.'); history.back(-1);</script>";
    } else {
        $hid = $_SESSION['hid'];
        $hname = $_SESSION['hname'];
        $hemail = $_SESSION['hemail'];

        $sql = "DELETE FROM addwait WHERE adv_email = '$hemail' AND adv_name = '$hname'";
        $res = $connect->query($sql);

        $sql = "DELETE FROM hmatch WHERE hm_email = '$hemail' AND hm_name = '$hname'";
        $res = $connect->query($sql);

        $sql = "DELETE FROM mying WHERE mying_email = '$hemail' AND mying_name = '$hname'";
        $res = $connect->query($sql);

        $sql = "DELETE FROM myed WHERE myed_email = '$hemail' AND myed_name = '$hname'";
        $res = $connect->query($sql);

        $sql = "DELETE FROM hser WHERE h_id = '$hid' AND h_name = '$hname' AND h_email = '$hemail'";
        $res = $connect->query($sql);

        session_destroy();
        echo "<script>alert('회원탈퇴 되었습니다. 감사합니다.'); location.href='/hongber/index.php'</script>";
    }
} else if (isset($_SESSION['uislog'])) {
    if ($pwd != $_SESSION['upwd'] || $pwd == null) {
        echo "<script>alert('현재 비밀번호가 일치하지 않습니다.'); history.back(-1);</script>";
    } else {
        $uid = $_SESSION['uid'];
        $uname = $_SESSION['uname'];
        $uemail = $_SESSION['uemail'];

        $sql = "DELETE FROM addwait WHERE wait_email = '$uemail' AND wait_name = '$uname'";
        $res = $connect->query($sql);

        $sql = "DELETE FROM mying WHERE mying_email = '$uemail' AND mying_name = '$uname'";
        $res = $connect->query($sql);

        $sql = "DELETE FROM myed WHERE myed_email = '$uemail' AND myed_name = '$uname'";
        $res = $connect->query($sql);

        $sql = "DELETE FROM user WHERE u_id = '$uid' AND u_name = '$uname' AND u_email = '$uemail'";
        $res = $connect->query($sql);

        session_destroy();
        echo "<script>alert('{$uname}님 회원탈퇴 되었습니다. 감사합니다.'); location.href='/hongber/index.php'</script>";
    }
}

<?php
session_start();
session_destroy();
if (!isset($_SESSION['hislog']) && !isset($_SESSION['uislog']) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
    echo "<script>alert('로그인후 이용하실 수 있습니다.'); location.href='/hongber/index.php'</script>";
} else {
    echo "<script>alert('로그아웃 되었습니다.'); location.href='/hongber/index.php'</script>";
}
?>
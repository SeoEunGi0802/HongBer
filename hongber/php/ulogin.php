<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-In</title>
    <link rel="stylesheet" href="/hongber/css/reset.css">
    <link rel="stylesheet" href="/hongber/css/login.css">
    <script>
        function findid() {
            const width = '300';
            const height = '300';

            const left = Math.ceil((window.screen.width - width) / 2);
            const top = Math.ceil((window.screen.height - height) / 2);

            window.open('/hongber/html/ufindid.html', '아이디 찾기', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ',' + 'toolbars=no', 'scrollbars=no');
        }

        function findpwd() {
            const width = '300';
            const height = '300';

            const left = Math.ceil((window.screen.width - width) / 2);
            const top = Math.ceil((window.screen.height - height) / 2);

            window.open('/hongber/html/ufindpwd.html', '비밀번호 찾기', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ',' + 'toolbars=no', 'scrollbars=no');
        }
    </script>
</head>

<body>
    <div class="info_wrap">
        <div id="wrap">
            <!-- 상단 바 -->
            <header class="nav">
                <a href="/hongber/index.php">
                    <div class="logo">
                        <span>HONGBER</span><br>
                    </div>
                </a>
            </header>
            <form action="/hongber/php/ulog.php" method="POST">
                <input type="text" name="id" placeholder="아이디" class="id" autocomplete="off">
                <hr>
                <input type="password" name="pwd" placeholder="비밀번호" class="password">
                <hr>
                <input type="submit" class="login_btn" value="로그인">
            </form>
            <br>
            <div id="naverIdLogin">
                <?php
                // 네이버 로그인 접근토큰 요청 예제
                $client_id = "DRFaCS0hy5tsmm8uWjSH";
                $redirectURI = urlencode("http://localhost/hongber/php/naver_callbacklogin.php");
                function ngenerate_state()
                {
                    $mt = microtime();
                    $rand = mt_rand();
                    return md5($mt . $rand);
                }
                $state = ngenerate_state();
                $apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=" . $client_id . "&redirect_uri=" . $redirectURI . "&state=" . $state;
                ?>
                <a href="<?php echo $apiURL ?>">
                    <img height="50" src="http://static.nid.naver.com/oauth/big_g.PNG" /></a>
            </div>
            <br>
            <div id="KakaoIdLogin">
                <?php
                // 카카오 로그인 접근토큰 요청 예제
                $app_key = "1e244097dc165fec1a765891df0be219";
                $redirect_uri = "http://localhost/hongber/php/kakao_callbacklogin.php";
                function kgenerate_state()
                {
                    $mt = microtime();
                    $rand = mt_rand();
                    return md5($mt . $rand);
                }
                $state = kgenerate_state();
                $_SESSION['kakao_state'] = $state;
                $apiURL = "https://kauth.kakao.com/oauth/authorize?client_id=" . $app_key . "&redirect_uri=" . $redirect_uri . "&response_type=code&state=" . $state;
                ?>
                <a href="<?php echo $apiURL ?>">
                    <img id="Kakaoimg" src="https://developers.kakao.com/tool/resource/static/img/button/login/full/ko/kakao_login_large_narrow.png"></a>
            </div>
            <form>
                <div class="find_wrap">
                    <a href="#" onclick="findid()" class="find_id">
                        아이디 찾기
                    </a>
                    <a href="#" onclick="findpwd()" class="find_password">
                        비밀번호 찾기
                    </a>
                    <a href="/hongber/php/ber_reg.php" class="regist">
                        회원가입
                    </a>
                </div>
            </form>
        </div>
</body>

</html>
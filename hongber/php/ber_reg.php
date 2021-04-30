<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>회원가입</title>
	<link rel="stylesheet" href="/hongber/css/reset.css">
	<link rel="stylesheet" href="/hongber/css/ber_reg.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js">
	</script>
	<script type="text/javascript" src="https://static.nid.naver.com/js/naveridlogin_js_sdk_2.0.2.js" charset="utf-8">
	</script>
	<script src="https://developers.kakao.com/sdk/js/kakao.js">
	</script>
	<script>
		function inputPhoneNumber(obj) {
			var number = obj.value.replace(/[^0-9]/g, "");
			var phone = "";

			if (number.length < 4) {
				return number;
			} else if (number.length < 7) {
				phone += number.substr(0, 3);
				phone += "-";
				phone += number.substr(3);
			} else if (number.length < 11) {
				phone += number.substr(0, 3);
				phone += "-";
				phone += number.substr(3, 3);
				phone += "-";
				phone += number.substr(6);
			} else {
				phone += number.substr(0, 3);
				phone += "-";
				phone += number.substr(3, 4);
				phone += "-";
				phone += number.substr(7);
			}
			obj.value = phone;
		}
	</script>
</head>

<body>
	<!-- 상단 바 -->
	<header class="nav">
		<a href="/hongber/index.php">
			<div class="logo">
				<span>HONGBER</span>
			</div>
		</a>
	</header>
	<div class="info_wrap">
		<form action="/hongber/php/add_user.php" method="POST">
			<input type="id" name="id" placeholder="아이디" required><br>
			<hr>
			<input type="password" name="pwd" id="pwd" placeholder="비밀번호" required><br>
			<hr>
			<input type="password" name="rpwd" id="rpwd" placeholder="비밀번호 확인" required><br>
			<hr>
			<input type="name" name="name" placeholder="이름" required><br>
			<hr>
			<input type="tel" name="phone" placeholder="your phone number" required onKeyup="inputPhoneNumber(this)" maxlength="13"><br>
			<hr>
			<input type="email" name="email" placeholder="E-mail" required><br>
			<hr>
			<textarea cols="50" rows="20" placeholder="홍보하고 싶은 제품과 광고주 본인을 자신있게 어필해주세요!(최대 200자)" name="msg" maxlength="200"></textarea><br>
			<hr>
			<input type="submit" value="가입" class="submit"><br>
		</form>
	</div>
	<br>

	<!-- 네이버아이디로로그인 버튼 노출 영역 -->
	<div id="naverIdLogin">
		<?php
		// 네이버 로그인 접근토큰 요청 예제
		$client_id = "DRFaCS0hy5tsmm8uWjSH";
		$redirectURI = urlencode("http://localhost/php/naver_callback.php");
		function ngenerate_state()
		{
			$mt = microtime();
			$rand = mt_rand();
			return md5($mt . $rand);
		}
		$nstate = ngenerate_state();
		$_SESSION['naver_state'] = $nstate;
		$apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=" . $client_id . "&redirect_uri=" . $redirectURI . "&state=" . $nstate;
		?>
		<a href="<?php echo $apiURL ?>">
			<img height="50" src="http://static.nid.naver.com/oauth/big_g.PNG" /></a>
	</div>
	<br>

	<!-- 카카오아이디로로그인 버튼 노출 영역 -->
	<div id="KakaoIdLogin">
		<?php
		// 카카오 로그인 접근토큰 요청 예제	
		$app_key = "1e244097dc165fec1a765891df0be219";
		$redirect_uri = "http://localhost/php/kakao_callback.php";
		function kgenerate_state()
		{
			$mt = microtime();
			$rand = mt_rand();
			return md5($mt . $rand);
		}
		$kstate = kgenerate_state();
		$_SESSION['kakao_state'] = $kstate;
		$apiURL = "https://kauth.kakao.com/oauth/authorize?client_id=" . $app_key . "&redirect_uri=" . $redirect_uri . "&response_type=code&state=" . $kstate;
		?>
		<a href="<?php echo $apiURL ?>">
			<img id="Kakaoimg" src="https://developers.kakao.com/tool/resource/static/img/button/login/full/ko/kakao_login_medium_narrow.png"></a>
	</div>
	<!-- 카카오아이디로로그인 버튼 노출 영역 -->

	<!-- 비밀번호 일치 확인 스크립트 -->
	<script>
		$('#rpwd').focusout(function() {
			if ($('#pwd').val() != $('#rpwd').val()) {
				alert("비밀번호가 일치하지 않습니다.");
				document.getElementById('rpwd').value = "";
				$('#pwd').focus();
			} else {}

		});
	</script>
</body>

</html>
<?php
include "config.php";
session_start();
//error_reporting(0);

if ($_SESSION['naver_state'] != $_GET["state"]) {
	echo "에러" . $_GET["state"];
} else {

	$client_id = "DRFaCS0hy5tsmm8uWjSH";
	$client_secret = "5ms9DI0XR5";
	$code = $_GET["code"];
	$state = $_GET["state"];
	$redirectURI = urlencode("http://localhost/php/naver_callback.php");

	$url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=" . $client_id . "&client_secret=" . $client_secret . "&redirect_uri=" . $redirectURI . "&code=" . $code . "&state=" . $state;
	$is_post = false;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, $is_post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$headers = array();
	$response = curl_exec($ch);
	$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	if ($status_code == 200) {
		$responseArr = json_decode($response, true);

		$_SESSION['naver_access_token'] = $responseArr['access_token'];
		$_SESSION['naver_refresh_token'] = $responseArr['refresh_token'];


		// 토큰값으로 네이버 회원정보 가져오기
		$me_headers = array(
			'Content-Type: application/json', sprintf('Authorization: Bearer %s', $responseArr['access_token'])
		);

		$me_is_post = false;
		$me_ch = curl_init();
		curl_setopt($me_ch, CURLOPT_URL, "https://openapi.naver.com/v1/nid/me");
		curl_setopt($me_ch, CURLOPT_POST, $me_is_post);
		curl_setopt($me_ch, CURLOPT_HTTPHEADER, $me_headers);
		curl_setopt($me_ch, CURLOPT_RETURNTRANSFER, true);
		$me_response = curl_exec($me_ch);
		$me_status_code = curl_getinfo($me_ch, CURLINFO_HTTP_CODE);
		curl_close($me_ch);

		$me_responseArr = json_decode($me_response, true);

		$token = $responseArr['access_token'];
		$retoken = $responseArr['refresh_token'];

		// 필수 정보 제공을 동의 하지 않을시 연결된 서비스에 등록하지 않고 다시 가입 페이지로 돌아가도록 하기
		if (empty($me_responseArr['response']['name']) || empty($me_responseArr['response']['mobile']) || empty($me_responseArr['response']['email'])) {
			$me_ch = curl_init();
			curl_setopt($me_ch, CURLOPT_URL, "https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id=$client_id&client_secret=$client_secret&access_token=$token&service_provider=NAVER");
			curl_setopt($me_ch, CURLOPT_POST, $me_is_post);
			curl_setopt($me_ch, CURLOPT_HTTPHEADER, $me_headers);
			curl_setopt($me_ch, CURLOPT_RETURNTRANSFER, true);
			$me_response = curl_exec($me_ch);
			$me_status_code = curl_getinfo($me_ch, CURLINFO_HTTP_CODE);
			curl_close($me_ch);

			echo "<script>alert('필수 정보 제공을 동의해주세요.'); location.href='/hongber/php/ber_reg.php'</script>";
		} else {
			$id =  $me_responseArr['response']['id'];
			$name =  $me_responseArr['response']['name'];
			$phone =  $me_responseArr['response']['mobile'];
			$email =  $me_responseArr['response']['email'];
			if (empty($me_responseArr['response']['profile_image'])) {
				$pimg = "nul";
			} else {
				$pimg =  $me_responseArr['response']['profile_image'];
			}

			// 기존 유저 테이블에서 이름과 이메일을 검색하여 1개의 계정만 가지도록 하기
			// 카카오는 전화번호를 필수 항목으로 하지 못하여 이름과 이메일만을 검색
			$ksql = "SELECT * FROM kuser WHERE k_email = '$email'";
			$kres = $connect->query($ksql);
			$krow = $kres->fetch();

			$usql = "SELECT * FROM user WHERE u_email = '$email' OR u_phone = '$phone'";
			$ures = $connect->query($usql);
			$urow = $ures->fetch();

			$nsql = "SELECT * FROM nuser WHERE n_email = '$email' OR n_phone = '$phone'";
			$nres = $connect->query($nsql);
			$nrow = $nres->fetch();

			if (!empty($krow) || !empty($urow) || !empty($nrow)) {
				session_destroy();
				echo "<script>alert('이미 가입된 유저입니다.'); location.href='../index.php'</script>";
			} else {
				$sql = "insert into nuser (n_id, n_name, n_phone, n_email, n_pimg, token, rtoken)";
				$sql = $sql . "values('$id', '$name', '$phone', '$email', '$pimg', '$token', '$retoken')";

				if ($connect->query($sql)) {
					session_destroy();
					echo "<script>alert('{$name}님 등록되었습니다.'); location.href='../index.php'</script>";
				} else {
					echo "<script>alert('회원 가입에 실패하였습니다. 다시 시도해주세요.'); location.href='../index.php'</script>";
				}
			}
		}
	} else {
		session_destroy();
		echo "<script>alert('회원 가입에 실패하였습니다. 다시 시도해주세요.'); location.href='../index.php'</script>";
	}
}
?>
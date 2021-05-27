<?php
include "config.php";
session_start();

if ($_SESSION['kakao_state'] != $_GET["state"]) {
	echo "에러" . $_GET["state"];
} else {

	$appkey = "1e244097dc165fec1a765891df0be219";
	$code = $_GET["code"];
	$state = $_GET["state"];
	$redirectURL = urlencode("http://localhost/hongber/php/kakao_callback.php");
	$client_secret = "FhctorVXgFwalPCDZpuDnjad1RFwmOhG";

	$url = "https://kauth.kakao.com/oauth/token?grant_type=authorization_code&client_id=" . $appkey . "&redirect_uri=" . $redirectURL . "&code=" . $code . "&client_secret=" . $client_secret . "&state=" . $state;
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

		$_SESSION['kakao_access_token'] = $responseArr['access_token'];
		$_SESSION['kakao_refresh_token'] = $responseArr['refresh_token'];

		// 토큰값으로 카카오 회원정보 가져오기
		$me_headers = array(
			'Content-Type: application/json', sprintf('Authorization: Bearer %s', $responseArr['access_token'])
		);

		$me_is_post = false;
		$me_ch = curl_init();
		curl_setopt($me_ch, CURLOPT_URL, "https://kapi.kakao.com/v2/user/me");
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
		// 카카오는 검수요청이 통과가 되어야 전화번호를 요청할수 있고 이메일 또한 필수사항으로 되지 않기 때문에 이메일을 필수사항처럼 여기기
		if (empty($me_responseArr['properties']['nickname']) || empty($me_responseArr['kakao_account']['email'])) {
			$me_ch = curl_init();
			$me_headers = array(
				'Content-Type: application/x-www-form-urlencoded', sprintf('Authorization: Bearer %s', $responseArr['access_token'])
			);
			curl_setopt($me_ch, CURLOPT_URL, "https://kapi.kakao.com/v1/user/unlink");
			curl_setopt($me_ch, CURLOPT_POST, $me_is_post);
			curl_setopt($me_ch, CURLOPT_HTTPHEADER, $me_headers);
			curl_setopt($me_ch, CURLOPT_RETURNTRANSFER, true);
			$me_response = curl_exec($me_ch);
			$me_status_code = curl_getinfo($me_ch, CURLINFO_HTTP_CODE);
			curl_close($me_ch);

			echo "<script>alert('필수 정보 제공을 동의해주세요.(이메일 포함)'); location.href='/hongber/php/ber_reg.php'</script>";
		} else {
			// 카카오는 전화번호를 필수 항목으로 하지 못하여 이름과 이메일을 가져오도록 하기
			$id =  $me_responseArr['id'];
			$name =  $me_responseArr['properties']['nickname'];
			$email =  $me_responseArr['kakao_account']['email'];
			$pimg =  $me_responseArr['properties']['profile_image'];
		}

		// 기존 유저 테이블에서 이름과 이메일을 검색하여 1개의 계정만 가지도록 하기
		// 카카오는 전화번호를 필수 항목으로 하지 못하여 이름과 이메일만을 검색
		$ksql = "SELECT * FROM kuser WHERE k_email = '$email'";
		$kres = $connect->query($ksql);
		$krow = $kres->fetch();

		$usql = "SELECT * FROM user WHERE u_email = '$email'";
		$ures = $connect->query($usql);
		$urow = $ures->fetch();

		$nsql = "SELECT * FROM nuser WHERE n_email = '$email'";
		$nres = $connect->query($nsql);
		$nrow = $nres->fetch();

		if (!empty($krow) || !empty($urow) || !empty($nrow)) {
			session_destroy();
			echo "<script>alert('이미 가입된 유저입니다.'); location.href='../index.php'</script>";
		} else {
			$sql = "insert into kuser (k_id, k_name, k_email, k_pimg, token, rtoken)";
			$sql = $sql . "values('$id', '$name', '$email', '$pimg', '$token', '$retoken')";

			if ($connect->query($sql)) {
				session_destroy();
				echo "<script>alert('{$name}님 등록되었습니다.'); location.href='../index.php'</script>";
			} else {
				session_destroy();
				echo "<script>alert('회원 가입에 실패하였습니다. 다시 시도해주세요.'); location.href='../index.php'</script>";
			}
		}
	} else {
		session_destroy();
		echo "<script>alert('회원 가입에 실패하였습니다. 다시 시도해주세요.'); location.href='../index.php'</script>";
	}
}
?>
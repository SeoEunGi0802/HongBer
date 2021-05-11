<?php
include "config.php";
session_start();
//error_reporting(0);
error_reporting(E_ALL);
ini_set("display_errors", 1);

$appkey = "1e244097dc165fec1a765891df0be219";
$client_secret = "FhctorVXgFwalPCDZpuDnjad1RFwmOhG";
$code = $_GET["code"];
$state = $_GET["state"];
$redirectURL = urlencode("http://localhost/hongber/php/kakao_callbacklogin.php");

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

	$id =  $me_responseArr['id'];
	$token = $responseArr['access_token'];
	$retoken = $responseArr['refresh_token'];
	$email =  $me_responseArr['kakao_account']['email'];

	// DB에 저장된 접근토큰값 갱신
	$sql = "SELECT * FROM kuser WHERE k_id = '$id'";
	$res = $connect->query($sql);
	$row = $res->fetch();

	if ($row['token'] != $token) {
		$sql = "UPDATE kuser SET token = '$token', rtoken = '$retoken'";
		$res = $connect->query($sql);
	}

	$sql = "SELECT * FROM kuser WHERE token = '$token'";
	$res = $connect->query($sql);
	$row = $res->fetch();

	if (!empty($row)) {
		$name = $row['k_name'];
		$_SESSION['kname'] = $name;
		$_SESSION['kid'] = $id;
		$_SESSION['kemail'] = $email;
		echo "<script>alert('{$name}님 어서오세요!'); location.href='../index.php'</script>";
	} else {
		session_destroy();
		echo "<script>alert('등록되지 않은 사용자 입니다.'); location.href='../index.php'</script>";
	}
} else {
	session_destroy();
	echo "<script>alert('토큰값을 가져오지 못했습니다.'); location.href='../index.php'</script>";
}
?>
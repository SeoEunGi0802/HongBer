<?php
include "config.php";
session_start();
error_reporting(0);

$client_id = "DRFaCS0hy5tsmm8uWjSH";
$client_secret = "5ms9DI0XR5";
$code = $_GET["code"];
$state = $_GET["state"];
$redirectURI = urlencode("http://localhost/hongber/php/naver_callbacklogin.php");

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

	$id =  $me_responseArr['response']['id'];
	$token = $responseArr['access_token'];
	$retoken = $responseArr['refresh_token'];
	$email =  $me_responseArr['response']['email'];

	// DB에 저장된 접근토큰값 갱신
	$sql = "SELECT * FROM nuser WHERE n_id = '$id'";
	$res = $connect->query($sql);
	$row = $res->fetch();

	if ($row['token'] != $token) {
		$sql = "UPDATE nuser SET token = '$token', rtoken = '$retoken'";
		$res = $connect->query($sql);
	}

	$sql = "SELECT * FROM nuser WHERE token = '$token'";
	$res = $connect->query($sql);
	$row = $res->fetch();

	if (!empty($row)) {
		$name = $row['n_name'];
		$_SESSION['nname'] = $name;
		$_SESSION['nid'] = $id;
		$_SESSION['nemail'] = $email;
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
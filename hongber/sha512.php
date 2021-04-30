<?php
$config = 'C:\Bitnami\wampstack-8.0.3-1\php\extras\ssl';

$genRes = openssl_pkey_new(array(
    'config' => $config,
    'digest_alg' => "sha512",
    'private_key_bits' => 4096,
    'private_key_type' => OPENSSL_KEYTYPE_RSA,

));

// 개인키 생성
openssl_pkey_export($genRes, $privKey, NULL, array('config' => $config));

// 공개키 생성
$pubKeyArray = openssl_pkey_get_details($genRes);
$pubKey = $pubKeyArray['key'];

// 암호화
$plainText = "암호화 될 문자열";
openssl_public_encrypt($plainText, $encrypted, $pubKey);
$encryptedBase64 = base64_encode($encrypted);

// 복호화
openssl_private_decrypt(base64_decode($encryptedBase64), $decrypted, $privKey);

echo "평문 : " . $plainText . "<br />";
echo "암호화 : " . $encryptedBase64 . "<br />";
echo "복호화 : " . $decrypted . "<br />";
?>
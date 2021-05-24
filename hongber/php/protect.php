<?php
$config = 'hongber\openssl.cnf';

// 키 생성
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
$plainText = "lolove08@";
openssl_public_encrypt($plainText, $encrypted, $pubKey);
$encryptedBase64 = base64_encode($encrypted);

// 복호화
openssl_private_decrypt(base64_decode($encryptedBase64), $decrypted, $privKey);

echo "평문 : " . $plainText . "<br><br>";
echo "암호화 : " . "<p style='word-break:break-all'>" . $encryptedBase64 . "</p>";
echo "복호화 : " . $decrypted . "<br><br>";
echo "공개키 : " . "<p style='word-break:break-all'>" . $pubKey . "</p>";
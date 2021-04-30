<?php
class TBRsa {
	public $privateKey, $publicKey;
	public function __construct($pubKey='', $privKey='') {

		if($pubKey) $this->publicKey = $pubKey;
		if($privKey) $this->privateKey = $privKey;
	}
	public function MakeKey() {
		$res = openssl_pkey_new(array(
			"digest_alg" => "sha256",
			"private_key_bits" => 2048,
			"private_key_type" => OPENSSL_KEYTYPE_RSA
		));
		openssl_pkey_export($res, $privKey);
		$this->privateKey = $privKey;

		$pubKey = openssl_pkey_get_details($res);
		$this->publicKey = $pubKey['key'];
	}
	public function ViewKey() {
		return array('publicKey'=>$this->publicKey, 'privateKey'=>$this->privateKey);
	}
	public function Encrypt($data) {
		$pubKey = $this->publicKey;
		if(!$pubKey) die('공개키를 입력하세요.');
		openssl_public_encrypt($data, $encrypted, $pubKey);
		return base64_encode($encrypted);
	}
	public function Decrypt($data) {
		$privKey = $this->privateKey;
		if(!$privKey) die('개인키를 입력하세요.');
		$data = base64_decode($data);
		openssl_private_decrypt($data, $decrypted, $privKey);
		return $decrypted;
	}
}

$pb = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAx0sWpnpwQ6tGZV0KGgpuxTZXpretvCxuBWTxzZbC2hi86fz05f9PDtQHagHnn1bywNIieMOzbZ78Z/o178GVdAVz3nZyC2LxRxDd1ylZLJz0HWiUxR0t35S04Smr83KBFS4FqNPKrz8jTF3VyEfprtC4+2YK7nEN4agD1prsaUUsnqEORm0Amyh8TXxNCfSbKazvDYhGTXyWXH6AzHPnFyeNLo73DjibLRua8SvV0MjPjz2EUK/eRm7FzIBKSpOuGRITZBCHjYiHid6tJJ8GXQIvVR7dhPwtIvNvDc985OB03eZmL3hJZD3N4JF/ivaNWcO6DU+6EPgvNealkADi2QIDAQAB
-----END PUBLIC KEY-----'; // 공개키

$pv = '-----BEGIN PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDHSxamenBDq0Zl
XQoaCm7FNlemt628LG4FZPHNlsLaGLzp/PTl/08O1AdqAeefVvLA0iJ4w7Ntnvxn
+jXvwZV0BXPednILYvFHEN3XKVksnPQdaJTFHS3flLThKavzcoEVLgWo08qvPyNM
XdXIR+mu0Lj7ZgrucQ3hqAPWmuxpRSyeoQ5GbQCbKHxNfE0J9JsprO8NiEZNfJZc
foDMc+cXJ40ujvcOOJstG5rxK9XQyM+PPYRQr95GbsXMgEpKk64ZEhNkEIeNiIeJ
3q0knwZdAi9VHt2E/C0i828Nz3zk4HTd5mYveElkPc3gkX+K9o1Zw7oNT7oQ+C81
5qWQAOLZAgMBAAECggEBAIVgB2SbBI8FDTPBNIWA/ekWGUsGGkuZIHiTug/xGa6E
Z8ng9LUITIyL8fpMFAtbUVMiTtergWWXxSyBE5/FWpQvIgB8HI7qRLde3lik330v
/V/BIe9ZO94p03PtQ5rFwwW9qyP1uevWwXTWR8CmAApyvZniDObO2o9utkLlo9o+
tlzaLWPl4Thgfj+h2hdQJYVDFQ23offETMfikv7xHF78Giygu6BtcvP8n+4pyFyZ
fynCRakVsWZHcg1okpJrFprNqGPUJcrj20TyfctB9wFuqhAADkEirYESM318LHCl
HvbG5iSnAJrE+GPq7gNk++CDhZT+tTZoGyK/NAYUItECgYEA8BKwHf7+YCrBEw69
lZqrvNj6gMA82Rk9err8QB0fEBAu+iU96Zj83+yfbHcGi+4SEdJ/hOwq6qUuuqkZ
1ZtkYjoTenpBTpZ0uNWgjJIc80joaVkLaOY1mCdLye6AbyzbpJAsd6TlscFxWHVA
/Tt+6zIf0YE2fCgq0mL2wf7uZ1MCgYEA1IPQMWeztDljbUKSxHSeOGE5IS6c1uZH
EOndbeYyPmJHRTdu721KAAYYv0JQHZsTCIWof5hIj9JSFrycgRZkZ6SaI8vINX33
f42R22KICcQ+gE03xTUIGgQJxOw6PXtmndnwBX544UMXDqnvZcRNN1VhbV2K/7rT
AOnZpXrAY6MCgYEAvPqpAmPIz+C37Y2L9Wk0yUqwHou1GlyBBcyNZtbFrfpfUG/i
hbD1VjvI3zPuxlXYiYj+8p6Jxf3ThAI7IOfapGv9C0uTfw52wU0AvccC3QvGT69V
iPS2uZgtU77YASv5llgbeO8oFL4mwDBEwVKFPRVO8LdbMW7ZDpXykpFgD5sCgYAq
yyRIXpaMSyYfYVGGp+kYd1N2wBkrGRHkcQN61uj1MPsjEAeRxRMqsA+Zq/PQEmMh
yzBkCTlLZNHM7Ewjnmu3hyjW3nlBdE07bTma0NuOA+uGEIaTeptYCcoh0mPj7455
aOJxaMdUrRrehA/GEWJvKw1EZZrQ5kEJJQ4DyZUmOwKBgH7+lhffVhG67oPcqKAs
JdjP3rCDGckoZO6g7lONWiKzlgZHX8hb2SJjys6vW0+tE/1M3rdHG/Q/y5rV/IaK
vvIgKJy74uj6AJtbystK/1uqLmuVEYgN+5NJj9J2hSf30flel1xVOYxMQnjJ6LI7
cMxleiKYRi/4rc5OwKe3eVrK
-----END PRIVATE KEY-----'; // 개인키



$TE = new TBRsa($pb, $pv);
$en = $TE->Encrypt('와웅');
$dn = $TE->Decrypt($en);
echo $en.'<hr>';
echo $dn;

?>
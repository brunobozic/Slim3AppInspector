<?php

namespace App\Helpers;


class CurlHelper extends BaseHelper
{
	function curl_post($url, array $post = null, array $options = array())
	{
		$defaults = array(
			CURLOPT_POST           => 1,
			CURLOPT_HEADER         => 0,
			CURLOPT_URL            => $url,
			CURLOPT_FRESH_CONNECT  => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FORBID_REUSE   => 1,
			CURLOPT_TIMEOUT        => 4,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_POSTFIELDS     => http_build_query($post)
		);

		$ch = curl_init();
		curl_setopt_array($ch, ($options + $defaults));
		if ( ! $result = curl_exec($ch)) {
			trigger_error(curl_error($ch));
		}
		curl_close($ch);

		return $result;
	}

	/**
	 * Send a GET requst using cURL
	 * @param string $url     to request
	 * @param array  $get     values to send
	 * @param array  $options for cURL
	 * @return string
	 */
	function curl_get($url, array $get = null, array $options = array())
	{
		$defaults = array(
			CURLOPT_URL            => $url, //. (strpos($url, '?') === false ? '?' : '') . http_build_query($get),
			CURLOPT_HEADER         => 0,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_TIMEOUT        => 4
		);

		$ch = curl_init();
		curl_setopt_array($ch, ($options + $defaults));
		if ( ! $result = curl_exec($ch)) {
			var_dump($result);
			trigger_error(curl_error($ch));

		}
		curl_close($ch);

		return $result;
	}
}




//$curl = new Curl();
//$curl->setBasicAuthentication('username', 'password');
//$curl->setUserAgent('MyUserAgent/0.0.1 (+https://www.example.com/bot.html)');
//$curl->setReferrer('https://www.example.com/url?url=https%3A%2F%2Fwww.example.com%2F');
//$curl->setHeader('X-Requested-With', 'XMLHttpRequest');
//$curl->setCookie('key', 'value');
//$curl->get('https://www.example.com/');
//
//if ($curl->error) {
//	echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
//} else {
//	echo 'Response:' . "\n";
//	var_dump($curl->response);
//}
//
//var_dump($curl->requestHeaders);
//var_dump($curl->responseHeaders);
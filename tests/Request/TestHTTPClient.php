<?php
/**
 * Class TestHTTPClient
 *
 * @filesource   TestHTTPClient.php
 * @created      01.11.2017
 * @package      chillerlan\OAuthTest\Request
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Request;

use chillerlan\OAuth\HTTP\{
	CurlClient, GuzzleClient, HTTPClientAbstract, OAuthResponse, StreamClient, TinyCurlClient
};

use chillerlan\TinyCurl\{
	Request, RequestOptions
};

use GuzzleHttp\Client;

class TestHTTPClient extends HTTPClientAbstract{

	const CFGDIR        = __DIR__.'/../../config';
	const UA            = 'chillerlanPhpOAuth/2.0.0 +https://github.com/codemasher/php-oauth';
	const SLEEP_SECONDS = 1.0;

	/**
	 * @var \chillerlan\OAuth\HTTP\HTTPClientInterface
	 */
	protected $http;

	public function __construct(){
		$this->http = new GuzzleClient(new Client(['cacert' => self::CFGDIR.'/cacert.pem', 'headers' => ['User-Agent' => self::UA]]));
#		$this->http = new TinyCurlClient(new Request(new RequestOptions(['ca_info' => self::CFGDIR.'/cacert.pem', 'userAgent' => self::UA])));
#		$this->http = new CurlClient([CURLOPT_CAINFO => self::CFGDIR.'/cacert.pem', CURLOPT_USERAGENT => self::UA]);
#		$this->http = new StreamClient(self::CFGDIR.'/cacert.pem', self::UA);
	}

	/**
	 * @param string $url
	 * @param array  $params
	 * @param string $method
	 * @param mixed  $body
	 * @param array  $headers
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 */
	public function request(string $url, array $params = null, string $method = null, $body = null, array $headers = null):OAuthResponse{
		$args = func_get_args();
#		print_r($args);

		$response = $this->http->request(...$args);

#		print_r($response);

		usleep(self::SLEEP_SECONDS * 1000000);

		return $response;
	}

}

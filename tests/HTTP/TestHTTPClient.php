<?php
/**
 * Class TestHTTPClient
 *
 * @filesource   TestHTTPClient.php
 * @created      01.11.2017
 * @package      chillerlan\OAuthTest\HTTP
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\HTTP;

use chillerlan\OAuth\HTTP\{
	CurlClient, GuzzleClient, HTTPClientAbstract, OAuthResponse, StreamClient, TinyCurlClient
};

use chillerlan\TinyCurl\{
	Request, RequestOptions
};

use GuzzleHttp\Client;

class TestHTTPClient extends HTTPClientAbstract{

	const CFGDIR  = __DIR__.'/../../config';
	const UA      = 'chillerlanPhpOAuth/1.2.0 +https://github.com/codemasher/php-oauth';
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
	public function request(string $url, array $params = [], string $method = 'POST', $body = null, array $headers = []):OAuthResponse{
		$args = func_get_args();
		print_r($args);

		usleep(500000);
		return $this->http->request(...$args);
	}

}

<?php
/**
 * Class TinyCurlClient
 *
 * @filesource   TinyCurlClient.php
 * @created      09.07.2017
 * @package      chillerlan\OAuth\HTTP
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\HTTP;

use chillerlan\OAuth\OAuthException;
use chillerlan\TinyCurl\{Request, URL};

class TinyCurlClient extends HTTPClientAbstract{

	/**
	 * @var \chillerlan\TinyCurl\Request
	 */
	protected $http;

	/**
	 * TinyCurlClient constructor.
	 *
	 * @param \chillerlan\TinyCurl\Request $http
	 */
	public function __construct(Request $http){
		$this->http = $http;
	}

	/**
	 * @param string $url
	 * @param array  $params
	 * @param string $method
	 * @param mixed  $body
	 * @param array  $headers
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function request(string $url, array $params = [], string $method = 'POST', $body = null, array $headers = []):OAuthResponse{

		parse_str(parse_url($url, PHP_URL_QUERY), $query);

		$params = array_merge($query, $params);

		try{
			$url = new URL(explode('?', $url)[0], $params, $method, $body, $headers);

			$response = $this->http->fetch($url);

			return new OAuthResponse([
				'headers' => $response->headers,
				'body'    => $response->body->content,
			]);

		}
		catch(\Exception $e){
			throw new OAuthException('fetch error: '.$e->getMessage());
		}

	}

}

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
	 * @throws \chillerlan\OAuth\HTTP\HTTPClientException
	 */
	public function request(string $url, array $params = [], string $method = 'POST', $body = null, array $headers = []):OAuthResponse{

		try{

			$parsedURL = parse_url($url);

			if(!isset($parsedURL['host']) || !in_array($parsedURL['scheme'], ['http', 'https'])){
				trigger_error('invalid URL');
			}

			$url      = new URL(explode('?', $url)[0], $params, $method, $body, $headers);
			$response = $this->http->fetch($url);

			return new OAuthResponse([
				'headers' => $response->headers,
				'body'    => $response->body->content,
			]);

		}
		catch(\Exception $e){
			throw new HTTPClientException('fetch error: '.$e->getMessage());
		}

	}

}

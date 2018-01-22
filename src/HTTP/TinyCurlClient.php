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

/**
 * @property \chillerlan\TinyCurl\Request $http
 */
class TinyCurlClient extends HTTPClientAbstract{

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
	public function request(string $url, array $params = null, string $method = null, $body = null, array $headers = null):OAuthResponse{

		try{

			$parsedURL = parse_url($url);

			if(!isset($parsedURL['host']) || $parsedURL['scheme'] !== 'https'){
				trigger_error('invalid URL');
			}

			$response = $this->http->fetch(new URL(
				explode('?', $url)[0],
				$params ?? [],
				$method ?? 'POST',
				$body,
				$headers ?? []
			));

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

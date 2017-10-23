<?php
/**
 * Class GuzzleClient
 *
 * @filesource   GuzzleClient.php
 * @created      23.10.2017
 * @package      chillerlan\OAuth\HTTP
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\HTTP;

use chillerlan\OAuth\OAuthException;
use GuzzleHttp\Client;
use Psr\Http\Message\StreamInterface;

class GuzzleClient extends HTTPClientAbstract{

	/**
	 * @var \GuzzleHttp\Client
	 */
	protected $http;

	/**
	 * GuzzleClient constructor.
	 *
	 * @param \GuzzleHttp\Client $http
	 */
	public function __construct(Client $http){
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

		try{

			$parsedURL = parse_url($url);
			$method = strtoupper($method);

			if(!isset($parsedURL['host']) || !in_array($parsedURL['scheme'], ['http', 'https'], true)){
				trigger_error('invalid URL');
			}

			// @link http://docs.guzzlephp.org/en/stable/request-options.html
			$options = [
				'query' => $params,
				'headers' => $headers
			];

			if(in_array($method, ['PATCH', 'POST', 'PUT', 'DELETE'], true)){

				if(in_array($method, ['PATCH', 'POST', 'PUT'], true) && is_array($body)){
					$options['form_params'] = $body;
				}
				elseif(is_string($body) || $body instanceof StreamInterface){
					$options['body'] = $body;
				}

			}

			$r = $this->http->request($method, explode('?', $url)[0], $options);

			return new OAuthResponse([
				'headers' => $this->parseResponseHeaders($r->getHeaders()),
				'body'    => $r->getBody(),
			]);

		}
		catch(\Exception $e){
			throw new OAuthException('fetch error: '.$e->getMessage());
		}

	}

	/**
	 * @param array $headers
	 *
	 * @return \stdClass
	 */
	protected function parseResponseHeaders(array $headers):\stdClass {
		$h = new \stdClass;

		foreach($headers as $k => $v){
			$h->{strtolower($k)} = $v[0] ?? null;
		}

		return $h;
	}

}
